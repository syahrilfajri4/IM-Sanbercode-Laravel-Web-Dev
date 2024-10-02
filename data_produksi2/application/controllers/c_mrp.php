<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class c_mrp extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_mrp');
        $this->load->library('session');
        $this->load->library('form_validation'); // Memuat library form validation
    }

    function index() {
        $bulan = date('n'); // Mendapatkan bulan saat ini (1-12)
    
        // Menentukan periode berdasarkan bulan
        $period = ceil($bulan / 3);
        $vperiod = $period; // Sama dengan period jika tidak ada pengolahan khusus
    
        // Menyimpan data ke dalam array data
        $this->data['periode'] = $period;
        $this->data['mrp'] = $this->m_mrp->getAll();
        // $data['dataInventory'] = $this->m_mrp->tampil_data();
        // $this->data['inventory'] = $this->m_mrp->getInventory(); // Ambil data inventory
        // $this->data['ref'] = $this->m_mrp->getRef();
    
        // Hitung jumlah baris berdasarkan 'order'
        $this->data['total_order'] = $this->m_mrp->count_order();
        
        // Memuat view dengan data
        $this->load->view('v_mrp_assy', $this->data);
        // $this->load->view('v_stokinventory', $this->data);
    }

    function index_bc(){
        $data['inventory'] = $this->m_mrp->tampil_data();
        $this->data['mrp'] = $this->m_mrp->getAll();
        $this->data['ref'] = $this->m_mrp->getRef();
        $this->load->view('v_mrp_assy',$this->data);
    }
    
    public function filter() {
        // Menentukan periode berdasarkan bulan saat ini
        $bulan = date('n');
        if ($bulan > 0 && $bulan < 4) {
            $period = 1;
        } elseif ($bulan > 3 && $bulan < 7) {
            $period = 2;
        } elseif ($bulan > 6 && $bulan < 10) {
            $period = 3;
        } elseif ($bulan > 9 && $bulan <= 12) {
            $period = 4;
        }
    
        // Mengambil input dari POST request
        $ref = $this->input->post('ref');
        $tahun = $this->input->post('tahun');
        $periode = $this->input->post('periode');
        $kategori = $this->input->post('kategori');
    
        // Menetapkan data ke array yang akan dikirim ke tampilan
        $this->data['periode'] = $period;
        $this->data['mrp'] = $this->m_mrp->getAll();
    
        $this->data['noref'] = $ref;
        $this->data['year'] = $tahun;
        $this->data['kuartal'] = $periode;
        $this->data['cat'] = $kategori;
    
        // Memuat tampilan dengan data yang telah ditetapkan
        $this->load->view('v_mrp_assy', $this->data);
    }
    
    public function detail_mrp() {
        // Mengambil parameter 'kode' dari URL menggunakan $this->input->get()
        $id = $this->input->get('kode', TRUE);
    
        // Mengambil data detail MRP berdasarkan kode
        $data['detail'] = $this->m_mrp->get_detail_mrp($id);
    
        // Memuat tampilan 'input_spk_pmt' dengan data detail MRP
        $this->load->view('v_spk_pmt', $data);
    }    
    
    function input_wopo_alokasi()
    {
    $id = $this->input->post('id');
    $wo = $this->input->post('wo');
    $po = $this->input->post('po');
    $alokasi = $this->input->post('alokasi');
    
    $id_mp = $this->input->post('id_mp');
    $id_pro = $this->m_mrp->get_id_pro(); //ambil kode produksi inventory
    echo $id_pro->Kode_Komp;
    $id_kode_komp = $id_pro->Kode_Komp;

    if(!empty($alokasi))
    {
      $this->m_mrp->input_bpb_sementara();
    }
    else
    {
      if(!empty($wo))
      {
        $this->m_mrp->input_wo($id_kode_komp);
      }
      else
      {
        $this->m_mrp->input_po_semetara();
      }
    }

    $this->session->set_flashdata('success', 'Berhasil Disimpan');
    redirect('c_mrp/detail_mrp?kode='.$id);
    }

    // public function dtl_debugging() {
    //     $data['dtl'] = $this->m_mrp->get_data();
    //     $this->load->view('v_spk_pmt', $data);
    // }
    
    //belum cek

    // LIHAT PMT SEMENTARA
    function lihat_pmt()
    {
        $data['pmt'] = $this->m_mrp->pmt_sementara();
        $this->load->view('v_lihat_pmt',$data);
    }

    // UNTUK INPUT PMT SEMENTARA KE PMT ASLI
    function insert_pmt()
    {
        // // Memulai transaksi untuk memastikan operasi dilakukan dengan aman
        // $this->db->trans_start();

        // Memindahkan data dari tabel sementara ke tabel asli
        $this->m_mrp->input_po();

        // Mengosongkan tabel sementara setelah data dipindahkan
        $this->m_mrp->truncate_t_pmtppic_sementara();

        // // Menyelesaikan transaksi
        // $this->db->trans_complete();

        // // Memeriksa apakah transaksi berhasil
        // if ($this->db->trans_status() === FALSE) {
        //     // Jika terjadi kesalahan, rollback dan tampilkan pesan error
        //     $this->session->set_flashdata('error', 'Terjadi kesalahan saat menyimpan data.');
        // } else {
        //     // Jika berhasil, tampilkan pesan sukses
        //     $this->session->set_flashdata('success', 'Data berhasil disimpan.');
        // }

        // Redirect ke halaman lihat_pmt
        redirect('c_mrp/lihat_pmt');
    }

    // BPB
    // LIHAT BPB SEMENTARA
    function lihat_bpb()
    {
        $data['bpb'] = $this->m_mrp->bpb_sementara();
        $this->load->view('v_lihat_bpb',$data);
    }

    // UNTUK INPUT BPB SEMENTARA KE BPB ASLI
    function insert_bpb()
    {
        $this->m_mrp->input_alokasi();
        $this->m_mrp->truncate_bpb_sementara();

        redirect('c_mrp/lihat_bpb');
    }

    // KUSTOMISASI BPB (PER SPK)
    function kustomisasi() 
    {
        $data['kustom'] = $this->m_mrp->bpb_sementara_kustom();
        $data['spk'] = $_GET['barcode'];
        $this->load->view('kustomisasi',$data);
    }

    function kustomisasi_detail() 
    {
        $data['spk'] = $_GET['barcode'];
        $data['kode_barang'] = $this->m_mrp->kode_barang();
        $this->load->view('kustomisasi_detail',$data);
    }

    function bpb_kustom1()
    {
        $this->m_mrp->bpb_kustom1();
        $spk = $this->input->post('spk');
        redirect('c_mrp/kustomisasi_detail?barcode='.$spk);
    }

    function insert_bpb_kustom1()
    {
        $this->m_mrp->input_kustom1();
        $this->m_mrp->truncate_bpb_sementara();

        $data['spk'] = $_GET['barcode'];
        redirect('c_mrp/kustomisasi?barcode='.$spk);
    }

    function hapus_kustom($id_bpb_smt) 
    {
        $this->db->query("DELETE FROM `bpb_sementara` WHERE `id` = '$id_bpb_smt'");
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function hapus($id) //hapus bpb
    {
        // Panggil model untuk menghapus data berdasarkan ID
        $this->load->model('m_mrp'); // Ganti dengan nama model yang Anda gunakan
        $this->m_mrp->delete_data($id);

        // Setelah menghapus, redirect kembali ke halaman yang diinginkan
        redirect('c_mrp/lihat_bpb'); // Ganti dengan rute yang sesuai
    }

    public function update_nomor_spk()
    {
        // Ambil data dari request AJAX
        $id = $this->input->post('id');
        $nomor_spk = $this->input->post('nomor_spk');

        // Update data di database
        $this->db->where('id', $id);
        $this->db->update('bpb_sementara', ['nomor_spk' => $nomor_spk]);

        // Kirim response JSON
        echo json_encode(['status' => 'success']);
    }

}