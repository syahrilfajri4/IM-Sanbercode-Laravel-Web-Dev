<?php
defined('BASEPATH') or exit('No direct script access allowed');

class m_mrp extends CI_Model { 
    //menampilkan semua data Mrp
    public function getAll()
    {
        $tahun = date("Y");
        $bulan = date('n');

        $period = ceil($bulan / 3); // Menentukan periode berdasarkan bulan
        
        $cat = $this->input->post('kategori', TRUE);
        $ref = $this->input->post('ref', TRUE);
        $periode = $this->input->post('periode', TRUE);

        if (!empty($cat)) {
            return $this->db->query("
                SELECT * 
                FROM mrp 
                WHERE kanban = ? 
                AND periode = ? 
                AND tahun = ? 
                AND kategori = ?", array($ref, $periode, $tahun, $cat))->result();
        } else {
            return $this->db->query("
                SELECT id_part, id_alokasi, stok, kanban, kategori, barang, satuan, 
                    SUM(kebutuhan) AS kebutuhan, 
                    SUM(mrp.order) AS `order`, 
                    SUM(alokasi) AS alokasi 
                FROM mrp 
                WHERE tahun = ? AND periode = ? 
                GROUP BY mrp.id_part", array($tahun, $period))->result();
        }
    }

    //menampilkan semua data MRP
    public function getAll_bc()
    {
        $tahun = date("Y");
        $bulan = date("n");
        $periode = ceil($bulan / 3);

        return $this->db->query("
            SELECT * 
            FROM mrp 
            WHERE tahun = ? 
            AND periode = ?", array($tahun, $periode))->result();
    }

    // mengambil kode komponen (Kode_Komp) dari tabel bom_komponen
    public function get_id_pro()
    {
        $id_mp = $this->input->post('id_mp', TRUE);
        $part = $this->input->post('idpart', TRUE);

        if (empty($id_mp) || empty($part)) {
            return null;
        }

        $query = $this->db->query("
            SELECT Kode_Komp 
            FROM bom_komponen 
            WHERE `Kode Part` = ? 
            AND `ID Master Produk` = ?", array($part, $id_mp));

        return $query->row();
    }
    
    // Model (m_mrp.php)
    // public function get_detail_mrp($id)
    // {
    //     $this->db->where('id_alokasi', $id);
    //     return $this->db->get('mrp')->row_array();
    // }

    public function get_detail_mrp($id){
        return $this->db->query("SELECT * FROM mrp WHERE id_alokasi='$id'");
    }

    public function input_wo($id_kode_komp)
    {
        $this->db->trans_start(); // Mulai transaksi

        $id = $this->input->post('id');
        $id_barang = $this->input->post('idpart');
        $barang_jadi = $this->input->post('brg');
        $jml = $this->input->post('wo');
        $no_ref = $this->input->post('Ref');
        $mps = $this->input->post('kanban');
        $tahun = $this->input->post('tahun');
        $periode = $this->input->post('periode');

        // Insert ke tabel erp_master_plan_sche
        $this->db->insert('erp_master_plan_sche', [
            'Product' => $id_barang,
            'Plan Qty' => $jml,
            'Ref No' => $no_ref,
            'Periode' => $periode,
            'ID MPS' => $mps,
            'Status' => '2'
        ]);

        // Insert ke tabel alokasi_pmt_spk_ppic
        $this->db->insert('alokasi_pmt_spk_ppic', [
            'kode_barang' => $id_barang,
            'id_kanban' => $mps,
            'qty_pmt' => '0',
            'qty_spk' => $jml,
            'jenis' => 'SPK',
            'keterangan' => ''
        ]);

        // Update jumlah WO
        $q1 = $this->db->select('wo as wo_lama')
                        ->from('alokasi_plan_proto')
                        ->where('id', $id)
                        ->get();
        if ($q1->num_rows() > 0) {      
            $data = $q1->row();
            $wo_lama = intval($data->wo_lama); 
        }

        $update_wo = $wo_lama + $jml;
        $this->db->where('id', $id)
                ->update('alokasi_plan_proto', ['wo' => $update_wo]);

        // Ambil nomor tahap terakhir
        $q4 = $this->db->select('COUNT(*) as baris')
                        ->from('erp_aktivitasproduksi_proto')
                        ->where('ID Kanban', $mps)
                        ->get()
                        ->row();
        $no_tahap = $q4->baris;

        // Ambil kode preparasi
        $q6 = $this->db->select('*')
                        ->from('bom_baru_proto')
                        ->where('Kode Part', $id_barang)
                        ->where('Kode Produk', $barang_jadi)
                        ->where('id_tahap IS NOT NULL')
                        ->where('id_tahap <> 0')
                        ->get()
                        ->result();
        foreach ($q6 as $tahap) {
            $no_tahap++;
            $no_tahapspk = str_pad($no_tahap, 4, '0', STR_PAD_LEFT);
            $mps_fix = str_pad($mps, 4, '0', STR_PAD_LEFT);
            $spk = $tahun . $mps_fix . $no_tahapspk;
            $jml_tahap = $jml * $tahap->Jumlah;
            $this->db->insert('erp_aktivitasproduksi_proto', [
                'ID Kanban' => $mps,
                'ID Tahap' => $tahap->ID,
                'ID Komponen' => $tahap->Kode_Preparasi,
                'Jumlah' => $jml_tahap,
                'Tanggal Plan' => date('Y-m-d H:i:s'), // Menggunakan PHP date untuk waktu saat ini
                'Tanggal Mulai' => '',
                'Status' => 'aktif',
                'Tahun' => $tahun,
                'Barcode_Series' => $spk,
                'ID Produk' => $id_barang
            ]);
        }

        $this->db->trans_complete(); // Selesaikan transaksi

        if ($this->db->trans_status() === FALSE) {
            // Jika ada kesalahan, rollback transaksi
            show_error('Terjadi kesalahan dalam proses penyimpanan data.');
        }
    }

    // PMT
    // UNTUK INPUT PMT SEMENTARA
    public function input_po_sementara()
    {
        $wo = 0;
        $id = $this->input->post('id');
        $id_barang = $this->input->post('idpart');
        $jml = $this->input->post('po');
        $mps = $this->input->post('kanban');
        $tgl_butuh = $this->input->post('tgl_butuh');
        $ket_po = $this->input->post('keterangan_po');
        $cat = $this->input->post('kategori');

        // INSERT KE TABLE alokasi_pmt_spk_ppic
        $this->db->query(
            "INSERT INTO alokasi_pmt_spk_ppic (kode_barang, id_kanban, qty_pmt, qty_spk, jenis, `status`, keterangan) 
            VALUES (?, ?, ?, 0, 'PMT', 'OPEN', '')", 
            array($id_barang, $mps, $jml)
        );

        // QUERY UNTUK UPDATE TABLE alokasi_plan_proto
        $q1 = $this->db->query("SELECT po as po_lama FROM alokasi_plan_proto WHERE id = ?", array($id));

        $po_lama = 0;
        if($q1->num_rows() > 0)
        {      
            $data = $q1->row();
            $po_lama = intval($data->po_lama); 
        }

        $update_po = $po_lama + intval($jml);
        $this->db->query("UPDATE alokasi_plan_proto SET po = ? WHERE id = ?", array($update_po, $id));

        // INSERT KE TABLE t_pmtppic_sementara
        $this->db->query(
            "INSERT INTO t_pmtppic_sementara (id_brg, qty, keterangan, tgl_dibutuhkan, dept, kategori) 
            VALUES (?, ?, ?, ?, '4', ?)", 
            array($id_barang, $jml, $ket_po, $tgl_butuh, $cat)
        );
    }
//
    // TAMPIL DATA PMT SEMENTARA
    public function pmt_sementara()
    {
        $query = $this->db->get('detail_pmtppic_sementara');
        return $query->result();
    }

    // UNTUK INPUT PO
    // public function input_po()
    // {
    //     $wo = 0;
    //     $id = $this->input->post('id');
    //     $id_barang = $this->input->post('idpart');
    //     $jml = $this->input->post('po');
    //     $mps = $this->input->post('kanban');
    //     $tgl_butuh = $this->input->post('tgl_butuh');
    //     $ket_po = $this->input->post('keterangan_po');
    //     $cat = $this->input->post('kategori');

    //     // BUAT NOMOR PMT (HEAD)
    //     $show_series = "PMT";
    //     $series_tanggal = $show_series . date('/m/Y');

    //     $tahun = date('Y');

    //     $q1 = $this->db->query("SELECT LEFT(`pmt_ppic`.`no_pmt`, 3) as nomor FROM pmt_ppic WHERE YEAR(`Created_at`) = ? ORDER BY ID DESC", array($tahun));

    //     if ($q1->num_rows() > 0) {      
    //         $data = $q1->row();
    //         $kode = intval($data->nomor) + 1; 
    //     } else {      
    //         $kode = 1;  
    //     }

    //     $nomor_pmt = str_pad($kode, 3, "0", STR_PAD_LEFT);
    //     $pmt = $nomor_pmt . $series_tanggal;

    //     // INSERT NOMOR PMT KE TABLE pmt_ppic
    //     $this->db->query("INSERT INTO pmt_ppic (no_pmt, id_pmtwh) VALUES (?, ?)", array($pmt, '1'));

    //     // SELECT id DARI TABLE pmt_ppic
    //     $q2 = $this->db->query("SELECT id FROM pmt_ppic ORDER BY id DESC LIMIT 1")->row();
    //     $id_pmtppic = $q2->id;

    //     // Ambil data dari detail_pmtppic_sementara
    //     $q3 = $this->db->query("SELECT * FROM detail_pmtppic_sementara")->result();
    //     foreach ($q3 as $data) {
    //         // INSERT KE TABLE t_pmtppic
    //         $this->db->query("INSERT INTO t_pmtppic (id_pmtppic, id_brg, qty, keterangan, tgl_dibutuhkan, `status`, dept, kategori) VALUES (?, ?, ?, ?, ?, ?, ?, ?)", 
    //             array($id_pmtppic, $data->id_brg, $data->qty, $data->keterangan, $data->tgl_dibutuhkan, '', $data->dept, $data->kategori));
    //     }
    // }

        // UNTUK INPUT PO
        public function input_po()
        {
            $wo = 0;
            $id = $this->input->post('id');
            $id_barang = $this->input->post('idpart');
            $jml = $this->input->post('po');
            $mps = $this->input->post('kanban');
            $tgl_butuh = $this->input->post('tgl_butuh');
            $ket_po = $this->input->post('keterangan_po');
            $cat = $this->input->post('kategori');
    
            // BUAT NOMOR PMT (HEAD)
            $show_series = "PMT";
            $tanggal = $this->db->query("SELECT date_format(curdate(),'/%m/%Y') as date")->row();
            $series_tanggal = $show_series.$tanggal->date;
    
            $tahun = date('Y');
            
            $q1 = $this->db->query("SELECT LEFT(`pmt_ppic`.`no_pmt`, 3) as nomor FROM pmt_ppic where date_format(pmt_ppic.`Created_at`,'%Y') = $tahun ORDER BY ID DESC");
    
            if($q1->num_rows() > 0)
            {      
                $data = $q1->row();
                $kode = intval($data->nomor) + 1; 
            }
            else
            {      
                $kode = 1;  
            }
    
            $nomor_pmt = str_pad($kode,3,"0",STR_PAD_LEFT);
            $no_pmt = $nomor_pmt;
            $pmt = $no_pmt."/".$series_tanggal;
    
            // INSERT NOMOR PMT KE TABLE pmt_ppic
            $this->db->query("INSERT INTO pmt_ppic (no_pmt, id_pmtwh) VALUES ('$pmt', '1')");
    
            // SELECT id DARI TABLE pmt_ppic
            $q2 = $this->db->query("SELECT id from pmt_ppic order by id desc limit 1")->row();
            $id_pmtppic = $q2->id;
    
            $q3 = $this->db->query("SELECT * from detail_pmtppic_sementara")->result();
            foreach($q3 as $data)
            {
                // INSERT KE TABLE t_pmtppic
                $this->db->query("INSERT INTO t_pmtppic (`id_pmtppic`, id_brg, qty, keterangan, tgl_dibutuhkan, `status`, dept, kategori) VALUES ('$id_pmtppic', '$data->id_brg', '$data->qty', '$data->keterangan', '$data->tgl_dibutuhkan', '', '$data->dept', '$data->kategori')");
            }
        }


    // UNTUK TRUNCATE TABLE t_pmtppic_sementara
    public function truncate_t_pmtppic_sementara()
    {
        return $this->db->truncate("t_pmtppic_sementara");
    }

    // BPB ALOKASI
    // UNTUK INPUT BPB SEMENTARA
    public function input_bpb_sementara()
    {
        $id = $this->input->post('id');
        $id_barang = $this->input->post('idpart');
        $jml = $this->input->post('alokasi');
        $mps = $this->input->post('kanban');
        $user = $this->input->post('penerima');
        $ket_alokasi = $this->input->post('keterangan');

        // QUERY UNTUK UPDATE TABLE alokasi_plan_proto
        $q1 = $this->db->query("SELECT alokasi as alokasi_lama FROM alokasi_plan_proto WHERE id = '$id'");

        if($q1->num_rows() > 0)
        {      
            $data = $q1->row();
            $alokasi_lama = intval($data->alokasi_lama); 
        }

        $update_alokasi = $alokasi_lama + $jml;
        $this->db->query("UPDATE alokasi_plan_proto SET alokasi = '$update_alokasi' WHERE id = '$id'");

        // SELECT NOMOR SPK DARI TABLE erp_aktivitasproduksi_proto
        $q2 = $this->db->query("SELECT Barcode_Series as no_spk FROM `erp_aktivitasproduksi_proto` where `ID Tahap` IN(418,1855) AND `ID Kanban` = '$mps'")->row();
        $no_spk = $q2->no_spk;

        // INPUT KE TABLE bpb_sementara
        $this->db->query("INSERT INTO bpb_sementara (id_brg, jumlah, kanban, nomor_spk, keterangan, user) VALUES ('$id_barang', '$jml', '$mps', '$no_spk', '$ket_alokasi', '$user')");
    }

    // TAMPIL DETAIL BPB SEMENTARA
    function bpb_sementara()
    {
        return $this->db->query("SELECT * FROM detail_bpb_sementara")->result();
    }

    public function input_alokasi()
    {
        $id = $this->input->post('id');
        $id_barang = $this->input->post('idpart');
        $jml = $this->input->post('po');
        $mps = $this->input->post('kanban');
        $user = $this->input->post('penerima');
        $ket_alokasi = $this->input->post('keterangan');

        // INSERT KE TABLE pbb
        $tgl = DATE('Y-m-d');
        $q1 = $this->db->query("SELECT nomor_spk, departemen, keterangan, user FROM detail_bpb_sementara")->row();

        $this->db->query("INSERT INTO pbb (nospk, tgl, divisi, ket, user) VALUES ('$q1->nomor_spk', '$tgl', '$q1->departemen', '$q1->keterangan', '$q1->user')");

        // INSERT KE TABLE t_ppb
        $q2 = $this->db->query("SELECT id FROM pbb order by id desc limit 1")->row();
        $idppb = $q2->id;
        
        $q3 = $this->db->query("SELECT * FROM detail_bpb_sementara")->result();
        foreach($q3 as $data)
        {
            $this->db->query("INSERT INTO t_ppb (idppb, idbrg, jmlh, ket) VALUES ('$idppb', '$data->id_brg', '$data->jumlah', '$data->keterangan')");
        }
    }

    // UNTUK TRUNCATE TABLE bpb_sementara
    public function truncate_bpb_sementara()
    {
        return $this->db->truncate("bpb_sementara");
    }

    public function kode_barang() 
    {
        return $this->db->query("SELECT * FROM inventory WHERE Category NOT IN('Barang Jadi Rehab', 'Barang Jadi Furniture', 'Finish Goods') AND id_fina <> 0.0")->result();
    }


    // BPB KUSTOMISASI
    function bpb_sementara_kustom()
    {
        $spk = $_GET['barcode'];
        return $this->db->query("SELECT * FROM detail_bpb_sementara WHERE nomor_spk = '$spk'")->result();
    }

    function bpb_kustom1()
    {
        $id_barang = $this->input->post('id_brg');
        $jml = $this->input->post('qty');
        $spk = $this->input->post('spk');
    
        // AMBIL NOMOR SPK
        $q1 = $this->db->query("SELECT `ID Kanban` as kanban FROM erp_aktivitasproduksi_proto WHERE Barcode_Series = '$spk'")->row();
        $kanban = $q1->kanban;

        // INPUT KE TABLE alokasi_plan
        $this->db->query("INSERT INTO bpb_sementara (id_brg, jumlah, kanban, nomor_spk) VALUES ('$id_barang', '$jml', '$kanban', '$spk')");
    }

    public function input_kustom1()
    {
        // INSERT KE TABLE pbb
        $tgl = DATE('Y-m-d');
        $q1 = $this->db->query("SELECT nomor_spk FROM detail_bpb_sementara")->row();
        $q2 = $this->db->query("SELECT Divisi FROM cek_divisi WHERE Barcode_Series = $q1->nomor_spk")->row();
        $cek_divisi = $q2->Divisi;
        if($cek_divisi == 'Preparasi') {
            $divisi = 1;
        }
        elseif($cek_divisi == 'Welding') {
            $divisi = 2;
        }
        elseif($cek_divisi == 'PC') {
            $divisi = 4;
        }
        elseif($cek_divisi == 'Poles') {
            $divisi = 5;
        }
        elseif($cek_divisi == 'Assembling Rehab') {
            $divisi = 6;
        }
        elseif($cek_divisi == 'Assembling Hospital') {
            $divisi = 7;
        }
        elseif($cek_divisi == 'Solid Tire') {
            $divisi = 8;
        }
        elseif($cek_divisi == 'M Shop') {
            $divisi = 9;
        }
        elseif($cek_divisi == 'MMS') {
            $divisi = 40;
        }
        else {
            $divisi = 0;
        }

        $this->db->query("INSERT INTO pbb (nospk, tgl, divisi, ket, user) VALUES ('$q1->nomor_spk', '$tgl', '$divisi', '-', '0')");

        // INSERT KE TABLE t_ppb
        $q3 = $this->db->query("SELECT id FROM pbb order by id desc limit 1")->row();
        $idppb = $q3->id;
        
        $q4 = $this->db->query("SELECT * FROM detail_bpb_sementara")->result();
        foreach($q4 as $data)
        {
            $this->db->query("INSERT INTO t_ppb (idppb, idbrg, jmlh, ket) VALUES ('$idppb', '$data->id_brg', '$data->jumlah', '$data->keterangan')");
        }
    }

    public function count_order()
    {
        // Query untuk menghitung jumlah baris di mana kolom 'order' lebih besar dari nol
        $query = "
            SELECT COUNT(*) AS total
            FROM mrp
            WHERE `order` > 0
        ";
        return $this->db->query($query)->row()->total;
    }

    public function delete_data($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('bpb_sementara'); // Ganti dengan nama tabel Anda
    }
}