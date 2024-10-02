<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_monitoring extends CI_Model
{
    //menampilkan semua data MPS
    public function DataPlan()
    {
        $year = date('Y');
        $bulan = date('n');

        if(($bulan >= 1) AND ($bulan <= 3)) {
			$period = 1 ;
			$vperiod = 1 ;
		} elseif (($bulan >= 4) AND ($bulan <= 6)) {
			$period = 2 ;
			$vperiod = 2 ;
		} elseif (($bulan >= 7) AND ($bulan <= 9)) {
			$period = 3 ;
			$vperiod = 3 ;
		} elseif (($bulan >= 10) AND ($bulan <= 12)) {
			$period = 4 ;
			$vperiod = 4 ;
		}
        
        //$cat = $this->input->post('ref');
        //$status = $this->input->post('series');
        // $periode = $this->input->post('periode');
        // $tahun = $this->input->post('tahun');

        return $this->db->query("SELECT 
        `erp_master_plan_sche`.`Ref No` as ref, 
        inventory.Series as series, 
        inventory.ItemName as barang, 
        `erp_master_plan_sche`.`Plan Qty` as plan_qty, 
        SUM(erp_aktivitasproduksi_proto.Jumlah) AS 'spk_rakit',
        COALESCE(SUM(hasil.jumlah), 0) AS 'total_hasil',
        NULL AS 'Gudang'
    FROM 
        erp_master_plan_sche 
    JOIN 
        inventory ON inventory.ID = erp_master_plan_sche.Product
    LEFT JOIN 
        erp_aktivitasproduksi_proto ON `erp_aktivitasproduksi_proto`.`ID Kanban` = erp_master_plan_sche.ID
    LEFT JOIN 
        hasil ON hasil.nomor_spk =  `erp_aktivitasproduksi_proto`.`Barcode_Series`
    WHERE `ID MPS` IS NULL
    GROUP BY 
        `erp_master_plan_sche`.`Ref No`, 
        inventory.Series, 
        inventory.ItemName, 
        `erp_master_plan_sche`.`Plan Qty`;")->result();
    }     

    //LAPORAN AKTIVITAS OPERATOR
    public function tampil_data1($operator, $bulan, $tahun)
    {
        $this->db->select('*');
        $this->db->from('data_operator1');
        $this->db->order_by('jam_mulai', 'desc'); // Urutkan berdasarkan tanggal jam mulai secara descending
        $this->db->join('employee', 'employee.id = data_operator1.id_operator', 'left');
        $this->db->join('mesin', 'mesin.ID = data_operator1.mesin', 'left');
        $this->db->join('inventory', 'inventory.`ID` = data_operator1.produk', 'left');

        if (isset($operator) && $operator != 0) {
            $this->db->where('id_operator', $operator);
        }

        $this->db->where('MONTH(tanggal)', $bulan);
        $this->db->where('YEAR(tanggal)', $tahun);
        return $this->db->get()->result_array();
    }

    public function tampil_data2()
    {
        // Pilih semua kolom dari tabel
        $this->db->select('*');
        
        // Dari tabel 'produksi_inventory'
        $this->db->from('produksi_inventory');
        
        // Di mana kolom 'Category' memiliki nilai 'Preparation' atau 'Component'
        $this->db->where_in('Category', ['Preparation', 'Component']);
        
        // Eksekusi query dan kembalikan hasilnya
        return $this->db->get()->result();
    }

    public function tampil_data3()
    {
        // Pilih kolom-kolom yang ingin ditampilkan
        $this->db->select('id_spk, produk, nama_proses, item_name, unit, jumlah, jam_mulai, jam_selesai');
        
        // Dari tabel 'data_operator1'
        $this->db->from('data_operator1');
        
        // Eksekusi query dan kembalikan hasilnya
        return $this->db->get()->result();
    }

    public function tampil_data4()
    {
        $this->db->select('*');
        $this->db->from('employee');
        $this->db->where('status', 2);
        $this->db->where_in('divisi', [1, 2, 4, 5, 6, 7, 9, 32, 33, 34, 35, 36, 42]);
        return $this->db->get()->result();
    }

    public function tampil_data5()
    {
        // Join data_operator dengan inventory
        $this->db->select('data_operator1.*, inventory.ItemName');
        $this->db->from('data_operator1');
        $this->db->join('inventory', 'data_operator1.produk = inventory.ID', 'left'); // Join berdasarkan ID produk
        $this->db->where_in('inventory.Category', ['Barang Jadi Rehab', 'Barang Jadi Furniture']);
        
        return $this->db->get()->result();
    }
    
    //MONITORING SPK
    public function get_data_produksi() {
        // Query untuk mengambil data dari tabel erp_aktivitasproduksi
        $this->db->select('id_tahap, `id komponen` as id_komponen, barcode, jumlah, tanggal_record, status, departemen');
        $this->db->from('erp_aktivitasproduksi');
        $query = $this->db->get();

        // Kembalikan hasil query sebagai array
        return $query->result_array();
    }
}