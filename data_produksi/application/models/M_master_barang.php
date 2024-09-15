<?php
 defined('BASEPATH') OR exit('No direct script access allowed');

 class M_master_barang extends CI_Model{

    /*function get_data(){ 

        $query = $this->db->query("SELECT iD, `Item Name` as 'Item_Name', 'Description', Grup, Category, Unit from produksi_inventory");
        return $query->result();
    }*/

    //ambil data
    function lihat($sampai, $dari, $like = '')
    {
        if($like)
        $this->db->where($like);

        $query = $this->db->get('pro_produksi_inventory',$sampai,$dari);
        return $query->result_array();
    }

    //hitung jumlah row
    function jumlah($like='')
    {
        if($like)
        $this->db->where($like);

        $query = $this->db->get('pro_produksi_inventory');
        return $query->num_rows();
    }

    function edit_mb($id)
    {
        $query = $this->db->get_where('pro_produksi_inventory',["id"=>$id])->row();
        return $query;
    }

    function update_mb($id)
    {
        $item_name = $this->input->post('item_name');
        $description = $this->input->post('description');
        $category = $this->input->post('category');
        $grup = $this->input->post('grup');
        $Unit = $this->input->post('unit');
        
        $query = $this->db->query("UPDATE produksi_inventory SET `Item Name` = '$item_name' , `Description` = '$description', Category = '$category', Grup = '$grup' , Unit = '$Unit'where iD = $id");
        return $query;
    }

    public function tampil_tahap($grup)
    {
        $query = $this->db->get_where('pro_master_tahap',["GRUP"=>$grup])->result_array();
        return $query;
    }

    public function edit_tahap($id)
    {
        $query = $this->db->get_where('pro_master_tahap',["ID"=>$id])->row();
        return $query;
    }

    public function tambah_tahap()
    {
        $query = $this->db->get_where('pro_master_tahap')->row();
        return $query;
    }

    public function pilih_ws()
    {
        $query = $this->db->query("SELECT ID,`Nama Workstation` as Nama_WS, `Divisi` FROM erp_workstation")->result();
        return $query;
    }

    public function update_tahap($id)
    {
        $Nama_Proses = $this->input->post('Nama_Proses');
        $id_tahap = $this->input->post('id_tahap');
        $TAHAP = $this->input->post('TAHAP');
        //$GRUP = $this->input->post('GRUP');
        $WS = $this->input->post('WS');
        $durasi_dtk= $this->input->post('durasi_dtk');
        
        $query = $this->db->query("UPDATE erp_tahapproduksi SET `NAMA PROSES` = '$Nama_Proses', `id_tahap` = '$id_tahap' , TAHAP = $TAHAP , WS = $WS , `Lama Proses_dtk` = '$durasi_dtk' where iD = $id");
        return $query;
    }

    public function hapus_tahap($id)
    {      
        $this->db->query("UPDATE erp_tahapproduksi SET `GRUP` = '' where iD = $id");
    }

    public function get_no_tahap()
    {
        $q = $this->db->query("SELECT MAX(right(produksi_inventory.Grup,4)) as 'GRUP' FROM produksi_inventory where left(produksi_inventory.Grup,2) like 'XR'");
        if($q->num_rows() > 0)
        {      
            $data = $q->row();
            $kode = intval($data->GRUP) + 1; 
        }
        else
        {      
            $kode = 1;  
        }
            $batas =str_pad($kode,4,"0",STR_PAD_LEFT);    
            $string = 'XR';
            $show = $string.$batas;
        return $show;  
    }

    function insert_tahap()
    {
        $GRUP = $this->input->post('GRUP');
        $id_tahap = $this->input->post('id_tahap');
        $Nama_Proses = $this->input->post('Nama_Proses');
        $TAHAP = $this->input->post('TAHAP');
        $WS = $this->input->post('WS');
        $durasi_dtk = $this->input->post('durasi_dtk');
        
        $this->db->query("INSERT INTO erp_tahapproduksi (`NAMA PROSES`,`TAHAP`,`GRUP`,`WS`,`Lama Proses_dtk`) VALUE ('$Nama_Proses','$TAHAP','$GRUP','$WS',$durasi_dtk)");
    }

    function tambah_item()
    {
        $query = $this->db->query("SELECT Category from produksi_inventory where Category like 'Component' or Category like 'Finish Goods' or Category like 'Preparation' or Category like 'Prototype' group by Category");
        return $query->result();
    }

    function insert_item()
    {
        $Grup = $this->input->post('Grup');
        $Item_Name = $this->input->post('Item_name');
        $Category = $this->input->post('Category');
        $Description = $this->input->post('Description');
        $Unit = $this->input->post('Unit');
        
        $this->db->query("INSERT INTO produksi_inventory (`Item Name`,`Description`,`Grup`,`Category`,`Unit`) VALUE ('$Item_Name','$Description','$Grup','$Category','$Unit')");
    }

    function insert_grup($g)
    {
        $id = $this->session->flashdata('id');
        $this->db->query("UPDATE produksi_inventory SET Grup = '$g' WHERE iD = $id");
    }

    function get_inventory($id)
    {
        $query = $this->db->get_where('pro_produksi_inventory',["id"=>$id])->row();

        return $query;
    }
 }

