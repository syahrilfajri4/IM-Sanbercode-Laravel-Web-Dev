<?php
class m_inventory extends CI_Model
{
    public $data; // Deklarasikan properti ini
    
    public function __construct() {
        parent::__construct();
        $this->data = []; // Inisialisasi sebagai array
    }

    // Metode untuk mengatur aturan validasi
    public function rule_jip()
    {
        $rules = [
            [
                'field' => 'barang',
                'label' => 'Produk',
                'rules' => 'required'
            ],
            [
                'field' => 'jumlah',
                'label' => 'Kuantitas',
                'rules' => 'numeric'
            ],
            [
                'field' => 'periode',
                'label' => 'Periode',
                'rules' => 'required'
            ]
        ];

        return $rules;
    } 

    //menampilkan semua data MPS
    public function getAll($cat = null, $status = null, $periode = null, $tahun = null)
    {
        $year = date('Y');
        $bulan = date('n');
    
        // Menentukan periode jika tidak diinput
        if(empty($periode)) {
            if(($bulan >= 1) AND ($bulan <= 3)) {
                $period = 1;
            } elseif (($bulan >= 4) AND ($bulan <= 6)) {
                $period = 2;
            } elseif (($bulan >= 7) AND ($bulan <= 9)) {
                $period = 3;
            } else {
                $period = 4;
            }
        } else {
            $period = $periode;
        }
    
        if(empty($tahun)) {
            $tahun = $year;
        }
    
        if(empty($status) || $status == 2){
            $status = 2; 
        } else if ($status == 1) {
            $status = 1;
        }
    
        if(!empty($cat)) {
            if($cat == 'fg') {
                // Ambil data dari plan1
                return $this->db->select('ID, Barang, Kuantitas, NoRef, STATUS, Category')
                                ->from('plan1')
                                ->where('STATUS', $status)
                                ->where('Periode', $period)
                                ->where('tahun', $tahun)
                                ->where_in('Category', ['Barang Jadi Rehab', 'Barang Jadi Furniture', 'Finish Goods'])
                                ->get()
                                ->result();
            } 
            else if($cat == 'comp') {
                // Ambil data dari plan2
                return $this->db->select('PlanID as ID, ItemName as Barang, Quantity as Kuantitas, RefNo as NoRef, PlanStatus as STATUS, Category')
                                ->from('plan2')
                                ->where('PlanStatus', $status)
                                ->where('Period', $period)
                                ->where('Tahun', $tahun)
                                ->where_in('Category', ['Preparation', 'Component'])
                                ->get()
                                ->result();
            }
        } else {
            // Query default dari plan1
            return $this->db->select('ID, Barang, Kuantitas, NoRef, STATUS, Category')
                            ->from('plan1')
                            ->where('STATUS', $status)
                            ->where('Periode', $period)
                            ->where('tahun', $tahun)
                            ->where_in('Category', ['Barang Jadi Rehab', 'Barang Jadi Furniture', 'Finish Goods'])
                            ->get()
                            ->result();
        }
    }

