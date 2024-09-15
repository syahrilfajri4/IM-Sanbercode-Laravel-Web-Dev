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
    $startYear = $currentYear - 10;
    $endYear = $currentYear + 10;
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
    $data['dataOperator'] = $this->M_monitoring->tampil_data(
        $data['operator'], $data['bulan'], $data['tahun']
    );
    $data['dataKomponen'] = $this->M_monitoring->tampil_data2();
    $data['dataOperator'] = $this->M_monitoring->tampil_data3();
    $data['dataUser'] = $this->M_monitoring->tampil_data4();
    $data['employee'] = $this->db->get('employee')->result();

    // Load view with data
    $this->load->view('v_aktivitasoperator', $data);
  }

}
