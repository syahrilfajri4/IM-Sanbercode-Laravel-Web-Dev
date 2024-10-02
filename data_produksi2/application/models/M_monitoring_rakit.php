<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_monitoring_rakit extends CI_Model
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
}