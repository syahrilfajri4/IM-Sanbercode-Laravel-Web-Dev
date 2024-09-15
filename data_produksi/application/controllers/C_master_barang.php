<?php

class C_master_barang extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_master_barang');
        $this->load->helper(array('url','html','form'));
        $this->load->library('pagination');
        $this->load->library('session');
        $this->load->library('form_validation');
        date_default_timezone_set('Asia/Jakarta');
    }

    /*function tampil()
    {
        $this->data['master'] = $this->M_master_barang->get_data();
        $this->load->view('setup/master_barang', $this->data);
    }*/

    public function tampil()
    {
         $dari      = $this->uri->segment('3');
         $sampai    = 30;
         $like      = '';

         //hitung jumlah row
         $jumlah= $this->M_master_barang->jumlah();

         //inisialisasi array
         $config = array();

         //set base_url untuk setiap link page
         $config['base_url'] = base_url().'C_master_barang/tampil/';

         //hitung jumlah row
        $config['total_rows'] = $jumlah;

        //mengatur total data yang tampil per page
        $config['per_page'] = $sampai;

        //mengatur jumlah nomor page yang tampil
        $config['num_links'] = $jumlah;

        //mengatur tag
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['next_tag_open'] = "<li>";
        $config['next_tagl_close'] = "</li>";
        $config['prev_tag_open'] = "<li>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li>";
        $config['last_tagl_close'] = "</li>";
        $config['cur_tag_open'] = '&nbsp;<a class="current">';
        $config['cur_tag_close'] = '</a>';
        $config['next_link'] = 'Next';
        $config['prev_link'] = 'Previous';

        //inisialisasi array 'config' dan set ke pagination library
        $this->pagination->initialize($config);

        //inisialisasi array
         $data = array();

         //ambil data buku dari database
        $data['master'] = $this->M_master_barang->lihat($sampai, $dari, $like);

        //Membuat link
        $str_links = $this->pagination->create_links();
        $data["links"] = explode('&nbsp;',$str_links );
        $data['title'] = 'Produksi';
        $this->session->set_flashdata('tampil','C_master_barang/tampil');

        $this->load->view('setup/master_barang',$data);
   }

    public function cari()
    {
        //mengambil nilai keyword dari form pencarian
        $search = (trim($this->input->post('key',true)))? trim($this->input->post('key',true)) : '';

        //jika uri segmen 3 ada, maka nilai variabel $search akan diganti dengan nilai uri segmen 3
        $search = ($this->uri->segment(3)) ? $this->uri->segment(3) : $search;

        //mengambil nilari segmen 4 sebagai offset
        $dari   = $this->uri->segment('4');

        //limit data yang ditampilkan
        $sampai = 30;

        //inisialisasi variabel $like
        $like   = '';

        //mengisi nilai variabel $like dengan variabel $search, digunakan sebagai kondisi untuk menampilkan data
        if($search) $like = "(category LIKE '%$search%' or description LIKE '%$search%' or item_name LIKE '%$search%' or grup LIKE '%$search%' or id LIKE '%$search%')";

        //hitung jumlah row
        $jumlah= $this->M_master_barang->jumlah($like);

        //inisialisasi array
        $config = array();

        //set base_url untuk setiap link page
        $config['base_url'] = base_url().'index.php/C_master_barang/cari/'.$search;

        //hitung jumlah row
        $config['total_rows'] = $jumlah;

        //mengatur total data yang tampil per page
        $config['per_page'] = $sampai;

        //mengatur jumlah nomor page yang tampil
        $config['num_links'] = $jumlah;

        //mengatur tag
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['next_tag_open'] = "<li>";
        $config['next_tagl_close'] = "</li>";
        $config['prev_tag_open'] = "<li>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li>";
        $config['last_tagl_close'] = "</li>";
        $config['cur_tag_open'] = '&nbsp;<a class="current">';
        $config['cur_tag_close'] = '</a>';
        $config['next_link'] = 'Next';
        $config['prev_link'] = 'Previous';

        //inisialisasi array 'config' dan set ke pagination library
        $this->pagination->initialize($config);

        //inisialisasi array
        $data = array();

        //ambil data buku dari database
        $data['master'] = $this->M_master_barang->lihat($sampai, $dari, $like);

        //Membuat link
        $str_links = $this->pagination->create_links();
        $data["links"] = explode('&nbsp;',$str_links );
        $data['title'] = 'Produksi';

        $this->load->view('setup/master_barang',$data);
   }

   public function edit_mb($id)
   {
        $data['master'] = $this->M_master_barang->edit_mb($id);
        $this->load->view('setup/master_barang_edit', $data);
   }

   public function update_mb($id)
   {
        $this->M_master_barang->update_mb($id);
        redirect('C_master_barang/tampil');
   }

   public function tampil_tahap1($grup = null)
   {
        $this->session->set_flashdata('grup',$grup);
        $this->data['grup'] = $grup;
        $this->data['tahap'] = $this->M_master_barang->tampil_tahap($grup);
        $this->data['tampil'] = $this->session->flashdata('tampil');
        $this->load->view('setup/master_tahap', $this->data);
   }

   public function tampil_tahap($id)
   {
        $this->session->set_flashdata('id',$id);
        $inventory = $this->M_master_barang->get_inventory($id);
        $grup = $inventory->grup;
        if(!empty($grup)) {
               $g = $grup;
          } else {
               $g = $this->M_master_barang->get_no_tahap();
          }

        $this->M_master_barang->insert_grup($g);
        $this->session->set_flashdata('grup',$g);
        $this->data['grup'] = $g;
        $this->data['tahap'] = $this->M_master_barang->tampil_tahap($g);
        $this->data['tampil'] = $this->session->flashdata('tampil');
        $this->load->view('setup/master_tahap', $this->data);
   }

   public function tambah_tahap()
   {
        $data['edit_tahap'] = $this->M_master_barang->tambah_tahap();
        $data['ws'] = $this->M_master_barang->pilih_ws();
        $data['grup'] = $this->session->flashdata('grup');
        $data['nomortahap'] = $this->M_master_barang->get_no_tahap();
        $this->load->view('setup/master_tahap_tambah', $data);
   }

   public function insert_tahap()
   {
        $this->M_master_barang->insert_tahap();
        redirect('C_master_barang/kembali_tampil_tahap/');
   }

   public function edit_tahap($id)
   {
        $this->data['edit_tahap'] = $this->M_master_barang->edit_tahap($id);
        $this->data['ws'] = $this->M_master_barang->pilih_ws();
        $this->data['tampil'] = $this->session->flashdata('tampil');
        $this->load->view('setup/master_tahap_edit', $this->data);
   }

   public function update_tahap($id)
   {
        $this->M_master_barang->update_tahap($id);
        redirect('C_master_barang/kembali_tampil_tahap/');
   }

   public function hapus_tahap($id)
   {
        $this->M_master_barang->hapus_tahap($id);
        redirect('C_master_barang/kembali_tampil_tahap/');
   }

   public function kembali_tampil_tahap()
   {
        $grup = $this->session->flashdata('grup');
        $this->data['grup'] = $grup;
        $this->data['tahap'] = $this->M_master_barang->tampil_tahap($grup);
        $this->data['tampil'] = $this->session->flashdata('tampil');
        $this->load->view('setup/master_tahap', $this->data);
   }

   public function tambah_item()
   {
        $data['cat'] = $this->M_master_barang->tambah_item();
        $data['nomortahap'] = $this->M_master_barang->get_no_tahap();
        $this->load->view('setup/mb_tambah_item', $data);
   }

   public function insert_item()
   {
        $this->M_master_barang->insert_item();
        redirect('C_master_barang/tampil');
   }
}