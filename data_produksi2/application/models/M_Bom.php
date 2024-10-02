<?php
 defined('BASEPATH') OR exit('No direct script access allowed');

 class M_Bom extends CI_Model{

    function series(){ 

        $query = $this->db->get('pro_bom_list')->result();

        return $query;

    }

    function inventory(){ 

        $query = $this->db->get('inventory')->result();

        return $query;

    }

    function finish_goods(){ 

        $query = $this->db->query("SELECT inventory.ID as ID, inventory.Series as Series, `inventory`.`Item Name` as item_name FROM inventory LEFT JOIN ppic_master_produk ON inventory.ID = `ppic_master_produk`.`Kode Produk` WHERE `Category` like '%Barang Jadi%' ORDER BY inventory.ID")->result();

        return $query;

    }

    function inventory1(){ 

        $query = $this->db->query("SELECT iD as id, `Item Name` as item_name FROM produksi_inventory WHERE `Category` not like 'Finish Goods' ")->result();

        return $query;

    }

    function series1($keyword){ 

        $query = $this->db->get_where('pro_bom_list',["ID_BOM"=>$keyword])->result();

        return $query;

    }

    function list($keyword){

        return $this->db->get_where('pro_bom_lvl1',["ID"=>$keyword])->result();
    }

    function cari($like){ 

        if(!empty($like))
        $this->db->where($like);

        $query = $this->db->get('inventory')->result();

        return $query;

    }

    function tambah($keyword){

        $kode_part = $this->input->post('kode_barang');
        $jumlah = $this->input->post('jumlah');
        
        $this->db->query("INSERT INTO ppic_tmaster_part (`ID Master Produk`,`Kode Part`,Jumlah,`Status`) VALUE ('$keyword','$kode_part','$jumlah',2)");

    }

    function edit($keyword){

        $kode_part = $this->input->post('kode_barang');
        $jumlah = $this->input->post('jumlah');
        
        $this->db->query("UPDATE ppic_tmaster_part SET Jumlah = $jumlah , Status = 2 WHERE `ID Master Produk` = $keyword and `Kode Part` = $kode_part");

    }

    function lookup($keyword){

        $kode_part = $this->input->post('kode_barang');
        
        $data = $this->db->query("SELECT ID as Kode_Part FROM ppic_tmaster_part WHERE `ID Master Produk` = $keyword and `Kode Part` = $kode_part");
        
        return $data->result_array();

    }

    function hapus($key){

      
        $this->db->query("UPDATE ppic_tmaster_part SET `Status` = 1 WHERE concat(`ID Master Produk`,`Kode Part`) = $key");

    }

    function series2($keyword){ 

        $query = $this->db->query("SELECT * FROM pro_bom_lvl1 WHERE CONCAT(ID,ID_Part) = $keyword")->result();

        return $query;

    }

    function cari2($like){ 

        if(!empty($like))
        $this->db->where($like);

        $query = $this->db->get('pro_produksi_inventory')->result();

        return $query;

    }

    function lookup1($keyword){

        $kode_komp = $this->input->post('kode_barang');
        
        $data = $this->db->query("SELECT ID as ID FROM bom_komponen WHERE `ID Master Produk` = $keyword and `Kode_Komp` = $kode_komp");
        
        return $data->result_array();

    }

    function tambah1($keyword){

        $kode_komp = $this->input->post('kode_barang');
        $kode_part = $this->input->post('id_part');
        
        $this->db->query("INSERT INTO bom_komponen (`ID Master Produk`,`Kode Part`,Kode_Komp) VALUE ('$keyword','$kode_part','$kode_komp')");

    }

    function edit1($keyword){

        $kode_komp = $this->input->post('kode_barang');
        $kode_part = $this->input->post('id_part');
        
        $this->db->query("UPDATE bom_komponen SET `Kode Part` = $kode_part WHERE `ID Master Produk` = $keyword and `Kode_Komp` = $kode_komp and `Kode Part`=0");

    }

    function tambah_bom(){

        $Produk = $this->input->post('produk');
        $note = $this->input->post('note');
        
        if ($Produk > 0) {
        $this->db->query("INSERT INTO ppic_master_produk (`Kode Produk`,`Note`,`ID MP Induk`) VALUE ('$Produk','$note',0)");
        }
    }
 }