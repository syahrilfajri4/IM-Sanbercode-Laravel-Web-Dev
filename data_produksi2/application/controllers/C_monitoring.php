<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_monitoring extends CI_Controller{
  
  function __construct(){
    parent::__construct();
    $this->load->model('M_monitoring');
    $this->load->library('session');
  }

  //LAPORAN AKTIVITAS OPERATOR
  function index(){
    // List of months
    $data['list_months'] = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember'
    ];

    // List of years
    $currentYear = date('Y');
    $startYear = $currentYear - 5;
    $endYear = $currentYear + 5;
    $data['list_years'] = [];
    for ($year = $startYear; $year <= $endYear; $year++) {
        $data['list_years'][$year] = $year;
    }

    // Default filter values
    $data['operator'] = null;
    $data['bulan'] = date('m');
    $data['tahun'] = date('Y');

    // Update filter values from POST request
    if ($this->input->post()) {
        $data['operator'] = $this->input->post('operator');
        $data['bulan'] = $this->input->post('bulan');
        $data['tahun'] = $this->input->post('tahun');
    }

    // Fetch data based on filters
    $data['dataOperator'] = $this->M_monitoring->tampil_data1($data['operator'], $data['bulan'], $data['tahun']);
    $data['dataKomponen'] = $this->M_monitoring->tampil_data2();
    // $data['dataOperator2'] = $this->M_monitoring->tampil_data3();
    $data['dataUser'] = $this->M_monitoring->tampil_data4();
    $data['dataInventory'] = $this->M_monitoring->tampil_data5();
    $data['employee'] = $this->db->get('employee')->result(); // Atau gunakan result_array() jika ingin array asosiatif

    // Kelompokkan dan hitung jumlah id_spk yang sama
    $idSpkCount = [];
    foreach ($data['dataOperator'] as $value) {
        if (isset($idSpkCount[$value['id_spk']])) {
            $idSpkCount[$value['id_spk']]++; // Jika id_spk sudah ada, tambahkan 1 ke jumlahnya
        } else {
            $idSpkCount[$value['id_spk']] = 1; // Jika belum ada, set jumlahnya ke 1
        }
    }

    // Simpan jumlah SPK ke dalam data yang sama untuk dipakai di view
    foreach ($data['dataOperator'] as &$value) {
        $value['jumlah_spk'] = $idSpkCount[$value['id_spk']];
    }

    // Load view with data
    $this->load->view('v_aktivitasoperator', $data);

  }
}
