<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_struktur extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('M_struktur');
		$this->load->library('session');
        $this->load->database();
        $this->load->helper(array('url','html','form'));
		date_default_timezone_set('Asia/Jakarta');
    }  

	public function struktur()
	{
		$this->data['series'] = $this->M_struktur->series();
		$this->load->view('Setup/struktur',$this->data);
	}

	public function list_struktur($keyword)
	{
		$this->session->set_flashdata('keyword',$keyword);
		$this->data['series'] = $this->M_struktur->series1($keyword);
		$this->data['list'] = $this->M_struktur->list($keyword);
		$this->data['keyword'] = $this->session->flashdata('keyword');
		$this->load->view('Setup/struktur',$this->data);
	}

	public function list_sub($keyword)
	{
		$key = $this->session->flashdata('keyword');
		$key1 = $this->session->set_flashdata('kode_komp',$keyword);
		$this->session->set_flashdata('tampil','C_struktur/list_sub/'.$keyword);
		$this->data['series'] = $this->M_struktur->series1($key);
		$this->data['series1'] = $this->M_struktur->series2($key,$keyword);
		$this->data['list'] = $this->M_struktur->list1($keyword); //subkomponen
		$this->load->view('Setup/detail_struktur',$this->data);
	}

	public function list_struktur1()
	{
		$keyword = $this->session->flashdata('keyword');
		$this->data['series'] = $this->M_struktur->series1($keyword);
		$this->data['list'] = $this->M_struktur->list($keyword);
		$this->data['keyword'] = $this->session->flashdata('keyword');
		$this->load->view('Setup/struktur',$this->data);
	}

	public function hapus($key)
	{
		$keyword = $this->session->flashdata('keyword');
		$this->M_struktur->hapus($key,$keyword);
		redirect('C_struktur/list_struktur/'.$keyword);
	}

	public function Tambah_Tampil($keyword)
	{
		$this->data['series'] = $this->M_struktur->series1($keyword);
		$this->data['inventory'] = $this->M_struktur->inventory1();
		$this->data['collapse'] = 'collapse';
		$this->load->view('Setup/add_struktur1',$this->data);
	}

	public function Cari($keyword)
	{
		$search = (trim($this->input->post('cari',true)))? trim($this->input->post('cari',true)) : '';

		$like ='';

		if(!empty($search)) {
			$like = "(item_name LIKE '%$search%' or id LIKE '%$search%')";
		}

		$this->data['inventory'] = $this->M_struktur->cari($like);
		$this->data['series'] = $this->M_struktur->series1($keyword);
		$this->data['collapse'] = 'collapse show';

		$this->load->view('Setup/add_struktur1',$this->data);	
	}

	public function tambah($keyword)
	{

		$this->M_struktur->tambah($keyword);

		redirect('C_struktur/list_struktur1/'.$keyword);
	}

	public function Tambah_Tampilsub($keyword)
	{
		$key = $this->session->flashdata('keyword');
		$this->data['series1'] = $this->M_struktur->series2($key,$keyword);
		$this->data['inventory'] = $this->M_struktur->inventory1();
		$this->data['collapse'] = 'collapse';
		$this->load->view('Setup/add_struktur2',$this->data);
	}

	public function Cari1($keyword)
	{
		$search = (trim($this->input->post('cari',true)))? trim($this->input->post('cari',true)) : '';

		$like ='';

		if(!empty($search)) {
			$like = "(item_name LIKE '%$search%' or id LIKE '%$search%')";
		}

		$key = $this->session->flashdata('keyword');
		$this->data['inventory'] = $this->M_struktur->cari($like);
		$this->data['series1'] = $this->M_struktur->series2($key,$keyword);
		$this->data['collapse'] = 'collapse show';

		$this->load->view('Setup/add_struktur2',$this->data);	
	}

	public function add_edit_sub($keyword)
	{
		$key = $this->session->flashdata('kode_komp');
		$look= $this->M_struktur->lookup($keyword);
		$a = $look[0]["ID"];

		if($a > 0) {
			$this->M_struktur->edit_sub($keyword);
		} else {
			$this->M_struktur->tambah_sub($key);
		}

		redirect('C_struktur/list_sub/'.$keyword);
	}

	public function hapus_sub($keyword)
	{
		$key = $this->session->flashdata('kode_komp');
		$this->M_struktur->hapus_sub($keyword);

		redirect('C_struktur/list_sub/'.$key);
	}

	public function list_bahan($keyword)
	{
		$key = $this->session->flashdata('keyword');
		$this->session->set_flashdata('list_bahan',$keyword);
		$this->data['series'] = $this->M_struktur->series1($key);
		$this->data['series1'] = $this->M_struktur->series3($keyword);
		$this->data['list'] = $this->M_struktur->list_bahan($keyword);
		$this->data['komp'] = $key.$keyword;
		$this->data['key1'] = $this->session->flashdata('kode_komp');
		$this->load->view('Setup/detail_bahan',$this->data);
	}

	public function Tambah_Tampilbahan($keyword)
	{
		$key = $this->session->flashdata('list_bahan');
		$this->data['series1'] = $this->M_struktur->series3($keyword);
		$this->data['inventory'] = $this->M_struktur->inventory();
		$this->data['key'] = $key;
		$this->data['collapse'] = 'collapse' ;
		$this->load->view('Setup/add_struktur3',$this->data);
	}

	public function Cari2($keyword)
	{
		$search = (trim($this->input->post('cari',true)))? trim($this->input->post('cari',true)) : '';

		$like ='';

		if(!empty($search)) {
			$like = "(ItemName LIKE '%$search%' or ID LIKE '%$search%' or Item LIKE '%$search%')";
		}

		$key = $this->session->flashdata('list_bahan');
		$this->data['inventory'] = $this->M_struktur->cari1($like);
		$this->data['series1'] = $this->M_struktur->series3($keyword);
		$this->data['key'] = $key;
		$this->data['collapse'] = 'collapse show' ;

		$this->load->view('Setup/add_struktur3',$this->data);	
	}

	public function add_edit_bahan($keyword)
	{
		$key = $this->session->flashdata('list_bahan');
		$look= $this->M_struktur->lookup1($keyword);
		$a = $look[0]["Kode_Prep"];

		if($a > 0) {
			$this->M_struktur->edit_bahan($keyword);
		} else {
			$this->M_struktur->tambah_bahan($keyword);
		}

		redirect('C_struktur/list_bahan/'.$key);
	}

	public function hapus_bahan($keyword)
	{
		$key = $this->session->flashdata('list_bahan');

		$this->M_struktur->hapus_bahan($keyword);

		redirect('C_struktur/list_bahan/'.$key);
	}


}