    //tampil tabel barang co 2024 saja
    public function getCo(){
        return $this->db->query("SELECT t_co.ID, `inventory`.`Series` as series, `inventory`.`ItemName` as barang, t_co.sisa, inventory.stok, t_co.deadline 
            FROM `t_co` 
            JOIN inventory ON inventory.ID = t_co.ID_brg
            WHERE YEAR(t_co.deadline) = 2024
            ORDER BY `t_co`.`deadline` DESC")->result();
    }

    // Bagian JIP
    // Tampil barang dan series untuk JIP
    public function getBarang() {
        $cat = $this->input->post('kategori'); // Ambil nilai kategori dari $_POST['kategori']
        
        if (empty($cat) || $cat == 'fg') {
            // Ambil barang dari tabel tampil_bom
            return $this->db->select('ID, IF(Series != "", Series, `Item Name`) as Series, `Item Name` as ItemName')
                ->from('tampil_bom')
                ->where_in('Category', ['Barang Jadi Rehab', 'Barang Jadi Furniture', 'Finish Goods'])
                ->order_by('ID', 'ASC')
                ->get()
                ->result();
        } elseif ($cat == 'comp') {
            // Ambil komponen dari tabel produksi_inventory
            return $this->db->select('iD as ID, `Item Name` as ItemName') // Periksa penamaan kolom 'iD'
                ->from('produksi_inventory')
                ->where_in('Category', ['Preparation', 'Component'])
                ->order_by('ID', 'ASC')
                ->get()
                ->result();
        }
        return []; // Mengembalikan array kosong jika tidak ada kategori yang cocok
    }
    
    // Metode untuk menyimpan data JIP
    public function JIPinput()
    {
        $id_barang = $this->input->post('barang');
        $jml = $this->input->post('jumlah');
        $periode = $this->input->post('periode');

        // Inisialisasi variabel untuk Product dan Custom_Product sebagai null
        $custom_product = null;
        $product = null;

        // Mendapatkan kategori barang dari tabel tampil_bom
        $kat_bom = $this->db->query("SELECT Category FROM tampil_bom WHERE ID = '$id_barang'")->row();

        // Mendapatkan kategori barang dari tabel produksi_inventory
        $kat_inventory = $this->db->query("SELECT Category FROM produksi_inventory WHERE iD = '$id_barang'")->row();

        // Menentukan sumber barang dan field tujuan (Product atau Custom_Product)
        if ($kat_bom) {
            // Barang dari tabel tampil_bom, isi field Product
            $product = $id_barang;
            $show_series = ($kat_bom->Category == 'Barang Jadi Rehab' || $kat_bom->Category == 'Barang Jadi Furniture' || $kat_bom->Category == 'Finish Goods') 
                ? 'FG' 
                : $this->db->query("SELECT Series FROM tampil_bom WHERE ID = '$id_barang'")->row()->Series;
        } elseif ($kat_inventory) {
            // Barang dari tabel produksi_inventory, isi field Custom_Product
            $custom_product = $id_barang;
            $show_series = 'KOMP';
        }

        // Mendapatkan tanggal dalam format yang diinginkan
        $tanggal = $this->db->query("SELECT DATE_FORMAT(CURDATE(), '/%m/%y') as date")->row();
        $series_tanggal = isset($show_series) ? $show_series . $tanggal->date : 'UNK' . $tanggal->date;

        // Mendapatkan tahun saat ini
        $tahun = date('Y');

        // Mendapatkan nomor referensi terakhir untuk tahun berjalan
        $q1 = $this->db->query("
            SELECT LEFT(`Ref No`, 3) as nomor
            FROM `erp_master_plan_sche`
            WHERE DATE_FORMAT(`Created Date`, '%Y') = '$tahun'
            ORDER BY iD DESC
        ");

        if ($q1->num_rows() > 0) {
            $data = $q1->row();
            $kode = intval($data->nomor) + 1;
        } else {
            $kode = 1;
        }

        // Membentuk nomor referensi dengan padding 3 digit
        $referensi = str_pad($kode, 3, "0", STR_PAD_LEFT);
        $no_ref = $referensi . "/" . $series_tanggal;

        // Menyusun query insert berdasarkan sumber barang
        $this->db->query("
            INSERT INTO `erp_master_plan_sche` (`Product`, `Plan Qty`, `Ref No`, `Periode`, `Status`, `Custom_Product`)
            VALUES (
                " . ($product !== null ? "'$product'" : "NULL") . ",
                '$jml',
                '$no_ref',
                '$periode',
                1,
                " . ($custom_product !== null ? "'$custom_product'" : "NULL") . "
            )
        ");

        // Mengembalikan nomor referensi yang baru saja dimasukkan
        return $no_ref;
    }

    //===================
    public function get_produksi_inventory() {
        $query = $this->db->query("
            SELECT iD, `Item Name` as ItemName
            FROM `produksi_inventory`
            WHERE `Category` IN ('Preparation', 'Component')
            ORDER BY `iD` ASC
        ");
        return $query->result(); // Mengembalikan hasil dalam bentuk array objek
    }

    public function aktivasi_mps() {
        $kanban = $this->input->get('id_mps');
    
        // Mulai transaksi
        $this->db->trans_begin();
    
        // Ambil informasi kanban untuk Product dan Custom_Product
        $kanbaninfo = $this->db->query("
            SELECT 
                Product, 
                Custom_Product, 
                `Plan Qty` AS qty 
            FROM erp_master_plan_sche 
            WHERE ID = ?", array($kanban))->row();
    
        if (!$kanbaninfo) {
            // Rollback transaksi jika informasi kanban tidak ditemukan
            $this->db->trans_rollback();
            return;
        }
    
        $qty = $kanbaninfo->qty;
    
        // Aktivasi Plan 1 jika Product tersedia
        if (!empty($kanbaninfo->Product)) {
            $product = $kanbaninfo->Product;
            $mp_id = $this->db->query("SELECT * FROM ppic_master_produk WHERE `Kode Produk` = ?", array($product))->row();
    
            if ($mp_id) {
                $parts = $this->db->query("SELECT `Kode Part` AS kd_part, Jumlah FROM ppic_tmaster_part WHERE `ID Master Produk` = ?", array($mp_id->ID))->result();
    
                foreach ($parts as $part) {
                    $total = $part->Jumlah * $qty;
                    $this->db->query("INSERT INTO alokasi_plan_proto (id_part, kanban, kebutuhan, id_master_produk) VALUES (?, ?, ?, ?)", array($part->kd_part, $kanban, $total, $product));
                }
    
                // Perbarui status untuk Product
                $this->db->query("UPDATE erp_master_plan_sche SET `Status` = 2 WHERE ID = ? AND Product IS NOT NULL", array($kanban));
            }
        }
    
        // Aktivasi Plan 2 jika Custom_Product tersedia
        if (!empty($kanbaninfo->Custom_Product)) {
            $custom_product = $kanbaninfo->Custom_Product;
    
            // Perbarui status untuk Custom_Product
            $this->db->query("UPDATE erp_master_plan_sche SET `Status` = 2 WHERE ID = ? AND Custom_Product IS NOT NULL", array($kanban));
        }
    
        // Cek status transaksi
        if ($this->db->trans_status() === FALSE) {
            // Rollback jika ada error
            $this->db->trans_rollback();
        } else {
            // Commit jika tidak ada error
            $this->db->trans_commit();
        }
    }

    public function getSPK_rekap()
    {
        // Ambil parameter id_mps dari URL
        $kanban = $this->input->get('id_mps');
        
        // Ambil informasi produk dan ID MPS dari tabel erp_master_plan_sche
        $kanbaninfo = $this->db->query("SELECT Product, `ID MPS` AS id_mps1 FROM erp_master_plan_sche WHERE ID = ?", array($kanban))->row();
        $produk = $kanbaninfo->Product;
        $mps = $kanbaninfo->id_mps1;
        
        // Lakukan query untuk mendapatkan data produksi terkait dengan kanban dan produk
        $query = $this->db->query("SELECT 
            erp_aktivitasproduksi_proto.ID,
            erp_aktivitasproduksi_proto.`ID Kanban`,
            erp_aktivitasproduksi_proto.`ID Tahap` as tahap, 
            erp_aktivitasproduksi_proto.`ID Produk`, 
            erp_tahapproduksi.WS, 
            erp_workstation.Divisi as divisi 
            FROM `erp_aktivitasproduksi_proto` 
            LEFT JOIN erp_tahapproduksi ON erp_tahapproduksi.ID = erp_aktivitasproduksi_proto.`ID Tahap`
            LEFT JOIN erp_workstation ON erp_workstation.ID = erp_tahapproduksi.WS
            WHERE `ID Kanban` = ? AND `ID Produk` = ?", array($mps, $produk));
        
        // Mengembalikan hasil query sebagai array objek
        return $query->result();
    }

    public function getSPK_dtl()
    {
        // Ambil parameter id_mps dari URL
        $kanban = $this->input->get('id_mps');
        
        // Ambil informasi produk dan ID MPS dari tabel erp_master_plan_sche
        $kanbaninfo = $this->db->query("SELECT Product, `ID MPS` AS id_mps1 FROM erp_master_plan_sche WHERE ID = ?", array($kanban))->row();
        $produk = $kanbaninfo->Product;
        $mps = $kanbaninfo->id_mps1;
        
        // Lakukan query untuk mendapatkan data dari tabel list_spk berdasarkan kanban dan id_produk
        $query = $this->db->query("SELECT * FROM list_spk WHERE kanban = ? AND id_produk = ?", array($mps, $produk));
        
        // Mengembalikan hasil query sebagai array objek
        return $query->result();
    }

    public function getSPK_divisi($divisi)
    {
        // Ambil parameter id_mps dari URL
        $kanban = $this->input->get('id_mps');
        
        // Ambil informasi produk dan ID MPS dari tabel erp_master_plan_sche
        $kanbaninfo = $this->db->query("SELECT Product, `ID MPS` AS id_mps1 FROM erp_master_plan_sche WHERE ID = ?", array($kanban))->row();
        $produk = $kanbaninfo->Product;
        $mps = $kanbaninfo->id_mps1;
        
        // Lakukan query untuk mendapatkan data dari tabel list_spk berdasarkan kanban, id_produk, dan divisi
        $query = $this->db->query("SELECT * FROM list_spk WHERE kanban = ? AND id_produk = ? AND divisi = ?", array($mps, $produk, $divisi));
        
        // Mengembalikan hasil query sebagai array objek
        return $query->result();
    }

    public function update_SPK_divisi($barcode)
    {
        // Mengatur zona waktu ke Asia/Bangkok
        date_default_timezone_set("Asia/Bangkok");
        
        // Mendapatkan waktu saat ini dalam format Y-m-d H:i:s
        $tgl_mulai = date('Y-m-d H:i:s');
        
        // Memperbarui kolom 'Tanggal Mulai' di tabel erp_aktivitasproduksi_proto berdasarkan barcode
        $this->db->query("UPDATE erp_aktivitasproduksi_proto SET `Tanggal Mulai` = ? WHERE Barcode_Series = ?", array($tgl_mulai, $barcode));
        
        // Mendapatkan data divisi dari tabel metu_spk berdasarkan barcode
        $cetak = $this->db->query("SELECT metu_spk.Divisi FROM metu_spk WHERE spk = ?", array($barcode))->result();
        
        // Memasukkan entri baru ke tabel log_cetak_spk berdasarkan data yang didapat
        foreach($cetak as $item) {
            $this->db->query("INSERT INTO log_cetak_spk (nomor_spk, divisi) VALUES (?, ?)", array($barcode, $item->Divisi));
        }
    }

    // public function tampil_divisi_cetak()
    // {
    //     // Melakukan query untuk menghitung jumlah SPK berdasarkan divisi
    //     $query = $this->db->query("
    //         SELECT metu_spk.Divisi, COUNT(metu_spk.Divisi) AS jumlah_spk, log_cetak_spk.status_cetak 
    //         FROM metu_spk
    //         JOIN log_cetak_spk ON log_cetak_spk.nomor_spk = metu_spk.spk
    //         WHERE log_cetak_spk.tgl_cetak IS NULL AND log_cetak_spk.status_cetak = 1
    //         GROUP BY metu_spk.Divisi
    //     ");
        
    //     // Mengembalikan hasil query sebagai array objek
    //     return $query->result();
    // }
    public function tampil_divisi_cetak() {
        return $this->db->query("SELECT metu_spk.Divisi, count(metu_spk.Divisi) as jumlah_spk, log_cetak_spk.status_cetak FROM `metu_spk`
        join log_cetak_spk on log_cetak_spk.nomor_spk = metu_spk.spk
        WHERE log_cetak_spk.tgl_cetak is null and log_cetak_spk.status_cetak = 1
        GROUP BY metu_spk.Divisi")->result();
    }

    public function update_status_cetak($divisi)
    {
        // Mengatur zona waktu ke Asia/Bangkok
        date_default_timezone_set("Asia/Bangkok");
        
        // Mendapatkan waktu saat ini dalam format Y-m-d H:i:s
        $tgl_cetak = date('Y-m-d H:i:s');
        
        // Melakukan update status_cetak dan tgl_cetak di tabel log_cetak_spk berdasarkan divisi
        $this->db->query("
            UPDATE log_cetak_spk 
            SET status_cetak = 2, tgl_cetak = ? 
            WHERE divisi = ? AND tgl_cetak IS NULL
        ", array($tgl_cetak, $divisi));
        
        // Mengembalikan hasil query sebagai boolean
        return $this->db->affected_rows() > 0;
    }

    public function head_spk_cetak($divisi)
    {
        // Menyiapkan query untuk mengambil data dari tabel metu_spk dan log_cetak_spk berdasarkan divisi
        $query = "
            SELECT 
                metu_spk.ID, metu_spk.kanban, metu_spk.noref, metu_spk.nama_ws, metu_spk.Jumlah, 
                metu_spk.Unit, metu_spk.produk, ROUND(metu_spk.estimasi_dtk/60) AS estimasi, metu_spk.mesin, 
                metu_spk.op, metu_spk.id_tahap, metu_spk.proses, metu_spk.id_comp, metu_spk.nabar, 
                metu_spk.tgl_plan, metu_spk.tgl_mulai, metu_spk.Status, metu_spk.Tahun, metu_spk.Keterangan, 
                metu_spk.id_div, metu_spk.spk, metu_spk.Divisi, log_cetak_spk.status_cetak 
            FROM metu_spk
            JOIN log_cetak_spk ON log_cetak_spk.nomor_spk = metu_spk.spk
            WHERE log_cetak_spk.divisi = ? AND log_cetak_spk.status_cetak = 1 AND log_cetak_spk.tgl_cetak IS NULL
        ";
        
        // Menjalankan query dengan parameter binding
        return $this->db->query($query, array($divisi))->row();
    }

    public function tampil_spk_cetak($divisi)
    {
        // Menyiapkan query untuk mengambil data dari tabel metu_spk dan log_cetak_spk berdasarkan divisi
        $query = "
            SELECT 
                metu_spk.ID, metu_spk.kanban, metu_spk.nama_ws, metu_spk.Jumlah, metu_spk.Unit, metu_spk.produk, 
                ROUND(metu_spk.estimasi_dtk/60) AS estimasi, metu_spk.mesin, metu_spk.op, metu_spk.id_tahap, 
                metu_spk.proses, metu_spk.id_comp, metu_spk.nabar, metu_spk.tgl_plan, metu_spk.tgl_mulai, 
                metu_spk.Status, metu_spk.Tahun, metu_spk.Keterangan, metu_spk.id_div, metu_spk.spk, 
                metu_spk.Divisi, log_cetak_spk.status_cetak 
            FROM metu_spk
            JOIN log_cetak_spk ON log_cetak_spk.nomor_spk = metu_spk.spk
            WHERE log_cetak_spk.divisi = ? AND log_cetak_spk.status_cetak = 1 AND log_cetak_spk.tgl_cetak IS NULL
        ";
        
        // Menjalankan query dengan parameter binding
        return $this->db->query($query, array($divisi))->result();
    }

    // Plan Assembling
    public function plan_assy($kanban)
    {
        // Menyiapkan query untuk mengambil data dari tabel erp_aktivitasproduksi_proto, user, dan log_cetak_spk berdasarkan kanban
        $query = "
            SELECT
                erp_aktivitasproduksi_proto.ID,
                erp_aktivitasproduksi_proto.`ID Kanban` AS kanban,
                erp_aktivitasproduksi_proto.`ID Mesin` AS mesin,
                erp_aktivitasproduksi_proto.`ID Operator` AS operator,
                employee.NAMA AS nama_operator,
                erp_aktivitasproduksi_proto.`ID Tahap` AS tahap,
                erp_aktivitasproduksi_proto.`ID Komponen` AS komponen,
                erp_aktivitasproduksi_proto.Jumlah AS jml,
                erp_aktivitasproduksi_proto.`Tanggal Mulai` AS tanggal_tugas,
                erp_aktivitasproduksi_proto.`Barcode_Series` AS spk,
                log_cetak_spk.status_cetak
            FROM
                erp_aktivitasproduksi_proto
            LEFT JOIN employee ON employee.ID = erp_aktivitasproduksi_proto.`ID Operator`
            LEFT JOIN log_cetak_spk ON log_cetak_spk.nomor_spk = erp_aktivitasproduksi_proto.`Barcode_Series`
            WHERE
                erp_aktivitasproduksi_proto.`ID Tahap` IN (418, 419) AND
                erp_aktivitasproduksi_proto.`ID Kanban` = ?
            ORDER BY spk ASC
        ";

        // Menjalankan query dengan parameter binding
        return $this->db->query($query, array($kanban))->result();
    }

    // Plan Assembling Top
    public function plan_assy_top($kanban)
    {
        // Menyiapkan query untuk mengambil data dari tabel erp_aktivitasproduksi_proto, erp_master_plan_sche, dan inventory
        $query = "
            SELECT
                erp_aktivitasproduksi_proto.ID,
                erp_aktivitasproduksi_proto.`ID Kanban` AS kanban,
                erp_master_plan_sche.Product AS produk,
                inventory.Series AS series,
                inventory.`Item Name` AS nama_produk,
                erp_master_plan_sche.`Plan Qty` AS jumlah_plan,
                inventory.Unit AS satuan,
                erp_master_plan_sche.`Ref No` AS ref_no
            FROM
                erp_aktivitasproduksi_proto
            JOIN erp_master_plan_sche ON erp_master_plan_sche.ID = erp_aktivitasproduksi_proto.`ID Kanban`
            JOIN inventory ON inventory.ID = erp_master_plan_sche.Product
            WHERE
                erp_aktivitasproduksi_proto.`ID Kanban` = ?
            GROUP BY
                erp_aktivitasproduksi_proto.`ID Kanban`
        ";

        // Menjalankan query dengan parameter binding
        return $this->db->query($query, array($kanban))->row();
    }

    //plan assy rakit dan kompon
    public function input_assy_rakit($kanban) {
        // Log awal
        log_message('info', 'Start input_assy_rakit with kanban: ' . $kanban);
    
        // Validasi
        if (empty($kanban)) {
            log_message('error', 'Kanban is empty');
            return;
        }
    
        $query = "SELECT COUNT(*) as baris FROM erp_aktivitasproduksi_proto WHERE `ID Kanban` = ?";
        $q1 = $this->db->query($query, array($kanban))->row();
    
        $query = "SELECT `ID Kanban` as kanban FROM erp_aktivitasproduksi_proto WHERE `ID Kanban` = ? GROUP BY `ID Kanban`";
        $no_mps = $this->db->query($query, array($kanban))->row();
    
        $query = "SELECT Product FROM erp_master_plan_sche WHERE ID = ?";
        $id_komp = $this->db->query($query, array($kanban))->row();
    
        $tahun = date('Y');
        $mps = str_pad($no_mps->kanban, 4, '0', STR_PAD_LEFT);
        $no_tahap = $q1->baris + 1;
        $no_tahapspk = str_pad($no_tahap, 4, '0', STR_PAD_LEFT);
        $spk = $tahun . $mps . $no_tahapspk;
    
        $tgl_tugas = $this->input->post('tgl_tugas');
        $operator_rakit = $this->input->post('operator1');
        $jumlah = $this->input->post('jumlah');
        $id_rakit = 418;
        $id_komponen = $id_komp->Product;
    
        // Cek apakah data sudah ada
        $query = "SELECT * FROM erp_aktivitasproduksi_proto WHERE `ID Kanban` = ? AND `ID Operator` = ? AND `Tanggal Mulai` = ?";
        $existing = $this->db->query($query, array($kanban, $operator_rakit, $tgl_tugas))->row();
    
        if (!$existing) {
            try {
                // Lakukan INSERT
                $query = "
                    INSERT INTO erp_aktivitasproduksi_proto 
                    (`ID Kanban`, `ID Komponen`, `Tanggal Mulai`, `ID Operator`, `ID Tahap`, `Jumlah`, `Barcode_Series`, `Tahun`)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)
                ";
                $this->db->query($query, array($kanban, $id_komponen, $tgl_tugas, $operator_rakit, $id_rakit, $jumlah, $spk, $tahun));
    
                // Log sukses
                log_message('info', 'Data successfully inserted into erp_aktivitasproduksi_proto');
            } catch (Exception $e) {
                log_message('error', 'Error inserting data: ' . $e->getMessage());
            }
        } else {
            log_message('info', 'Data already exists in erp_aktivitasproduksi_proto');
        }
    
        // Menyiapkan query untuk INSERT ke tabel log_cetak_spk
        $query = "SELECT Divisi FROM metu_spk WHERE spk = ?";
        $cek_divisi = $this->db->query($query, array($spk))->row();
        $divisi = $cek_divisi->Divisi;
    
        try {
            $query = "
                INSERT INTO log_cetak_spk (`nomor_spk`, `divisi`)
                VALUES (?, ?)
            ";
            $this->db->query($query, array($spk, $divisi));
    
            // Log sukses
            log_message('info', 'Data successfully inserted into log_cetak_spk');
        } catch (Exception $e) {
            log_message('error', 'Error inserting data into log_cetak_spk: ' . $e->getMessage());
        }
    }
    
    public function input_assy_kompon($kanban) {
        // Log awal
        log_message('info', 'Start input_assy_kompon with kanban: ' . $kanban);
    
        // Validasi
        if (empty($kanban)) {
            log_message('error', 'Kanban is empty');
            return;
        }
    
        $query = "SELECT COUNT(*) as baris FROM erp_aktivitasproduksi_proto WHERE `ID Kanban` = ?";
        $q1 = $this->db->query($query, array($kanban))->row();
    
        $query = "SELECT `ID Kanban` as kanban FROM erp_aktivitasproduksi_proto WHERE `ID Kanban` = ? GROUP BY `ID Kanban`";
        $no_mps = $this->db->query($query, array($kanban))->row();
    
        $query = "SELECT Product FROM erp_master_plan_sche WHERE ID = ?";
        $id_komp = $this->db->query($query, array($kanban))->row();
    
        $tahun = date('Y');
        $mps = str_pad($no_mps->kanban, 4, '0', STR_PAD_LEFT);
        $no_tahap = $q1->baris + 1;
        $no_tahapspk = str_pad($no_tahap, 4, '0', STR_PAD_LEFT);
        $spk = $tahun . $mps . $no_tahapspk;
    
        $tgl_tugas = $this->input->post('tgl_tugas');
        $operator_kompon = $this->input->post('operator2');
        $jumlah = $this->input->post('jumlah');
        $id_kompon = 419;
        $id_komponen = $id_komp->Product;
    
        try {
            // Lakukan INSERT
            $query = "
                INSERT INTO erp_aktivitasproduksi_proto 
                (`ID Kanban`, `ID Komponen`, `Tanggal Mulai`, `ID Operator`, `ID Tahap`, `Jumlah`, `Barcode_Series`, `Tahun`)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)
            ";
            $this->db->query($query, array($kanban, $id_komponen, $tgl_tugas, $operator_kompon, $id_kompon, $jumlah, $spk, $tahun));
    
            // Log sukses
            log_message('info', 'Data successfully inserted into erp_aktivitasproduksi_proto');
        } catch (Exception $e) {
            log_message('error', 'Error inserting data: ' . $e->getMessage());
        }
    
        // Menyiapkan query untuk INSERT ke tabel log_cetak_spk
        $query = "SELECT Divisi FROM metu_spk WHERE spk = ?";
        $cek_divisi = $this->db->query($query, array($spk))->row();
        $divisi = $cek_divisi->Divisi;
    
        try {
            $query = "
                INSERT INTO log_cetak_spk (`nomor_spk`, `divisi`)
                VALUES (?, ?)
            ";
            $this->db->query($query, array($spk, $divisi));
    
            // Log sukses
            log_message('info', 'Data successfully inserted into log_cetak_spk');
        } catch (Exception $e) {
            log_message('error', 'Error inserting data into log_cetak_spk: ' . $e->getMessage());
        }
    }
    
    
    //PMT KUSTOMISASI
    // public function pmt_custom_temp()
    // {
    //     // Mengambil input dari form
    //     $id = $this->input->post('id');
    //     $id_barang = $this->input->post('id_barang');
    //     $jml = $this->input->post('jumlah');
    //     $keterangan = $this->input->post('keterangan');

    //     // Menggunakan query binding untuk mencegah SQL injection
    //     $query = "SELECT Category FROM inventory WHERE ID = ?";
    //     $cari_cat = $this->db->query($query, array($id_barang))->row();

    //     if ($cari_cat) {
    //         $cat = $cari_cat->Category;

    //         // Menyiapkan query untuk INSERT ke tabel t_pmtppic_sementara
    //         $query = "
    //             INSERT INTO t_pmtppic_sementara (id_brg, qty, keterangan, dept, kategori)
    //             VALUES (?, ?, ?, '4', ?)
    //         ";
    //         $this->db->query($query, array($id_barang, $jml, $keterangan, $cat));
    //     } else {
    //         // Handle jika data kategori tidak ditemukan
    //         throw new Exception("Category not found for the provided id_barang.");
    //     }
    // }

    //PMT CUSTOM
    public function pmt_custom_temp()
    {
        // Mengambil input dari form
        $id = $this->input->post('id');
        $id_barang = $this->input->post('id_barang');
        $jml = $this->input->post('jumlah');
        $dept = $this->input->post('dept');
        $keterangan = $this->input->post('keterangan');
        $tgl_dibutuhkan = $this->input->post('tgl_dibutuhkan'); // Ambil data tgl_dibutuhkan

        // Menggunakan query binding untuk mencegah SQL injection
        $query = "SELECT Category FROM inventory WHERE ID = ?";
        $cari_cat = $this->db->query($query, array($id_barang))->row();

        if ($cari_cat) {
            $cat = $cari_cat->Category;

            // Menyiapkan query untuk INSERT ke tabel t_pmtppic_sementara
            $query = "
                INSERT INTO t_pmtppic_sementara (id_brg, qty, keterangan, dept, kategori, tgl_dibutuhkan)
                VALUES (?, ?, ?, ?, ?, ?)
            ";

            // Melakukan query dengan semua parameter, termasuk tgl_dibutuhkan
            $this->db->query($query, array($id_barang, $jml, $keterangan, $dept, $cat, $tgl_dibutuhkan));
        } else {
            // Handle jika data kategori tidak ditemukan
            throw new Exception("Category not found for the provided id_barang.");
        }
    }

    public function show_pmt_custom_temp()
    {
        // Mengambil seluruh data dari tabel detail_pmtppic_sementara
        $query = "SELECT * FROM detail_pmtppic_sementara";
        return $this->db->query($query)->result();
    }

    public function input_pmt_custom_temp($kanban)
    {
        // Ambil data dari tabel t_pmtppic_sementara
        $data_temp = $this->db->query("SELECT * FROM t_pmtppic_sementara")->result();
        $date_now = DATE('Y-m-d H:i:s');

        // Ambil ID dan ID MPS dari tabel erp_master_plan_sche
        $kanban_info = $this->db->query("SELECT ID, `ID MPS` as idmps FROM erp_master_plan_sche WHERE ID = '$kanban'")->row();
        $mps = $kanban_info->idmps;

        // Buat nomor PMT
        $show_series = "PMT";
        $tanggal_info = $this->db->query("SELECT date_format(curdate(),'/%m/%Y') as date")->row();
        $series_tanggal = $show_series . $tanggal_info->date;

        $tahun = date('Y');
        $nomor_query = $this->db->query("SELECT LEFT(`no_pmt`, 3) as nomor FROM pmt_ppic WHERE date_format(Created_at, '%Y') = $tahun ORDER BY ID DESC");

        if($nomor_query->num_rows() > 0)
        {
            $data = $nomor_query->row();
            $kode = intval($data->nomor) + 1; 
        }
        else
        {      
            $kode = 1;  
        }

        $nomor_pmt = str_pad($kode, 3, "0", STR_PAD_LEFT);
        $pmt = $nomor_pmt . "/" . $series_tanggal;

        // Input ke tabel pmt_ppic
        $this->db->query("INSERT INTO pmt_ppic (no_pmt, id_pmtwh) VALUES ('$pmt', '1')");

        // Ambil ID dari tabel pmt_ppic yang baru saja dimasukkan
        $pmt_info = $this->db->query("SELECT id FROM pmt_ppic ORDER BY id DESC LIMIT 1")->row();
        $id_pmtppic = $pmt_info->id;

        // Input data ke tabel alokasi_pmt_spk_ppic dan t_pmtppic
        foreach($data_temp as $item)
        {
            $this->db->query("INSERT INTO alokasi_pmt_spk_ppic (tanggal, kode_barang, id_kanban, qty_pmt, jenis, `status`) VALUES ('$date_now', '$item->id_brg', '$mps', '$item->qty', 'PMT', 'OPEN')");

            $this->db->query("INSERT INTO t_pmtppic (id_pmtppic, id_brg, qty, keterangan, tgl_dibutuhkan, `status`, dept, kategori, tanggal) VALUES ('$id_pmtppic', '$item->id_brg', '$item->qty', '$item->keterangan', '', '', 4, '$item->kategori', '$date_now')");
        }
    }

    public function truncate_t_pmtppic_sementara()
    {
        // Menghapus semua data dari tabel t_pmtppic_sementara
        return $this->db->truncate("t_pmtppic_sementara");
    }

    // Fungsi untuk mendapatkan nama item berdasarkan ID produk
    // public function getItemNameByMPSId($id_mps) {
    //     $result = $this->db->select('i.ItemName, emp.`Ref No` as RefNo, emp.`Plan Qty` as PlanQty')
    //         ->from('erp_master_plan_sche emp')
    //         ->join('inventory i', 'emp.Product = i.ID')
    //         ->where('emp.ID', $id_mps)
    //         ->get()
    //         ->row(); // row() akan mengembalikan objek, atau null jika tidak ada data

    //     return $result ? $result : null;
    // }
    // Fungsi untuk mendapatkan nama item berdasarkan ID produk
    public function getItemNameByMPSId($id_mps) {
        // Query untuk mendapatkan data berdasarkan Product
        $query1 = $this->db->select('i.ItemName, emp.`Ref No` as RefNo, emp.`Plan Qty` as PlanQty')
            ->from('erp_master_plan_sche emp')
            ->join('inventory i', 'emp.Product = i.ID')
            ->where('emp.ID', $id_mps)
            ->get_compiled_select();

        // Query untuk mendapatkan data berdasarkan Custom_Product
        $query2 = $this->db->select('i.`Item Name` as ItemName, emp.`Ref No` as RefNo, emp.`Plan Qty` as PlanQty')
            ->from('erp_master_plan_sche emp')
            ->join('produksi_inventory i', 'emp.Custom_Product = i.iD') // Ganti 'iD' dengan nama kolom yang sesuai
            ->where('emp.ID', $id_mps)
            ->get_compiled_select();

        // Gabungkan kedua query dengan UNION
        $final_query = $this->db->query("($query1) UNION ($query2)");

        // Mengambil satu baris hasil
        $result = $final_query->row();

        return $result ? $result : null;
    }


    public function getPlanDetailsByMPSId($id_mps) {
        return $this->db->select('i.ItemName, i.Series, emp.`Ref No` as RefNo, emp.`Plan Qty` as PlanQty')
            ->from('erp_master_plan_sche emp')
            ->join('inventory i', 'emp.Product = i.ID')
            ->where('emp.ID', $id_mps)
            ->get()
            ->row();
    }
    
    public function deleteById($id) {
        return $this->db->delete('erp_aktivitasproduksi_proto', array('ID' => $id));
    }

    public function getKomponen() 
    {
        // Jalankan query
        $data_barang = $this->db->query("
            SELECT iD, `Item Name` as ItemName
            FROM `produksi_inventory`
            WHERE `Category` IN ('Preparation', 'Component')
            ORDER BY `iD` ASC
        ");
        
        // Kembalikan hasil query
        return $data_barang->result();
    }


       // Method untuk mengambil item name pada tabel produksi inventory
   public function get_tahap_produksi() 
   {
        // Pilih semua kolom dari tabel
        $this->db->select('*');
        
        // Dari tabel 'produksi_inventory'
        $this->db->from('erp_tahapproduksi');
        
        // Eksekusi query dan kembalikan hasilnya
        return $this->db->get()->result();
    }

    public function get_user()
    {
        $this->db->select('*');
        $this->db->from('employee');
        $this->db->where('status', 2);
        $this->db->where_in('divisi', [1, 2, 4, 5, 6, 7, 9, 32, 33, 34, 35, 36, 42]);
        return $this->db->get()->result();
    }

    public function get_divisi() 
    {
        $this->db->where_in('ID', [1, 2, 3, 4, 5, 6, 7, 9]);
        return $this->db->get('erp_pro_divisi')->result();
    }

    public function simpan_data($data) {
        // Gunakan alias saat menyimpan ke database
        $sql = "INSERT INTO erp_aktivitasproduksi_proto (Barcode_Series, `ID Operator`, `ID Tahap`, `ID Komponen`)
                VALUES (?, ?, ?, ?)";
        
        $this->db->query($sql, array(
            $data['barcode_series'], 
            $data['id_operator'],  // Input dengan alias, tetapi disimpan ke 'ID Operator'
            $data['id_tahap'], 
            $data['id_komponen']
        ));

        // Ambil ID yang baru disimpan
        $ID = $this->db->insert_id();

        // Redirect ke halaman cetak dengan membawa ID data yang baru disimpan
        redirect('c_dashboard/cetak_form_kosong/' . $ID);
    }

    public function get_data_by_id($ID) {
        $this->db->where('ID', $ID);
        $query = $this->db->get('erp_aktivitasproduksi_proto');
        if ($query->num_rows() > 0) {
            return $query->row(); // Mengembalikan baris data sebagai objek
        }
        return null; // Jika tidak ada data ditemukan
    }

    // public function get_data_by_id($ID) {
    //     // Pilih kolom yang diperlukan dengan alias untuk 'Item Name'
    //     $this->db->select('erp_aktivitasproduksi_proto.*, produksi_inventory.`Item Name` AS item_name');
    //     $this->db->from('erp_aktivitasproduksi_proto');
    //     // Perbaiki bagian JOIN dengan menambahkan backticks pada kolom
    //     $this->db->join('produksi_inventory', 'produksi_inventory.iD = erp_aktivitasproduksi_proto.`ID Komponen`', 'left');
    //     $this->db->where('erp_aktivitasproduksi_proto.ID', $ID);
    //     $query = $this->db->get();
    
    //     // Jika data ditemukan, kembalikan sebagai objek
    //     if ($query->num_rows() > 0) {
    //         return $query->row();
    //     }
    
    //     // Jika tidak ada data ditemukan
    //     return null;
    // }
    
}
?>