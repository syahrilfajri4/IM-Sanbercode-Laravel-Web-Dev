<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_monitoring_rakit extends CI_Controller{
  
  function __construct(){
    parent::__construct();
    $this->load->model('M_monitoring_rakit');
    $this->load->library('session');
  }

  function index(){
    $this->data['plan'] = $this->M_monitoring_rakit->DataPlan();
    $this->load->view('v_monitoringrakit',$this->data);
  }

}