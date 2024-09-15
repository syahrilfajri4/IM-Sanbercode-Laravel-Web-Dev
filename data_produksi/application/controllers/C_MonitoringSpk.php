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
    $data = [
      // 'key' => 'value', // Tambahkan data yang diperlukan di sini
    ];

    // Load view with data
    $this->load->view('v_monitoringspk', $data);
  }
}
