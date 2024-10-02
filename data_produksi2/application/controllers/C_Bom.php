<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_Bom extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('M_Bom');
        $this->load->database();
        $this->load->library('session');
        $this->load->helper(array('url','html','form'));
		date_default_timezone_set('Asia/Jakarta');
    }  
    public function index()
    {
        $this->load->view('Setup/v_bom');
    }

	public function BOM()
	{
		$this->data['series'] = $this->M_Bom->series();
		$this->data['fg'] = $this->M_Bom->finish_goods();
		$this->load->view('Setup/v_bom',$this->data);
	}

	public function tambah_BOM()
	{

		$this->M_Bom->tambah_bom();

		redirect('C_Bom/BOM/');
	}

	public function list_BOM()
	{
		$keyword = $this->input->get('Series');
		$this->session->set_flashdata('keyword',$keyword);
		$this->data['series'] = $this->M_Bom->series1($keyword);
		$this->data['inventory'] = $this->M_Bom->inventory1();
		$this->data['fg'] = $this->M_Bom->finish_goods();
		$this->data['list'] = $this->M_Bom->list($keyword);
		$this->data['keyword'] = $this->session->flashdata('keyword');
		$this->load->view('Setup/v_bom',$this->data);
	}

	public function TambahItem($keyword)
	{
		$this->data['series'] = $this->M_Bom->series1($keyword);
		$this->data['inventory'] = $this->M_Bom->inventory();
		$this->data['collapse'] = 'collapse';
		$this->load->view('Setup/add_bom',$this->data);
	}

	public function Cari($keyword)
	{
		$search = (trim($this->input->post('cari',true)))? trim($this->input->post('cari',true)) : '';

		$like ='';

		if(!empty($search)) {
			$like = "(ItemName LIKE '%$search%' or Item LIKE '%$search%' or `ID` LIKE '%$search%')";
		}

		$this->data['inventory'] = $this->M_Bom->cari($like);
		$this->data['series'] = $this->M_Bom->series1($keyword);
		$this->data['collapse'] = 'collapse show';

		$this->load->view('Setup/add_bom',$this->data);	
	}

	public function list_BOM1($keyword)
	{
		$this->session->set_flashdata('keyword',$keyword);
		$this->data['series'] = $this->M_Bom->series1($keyword);
		$this->data['inventory'] = $this->M_Bom->inventory1();
		$this->data['fg'] = $this->M_Bom->finish_goods();
		$this->data['list'] = $this->M_Bom->list($keyword);
		$this->data['keyword'] = $this->session->flashdata('keyword');
		$this->load->view('Setup/v_bom',$this->data);
	}

	public function add_BOM($keyword)
	{

		$this->M_Bom->tambah($keyword);

		redirect('C_Bom/list_BOM1/'.$keyword);
	}

	public function add_edit($keyword)
	{
		$look= $this->M_Bom->lookup($keyword);
		$a = $look[0]["Kode_Part"];

		if($a > 0) {
			$this->M_Bom->edit($keyword);
		} else {
			$this->M_Bom->tambah($keyword);
		}

		redirect('C_Bom/list_BOM1/'.$keyword);
	}

	public function hapus($key)
	{
		$keyword = $this->session->flashdata('keyword');
		$this->M_Bom->hapus($key);

		redirect('C_Bom/list_BOM1/'.$keyword);
	}

	public function TambahProID($keyword)
	{
		$this->data['series'] = $this->M_Bom->series2($keyword);
		$this->data['inventory'] = $this->M_Bom->inventory1();
		$this->load->view('Setup/add_pro_id',$this->data);
	}

	public function Cari1($keyword)
	{
		$search = (trim($this->input->post('cari',true)))? trim($this->input->post('cari',true)) : '';

		$like ='';

		if(!empty($search)) {
			$like = "(item_name LIKE '%$search%' or id LIKE '%$search%')";
		}

		$this->data['inventory'] = $this->M_Bom->cari2($like);
		$this->data['series'] = $this->M_Bom->series2($keyword);

		$this->load->view('Setup/add_pro_id',$this->data);	
	}

	public function add_pro_id($keyword)
	{
		$look= $this->M_Bom->lookup1($keyword);
		$a = $look[0]["ID"];

		if($a > 0) {
			$this->M_Bom->edit1($keyword);
		} else {
			$this->M_Bom->tambah1($keyword);
		}

		redirect('C_Bom/list_BOM1/'.$keyword);
	}
}
