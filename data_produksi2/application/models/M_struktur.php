<?php
 defined('BASEPATH') OR exit('No direct script access allowed');

 class M_struktur extends CI_Model{

    function series(){ 

        $query = $this->db->get('pro_bom_list')->result();

        return $query;
    }

    function inventory(){ 

        $query = $this->db->query("SELECT ID as id, Concat('(',Item,') ',`Item Name`) as item_name, stok FROM inventory WHERE Category like 'Raw Material' or Category like 'Pipa Potongan Material' or Category like 'Preparation' or Category like 'Fitting' or Category like 'Part' or Category like 'Packing' or Category like 'Solid Tire' ")->result();

        return $query;

    }

    // function series1($keyword){ 

    //     $query = $this->db->get_where('pro_bom_list',["ID_BOM"=>$keyword])->result();

    //     return $query;
    // }

    function series1($keyword)
    {
        $this->db->where("ID_BOM", $keyword);
        $query = $this->db->get('pro_bom_list')->result();
        return $query;
    }

    function series2($key,$keyword){ 

        $query = $this->db->query("SELECT pro_produksi_inventory.item_name as nama_komp, bom_komponen.Kode_Komp FROM bom_komponen LEFT JOIN pro_produksi_inventory ON bom_komponen.Kode_Komp = pro_produksi_inventory.id WHERE `ID Master Produk` = $key and `Kode_Komp` = $keyword")->result();

        return $query;

    }

    function inventory1(){ 

        $query = $this->db->query("SELECT id, item_name, grup, category, unit FROM pro_produksi_inventory WHERE category Not like 'Finish Goods'")->result();

        return $query;
    }

    function list($keyword){
        //data BOM diambil dari view ini
        return $this->db->get_where('pro_struktur_lvl1',["ID"=>$keyword])->result();
    }

    function list_stok($keyword){

        return $this->db->get_where('pro_struktur_lvl1_stok_komp',["ID"=>$keyword])->result();
    }

    function list1($keyword){

        return $this->db->get_where('pro_struktur_lvl2',["ID_Bom_Komp"=>$keyword])->result();
    }

    function hapus($key,$keyword){ 

        $this->db->query("UPDATE bom_komponen SET `ID Master Produk` = 0, Kode_Komp = 0, `Kode Part` = 0, Jml = 0 WHERE `ID Master Produk` = $keyword AND Kode_Komp = $key");

    }

    function cari($like){ 

        if(!empty($like))
        $this->db->where($like);

        $query = $this->db->get('pro_produksi_inventory')->result();

        return $query;

    }

    function tambah($keyword){

        $kode_part = $this->input->post('kode_barang');
        $jumlah = $this->input->post('jumlah');
        
        $this->db->query("INSERT INTO bom_komponen (`ID Master Produk`,`Kode_Komp`,`Jml`) VALUE ('$keyword','$kode_part','$jumlah')");

    }

    function tambah_sub($keyword){

        $kode_part = $this->input->post('kode_barang');
        $jumlah = $this->input->post('jumlah');
        
        $this->db->query("INSERT INTO bom_preparasi (`ID_Bom_Komp`,`Kode_Preparasi`,`Jumlah`,`Status`,`ID_Tahap`) VALUE ('$keyword','$kode_part','$jumlah',2,0)");

    }

    function edit_sub($keyword){

        $kode_part = $this->input->post('kode_barang');
        $jumlah = $this->input->post('jumlah');
        
        $this->db->query("UPDATE bom_preparasi SET `Status` = 2, `Jumlah` = $jumlah WHERE `ID_Bom_Komp` = $keyword and `Kode_Preparasi` = $kode_part");

    }

    function hapus_sub($keyword){
        
        $this->db->query("UPDATE bom_preparasi SET `Status` = 1 WHERE concat(`ID_Bom_Komp`,`Kode_Preparasi`) = $keyword");

    }

    function lookup($keyword){

        $kode_komp = $this->input->post('kode_barang');
        
        $data = $this->db->query("SELECT ID as ID FROM bom_preparasi WHERE `ID_Bom_Komp` = $keyword and `Kode_Preparasi` = $kode_komp");
        
        return $data->result_array();

    }

    function list_bahan($keyword){

        return $this->db->query("SELECT bom_material.ID AS ID, bom_material.Kode_Prep as Kode_Prep, bom_material.Kode_Material as Kode_Material, `inventory`.`Item Name` as Nama_Material, inventory.Unit as Satuan, bom_material.Jumlah as Ukuran, inventory.Measure as Measure , inventory.stok as stok FROM bom_material LEFT JOIN inventory ON bom_material.Kode_Material = inventory.ID WHERE bom_material.Kode_Prep = $keyword AND bom_material.Status = 2")->result();
    }

    function series3($keyword){ 

        $query = $this->db->query("SELECT id, item_name FROM pro_produksi_inventory WHERE id = $keyword")->result();

        return $query;

    }

    function tambah_bahan($keyword){

        $kode_material = $this->input->post('kode_barang');
        $jumlah = $this->input->post('jumlah');
        
        $this->db->query("INSERT INTO bom_material (`Kode_Prep`,`Kode_Material`,`Jumlah`,`Status`,`ID_Tahap`) VALUE ('$keyword','$kode_material','$jumlah',2,0)");

    }

    function edit_bahan($keyword){

        $kode_material = $this->input->post('kode_barang');
        $jumlah = $this->input->post('jumlah');
        
        $this->db->query("UPDATE bom_material SET `Status` = 2, `Jumlah` = $jumlah WHERE Kode_Prep = $keyword and `Kode_Material` = $kode_material");

    }

    function hapus_bahan($keyword){
        
        $this->db->query("UPDATE bom_material SET `Status` = 1 WHERE ID = $keyword");

    }

    function cari1($like){ 

        if(!empty($like))
 
        $query = $this->db->query("SELECT ID as id, Concat('(',Item,') ',`Item Name`) as item_name, stok FROM inventory WHERE $like AND (Category like 'Raw Material' or Category like 'Pipa Potongan Material' or Category like 'Preparation' or Category like 'Fitting' or Category like 'Part' or Category like 'Packing')")->result();

        return $query;

    }

    function lookup1($keyword){

        $Kode_Material = $this->input->post('kode_barang');
        
        $data = $this->db->query("SELECT Kode_Prep FROM bom_material WHERE Kode_Prep = $keyword AND Kode_Material = $Kode_Material GROUP BY Kode_Prep");
        
        return $data->result_array();

    }

 }