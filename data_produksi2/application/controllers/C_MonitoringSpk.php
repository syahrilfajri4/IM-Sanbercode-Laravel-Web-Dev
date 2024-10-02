<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_MonitoringSpk extends CI_Controller {
  
  function __construct() {
    parent::__construct();
    $this->load->library('session');
    // Load model atau library lain jika diperlukan
  }

  // Monitoring SPK
  function index() {
    // Definisikan data jika diperlukan untuk view
      // Memuat model
      $this->load->model('M_monitoring');

      // Mengambil data dari model
      $data['produksi'] = $this->M_monitoring->get_data_produksi();

      // Memuat view dan mengirim data ke view
      $this->load->view('v_monitoringspk', $data);
  }

  public function get_data_produksi_serverside() {
      // Ambil parameter dari DataTables
      $draw = intval($this->input->post("draw"));
      $start = intval($this->input->post("start"));
      $length = intval($this->input->post("length"));
      $search = $this->input->post("search")['value']; // Pencarian global

      // Query untuk mengambil data dari tabel erp_aktivitasproduksi
      // $this->db->select('id_tahap, `id komponen` as id_komponen, barcode, jumlah, tanggal_record, status, departemen');
      $this->db->select('erp_aktivitasproduksi.id_tahap, 
                  erp_tahapproduksi.`NAMA PROSES` as id_tahap,
                  erp_aktivitasproduksi.`id komponen`, 
                  produksi_inventory.`Item Name` as id_komponen,
                  erp_aktivitasproduksi.barcode, 
                  erp_aktivitasproduksi.jumlah, 
                  erp_aktivitasproduksi.tanggal_record, 
                  erp_aktivitasproduksi.status, 
                  erp_pro_divisi.`Nama Divisi` as departemen');
      $this->db->from('erp_aktivitasproduksi');
      $this->db->join('erp_pro_divisi', 'erp_aktivitasproduksi.departemen = erp_pro_divisi.ID', 'left');  // Join dengan tabel erp_pro_divisi
      $this->db->join('erp_tahapproduksi', 'erp_aktivitasproduksi.id_tahap = erp_tahapproduksi.ID', 'left');  // Join dengan tabel erp_tahapproduksi
      $this->db->join('produksi_inventory', 'erp_aktivitasproduksi.`id komponen` = produksi_inventory.iD', 'left');  // Join dengan tabel erp_tahapproduksi
      $this->db->order_by('erp_aktivitasproduksi.tanggal_record', 'DESC');  // Urutkan berdasarkan tanggal_record terbaru

      // Filter pencarian jika ada input dari pengguna
      if (!empty($search)) {
          $this->db->group_start();
          $this->db->like('id_tahap', $search);
          $this->db->or_like('barcode', $search);
          $this->db->or_like('departemen', $search);
          $this->db->group_end();
      }

      // Hitung total record tanpa filter
      $recordsTotal = $this->db->count_all_results('', FALSE);

      // Lanjutkan query dengan limit dan offset untuk paginasi
      $this->db->limit($length, $start);
      $query = $this->db->get();
      $recordsFiltered = $query->num_rows();

      // Format data yang akan dikembalikan ke DataTables
      $data = [];
      foreach ($query->result() as $row) {
          $data[] = [
              'departemen' => $row->departemen,
              'tanggal_record' => $row->tanggal_record,
              'tgl_mulai' => '0', // Bisa diubah sesuai kebutuhan
              'barcode' => $row->barcode,
              'id_tahap' => $row->id_tahap,
              'id_komponen' => $row->id_komponen,
              'satuan' => '0',
              'jumlah' => $row->jumlah,
              'realisasi' => '0',
              'saldo' => '0',
              'pembaruan' => '0',
              'est_hari' => '0',
              'est_jam' => '0',
              'est_menit' => '0',
              'jml_operator' => '0',
              'terlambat_mulai' => '0',
              'pekerjaan_berhenti' => '0',
              'status' => $row->status
          ];
      }

      // Kirimkan data dalam format JSON yang sesuai dengan DataTables
      $output = [
          "draw" => $draw,
          "recordsTotal" => $recordsTotal,
          "recordsFiltered" => $recordsTotal,
          "data" => $data
      ];

      echo json_encode($output);
  }

}
