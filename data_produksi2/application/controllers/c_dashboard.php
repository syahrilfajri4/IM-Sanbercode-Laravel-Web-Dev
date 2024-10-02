<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class c_dashboard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_inventory');
        $this->load->library('session');
        $this->load->library('form_validation'); // Memuat library form validation
    }
    
    public function index()
    {
        $bulan = date('n');
        
        // Tentukan periode berdasarkan bulan
        if ($bulan >= 1 && $bulan <= 3) {
            $period = $vperiod = 1;
        } elseif ($bulan >= 4 && $bulan <= 6) {
            $period = $vperiod = 2;
        } elseif ($bulan >= 7 && $bulan <= 9) {
            $period = $vperiod = 3;
        } elseif ($bulan >= 10 && $bulan <= 12) {
            $period = $vperiod = 4;
        }
    
        $this->data['periode'] = $period;
        $this->data['cat'] = $cat = "";
    
        // Ambil data dari plan1
        $plan1 = $this->db->select('ID, Barang, Kuantitas, NoRef, STATUS, Category')
                          ->from('plan1')
                          ->get()
                          ->result();
    
        // Ambil data dari plan2
        $plan2 = $this->db->select('PlanID as ID, ItemName as Barang, Quantity as Kuantitas, RefNo as NoRef, PlanStatus as STATUS, Category')
                          ->from('plan2')
                          ->get()
                          ->result();
    
        // Gabungkan hasil plan1 dan plan2
        $mps = array_merge($plan1, $plan2);
    
        // Kirimkan data ke view, pastikan data mps tidak ditimpa
        $data['mps'] = $mps;
        
        // Data tambahan
        $data['barang'] = $this->m_inventory->getBarang();
        $data['divisi'] = $this->m_inventory->tampil_divisi_cetak();
        $data['co'] = $this->m_inventory->getCo(); // Tabel CO
        $data['komponen'] = $this->m_inventory->getKomponen();
        
        // Load view
        $this->load->view('v_dashboard', $data);
    }    

    //untuk pilih jip
    public function inputJIP() 
    {
        $this->load->library('form_validation'); // Memuat library form validation
        $this->load->model('m_inventory'); // Memuat model m_inventory
        $input_jip = $this->m_inventory;
        $validation = $this->form_validation;

        // Aturan validasi
        $validation->set_rules($input_jip->rule_jip());

        // Jika validasi berhasil
        if ($validation->run()) {
            $input_jip->JIPinput(); // Memanggil fungsi JIPinput() dari model m_inventory untuk menyimpan data
            $this->session->set_flashdata('success', 'Berhasil Disimpan'); // Set flash data untuk notifikasi sukses
            redirect('c_dashboard/index'); // Redirect setelah berhasil
        } else {
            // Jika validasi gagal, tampilkan kembali form input
            $this->load->view('v_dashboard'); 
        }
    }
    
    public function filter() {
        // Mengambil nilai input dari form POST dan menyimpannya dalam variabel $this->data
        $this->data['cat'] = $this->input->post('kategori');    // Kategori
        $this->data['status'] = $this->input->post('stt');       // Status
        $this->data['kuartal'] = $this->input->post('periode');  // Periode/Kuartal
        $this->data['year'] = $this->input->post('tahun');       // Tahun
    
        // Memanggil metode model untuk mendapatkan data yang diperlukan berdasarkan filter yang diinput
        $this->data['co'] = $this->m_inventory->getCo();         // Mendapatkan data Customer Order (CO)
        
        // Mendapatkan data MPS berdasarkan filter yang diinput oleh pengguna
        $this->data['mps'] = $this->m_inventory->getAll(
        $this->data['cat'], 
        $this->data['status'], 
        $this->data['kuartal'], 
        $this->data['year']
        );
        
        // Mendapatkan data Barang
        $this->data['barang'] = $this->m_inventory->getBarang();

        // Mendapatkan data komponen
        $this->data['komponen'] = $this->m_inventory->getKomponen();
    
        // Mendapatkan data Divisi untuk dicetak
        $this->data['divisi'] = $this->m_inventory->tampil_divisi_cetak();
    
        // Memuat view 'v_dashboard' dengan data yang telah dikumpulkan
        $this->load->view('v_dashboard', $this->data);
    }    

    public function aktivasi_mps() {
        // Memanggil metode aktivasi_mps di model
        $this->m_inventory->aktivasi_mps();
        
        // Mengarahkan kembali setelah aktivasi selesai
        redirect('c_dashboard/index');
    }        
    
    public function cancel_mps() {
        $id_mps = $this->input->get('id_mps');
        
        // Mengubah status barang menjadi "Belum Aktif" (misalnya status = 1)
        $this->db->set('STATUS', 1)
                 ->where('ID', $id_mps)
                 ->update('erp_master_plan_sche');
        
        // Redirect kembali ke halaman dashboard atau halaman lain
        redirect('c_dashboard');
    }
    
    
    //INPUT UNTUK KOMPONEN 
    public function input_barang() 
    {
        // Ambil data dari form
        $id_barang = $this->input->post('id_barang');
        $jml = $this->input->post('jml');
        $no_ref = $this->input->post('no_ref');

        // Tentukan periode sesuai bulan
        $bulan = date('n');
        if ($bulan >= 1 && $bulan <= 3) {
            $periode1 = 1;
        } elseif ($bulan >= 4 && $bulan <= 6) {
            $periode1 = 2;
        } elseif ($bulan >= 7 && $bulan <= 9) {
            $periode1 = 3;
        } else {
            $periode1 = 4;
        }

        // Status pertama kali input adalah 1 (deactive)
        $status = 1;

        // Insert ke tabel menggunakan query manual dengan backtick pada nama kolom yang ada spasi
        $this->db->query("
            INSERT INTO `erp_master_plan_sche` 
            (`Custom_Product`, `Plan Qty`, `Ref No`, `Periode`, `Status`)
            VALUES ('$id_barang', '$jml', '$no_ref', '$periode1', $status)
        ");

        // Redirect setelah berhasil
        redirect('c_dashboard/index');
    }

    
///////lagi dicoba
    public function spk_rekap()
    {
        $id_mps = $this->input->get('id_mps', true); // Menggunakan input->get() dengan filter
        if (!$id_mps) {
            show_error('ID MPS tidak ditemukan.', 400);
            return;
        }

        $this->load->model('m_inventory');  // Pastikan model dimuat
        $this->data['rekap'] = $this->m_inventory->getSPK_rekap();
        $this->data['mps'] = $id_mps;
        
        // Ambil data item berdasarkan ID produk yang terdapat di ID MPS
        $item = $this->m_inventory->getItemNameByMPSId($id_mps);

        if ($item) {
            $this->data['item'] = $item;
        } else {
            $this->data['item'] = null; // Atau beri nilai default jika data tidak ada
        }

        // Panggil fungsi untuk mengambil data dari produksi_inventory
        $this->data['produksi_inventory'] = $this->m_inventory->get_produksi_inventory();
        $this->data['tahap_produksi'] = $this->m_inventory->get_tahap_produksi();
        $this->data['operator_produksi'] = $this->m_inventory->get_user();
        $this->data['divisi_produksi'] = $this->m_inventory->get_divisi();

        // Muat view dengan data yang sudah digabung
        $this->load->view('v_jip_rekap', $this->data);
    }

    function spk_list(){
        $this->data['spk'] = $this->m_inventory->getSPK_dtl();
        $this->load->view('v_jip_detail', $this->data);
    }
    
    function ass_hos(){
        $divisi = "Assembling Hospital";
        $this->data['spk'] = $this->m_inventory->getSPK_divisi($divisi);
        $this->load->view('v_jip_detail', $this->data);
    }    
    
    function ass_reh(){
        $divisi = "Assembling Rehab";
        $this->data['spk'] = $this->m_inventory->getSPK_divisi($divisi);
        $this->load->view('v_jip_detail', $this->data);
    }
    
    function ep(){
        $divisi = "EP";
        $this->data['spk'] = $this->m_inventory->getSPK_divisi($divisi);
        $this->load->view('v_jip_detail', $this->data);
    }
    
    function ga(){
        $divisi = "GA";
        $this->data['spk'] = $this->m_inventory->getSPK_divisi($divisi);
        $this->load->view('v_jip_detail', $this->data);
    }
    
    function m_shop(){
        $divisi = "M Shop";
        $this->data['spk'] = $this->m_inventory->getSPK_divisi($divisi);
        $this->load->view('v_jip_detail', $this->data);
    }
    
    function mms(){
        $divisi = "MMS";
        $this->data['spk'] = $this->m_inventory->getSPK_divisi($divisi);
        $this->load->view('v_jip_detail', $this->data);
    }
    
    function vynil(){
        $divisi = "Vynil";
        $this->data['spk'] = $this->m_inventory->getSPK_divisi($divisi);
        $this->load->view('v_jip_detail', $this->data);
    }
    
    function pc(){
        $divisi = "PC";
        $this->data['spk'] = $this->m_inventory->getSPK_divisi($divisi);
        $this->load->view('v_jip_detail', $this->data);
    }
    
    function poles(){
        $divisi = "Poles";
        $this->data['spk'] = $this->m_inventory->getSPK_divisi($divisi);
        $this->load->view('v_jip_detail', $this->data);
    }
    
    function rik(){
        $divisi = "RIK";
        $this->data['spk'] = $this->m_inventory->getSPK_divisi($divisi);
        $this->load->view('v_jip_detail', $this->data);
    }
    
    // function prep(){
    //     $divisi = "Preparasi";
    //     $this->data['spk'] = $this->m_inventory->getSPK_divisi($divisi);
    //     $this->load->view('v_jip_detail', $this->data);
    // }
    public function prep()
    {
        // Ambil id_mps dari URL
        $id_mps = $this->input->get('id_mps');
        
        // Set divisi preparasi
        $divisi = "Preparasi";
        
        // Ambil data SPK berdasarkan divisi
        $this->data['spk'] = $this->m_inventory->getSPK_divisi($divisi);
        
        // Kirim id_mps ke view
        $this->data['id_mps'] = $id_mps;
        
        // Load view v_jip_detail dengan data
        $this->load->view('v_jip_detail', $this->data);
    }

    function weld(){
        $divisi = "Welding";
        $this->data['spk'] = $this->m_inventory->getSPK_divisi($divisi);
        $this->load->view('v_jip_detail', $this->data);
    }
    
    function lain(){
        $divisi = "";
        $this->data['spk'] = $this->m_inventory->getSPK_divisi($divisi);
        $this->load->view('v_jip_detail', $this->data);
    }
    
    function update_spk_divisi() {
        $barcode = $_GET['barcode'];
        $this->m_inventory->update_SPK_divisi($barcode);
        redirect($_SERVER['HTTP_REFERER']);
    }
    
    // function tampil_spk_cetak() {
    //     $divisi = $_GET['divisi'];
    //     $operator1_id = $this->input->post('operator1');
    //     $operator2_id = $this->input->post('operator2');

    //     // Query database untuk mengambil nama pengguna berdasarkan ID
    //     $data['operator1'] = $this->db->query("SELECT nama_pengguna FROM user WHERE id = ?", array($operator1_id))->row();
    //     $data['operator2'] = $this->db->query("SELECT nama_pengguna FROM user WHERE id = ?", array($operator2_id))->row();

    //     $data['cetak'] = $this->m_inventory->tampil_spk_cetak($divisi);
    //     $data['head'] = $this->m_inventory->head_spk_cetak($divisi);
    //     $this->m_inventory->update_status_cetak($divisi);
    //     $this->load->view('v_tampil_spk_cetak', $data);
    // }
    // function tampil_spk_cetak() {
    //     $divisi = $_GET['divisi'];
    //     $operator1_id = $this->input->post('operator1');
    //     $operator2_id = $this->input->post('operator2');
    
    //     // Query database untuk mengambil nama pengguna berdasarkan ID
    //     $data['operator1'] = $this->db->query("SELECT nama_pengguna FROM user WHERE id = ?", array($operator1_id))->row();
    //     $data['operator2'] = $this->db->query("SELECT nama_pengguna FROM user WHERE id = ?", array($operator2_id))->row();
    
    //     // Ambil data untuk ditampilkan di view
    //     $data['cetak'] = $this->m_inventory->tampil_spk_cetak($divisi);
    //     $data['head'] = $this->m_inventory->head_spk_cetak($divisi);
    //     $this->m_inventory->update_status_cetak($divisi);
        
    //     // Load view dengan data
    //     $this->load->view('v_tampil_spk_cetak', $data);
    // }
    
    public function tampil_spk_cetak() {
        $divisi = $this->input->get('divisi'); // Gunakan $this->input->get() untuk ambil data GET
        $operator1_id = $this->input->post('operator1'); // Ambil data POST untuk operator
        $operator2_id = $this->input->post('operator2');
        
        // Ambil nama pengguna berdasarkan ID operator
        $data['operator1'] = $this->db->query("SELECT NAMA FROM employee WHERE ID = ?", array($operator1_id))->row();
        $data['operator2'] = $this->db->query("SELECT NAMA FROM employee WHERE ID = ?", array($operator2_id))->row();
        
        // Ambil data SPK untuk ditampilkan di view
        $data['cetak'] = $this->m_inventory->tampil_spk_cetak($divisi);
        $data['head'] = $this->m_inventory->head_spk_cetak($divisi);
        
        // Update status cetak
        $this->m_inventory->update_status_cetak($divisi);
        
        // Load view dengan data
        $this->load->view('v_tampil_spk_cetak', $data);
    }
    
    // Plan Assembling
    // function spk_rakit()
    // {
    //     $kanban = $_GET['id_mps'];
    //     $data['mps'] = $kanban;
    //     $data['top'] = $this->m_inventory->plan_assy_top($kanban);
    //     $data['assy'] = $this->m_inventory->plan_assy($kanban);
    //     $this->load->view('v_plan_assy', $data);
    // }
    // function spk_rakit()
    // {
    //     $kanban = isset($_GET['id_mps']) ? $_GET['id_mps'] : null;
    //     if ($kanban === null) {
    //         // Tangani jika id_mps tidak ada
    //         show_error('ID MPS tidak ditemukan.');
    //         return;
    //     }

    //     $data['mps'] = $kanban;
    //     $data['top'] = $this->m_inventory->plan_assy_top($kanban);
    //     $data['assy'] = $this->m_inventory->plan_assy($kanban);

    //     // Dapatkan detail tambahan: nama produk, nomor referensi, dan PlanQty
    //     $data['plan_details'] = $this->m_inventory->getPlanDetailsByMPSId($kanban);

    //     $this->load->view('v_plan_assy', $data);
    // }

    // function input_spk_rakit($kanban)
    // {
    //     $this->m_inventory->input_assy_rakit($kanban);
    //     $this->m_inventory->input_assy_kompon($kanban);
    //     redirect($_SERVER['HTTP_REFERER']);
    // }

    function spk_rakit()
    {
        // Gunakan CodeIgniter input get
        $kanban = $this->input->get('id_mps');

        // Tangani jika id_mps tidak ada
        if ($kanban === null) {
            show_error('ID MPS tidak ditemukan.', 404);
            return;
        }

        $data['mps'] = $kanban;
        $data['top'] = $this->m_inventory->plan_assy_top($kanban);
        $data['assy'] = $this->m_inventory->plan_assy($kanban);

        // Dapatkan detail tambahan: nama produk, nomor referensi, dan PlanQty
        $data['plan_details'] = $this->m_inventory->getPlanDetailsByMPSId($kanban);

        // Load view dengan data yang didapat
        $this->load->view('v_plan_assy', $data);
    }

    function input_spk_rakit($kanban)
    {
        // Validasi jika kanban tidak ada
        if (empty($kanban)) {
            show_error('ID MPS tidak valid.', 400);
            return;
        }

        // Lakukan input assy rakit
        $this->m_inventory->input_assy_rakit($kanban);

        // Lakukan input assy kompon
        $this->m_inventory->input_assy_kompon($kanban);

        // Redirect kembali ke halaman sebelumnya
        redirect($_SERVER['HTTP_REFERER']);
    }

    // function PMT()
    // {
    //     $data['kanban'] = $_GET['id_mps'];
    //     $data['pmt'] = $this->m_inventory->show_pmt_custom_temp();

    //     $this->load->model('m_inventory');  // Pastikan model dimuat
    //     $this->data['rekap'] = $this->m_inventory->getSPK_rekap();
    //     $this->data['mps'] = $id_mps;
        
    //     // Ambil data item berdasarkan ID produk yang terdapat di ID MPS
    //     $item = $this->m_inventory->getItemNameByMPSId($id_mps);

    //     if ($item) {
    //         $this->data['item'] = $item;
    //     } else {
    //         $this->data['item'] = null; // Atau beri nilai default jika data tidak ada
    //     }

    //     $this->load->view('v_pmt_custom', $data);
    // }

    // function PMT()
    // {
    //     $id_mps = $_GET['id_mps']; // Ambil id_mps dari GET
    //     $data['kanban'] = $id_mps;
        
    //     // Pastikan model dimuat sekali
    //     $this->load->model('m_inventory');
        
    //     // Ambil data dari model
    //     $data['pmt'] = $this->m_inventory->show_pmt_custom_temp();
    //     $data['rekap'] = $this->m_inventory->getSPK_rekap();
    //     $data['mps'] = $id_mps;
        
    //     // Ambil data item berdasarkan ID produk yang terdapat di ID MPS
    //     $item = $this->m_inventory->getItemNameByMPSId($id_mps);

    //     // Periksa apakah item ditemukan
    //     if ($item) {
    //         $data['item'] = $item;
    //     } else {
    //         $data['item'] = null; // Atau beri nilai default jika data tidak ada
    //     }
        
    //     // Load view
    //     $this->load->view('v_pmt_custom', $data);
    // }

    public function PMT()
    {
        // Ambil id_mps dari GET dengan cara yang lebih aman
        $id_mps = $this->input->get('id_mps');
        
        // Periksa apakah id_mps tersedia
        if (!$id_mps) {
            // Jika id_mps tidak ada, arahkan ke halaman error atau berikan pesan
            show_error('ID MPS tidak ditemukan', 404);
            return;
        }

        // Set data kanban dengan id_mps
        $data['kanban'] = $id_mps;
        
        // Pastikan model dimuat
        $this->load->model('m_inventory');
        
        // Ambil data dari model
        $data['pmt'] = $this->m_inventory->show_pmt_custom_temp();
        $data['rekap'] = $this->m_inventory->getSPK_rekap();
        $data['mps'] = $id_mps;
        
        // Ambil data item berdasarkan ID produk yang ada di ID MPS
        $item = $this->m_inventory->getItemNameByMPSId($id_mps);

        // Periksa apakah item ditemukan
        if ($item) {
            $data['item'] = $item;
        } else {
            $data['item'] = null; // Atau beri nilai default jika data tidak ada
        }
        
        // Load view
        $this->load->view('v_pmt_custom', $data);
    }

    function pmt_custom_temp()
    {
        $this->m_inventory->pmt_custom_temp();
        redirect($_SERVER['HTTP_REFERER']);
    }

    function input_pmtppic($kanban)
    {
        $this->m_inventory->input_pmt_custom_temp($kanban);
        $this->m_inventory->truncate_t_pmtppic_sementara();
        redirect($_SERVER['HTTP_REFERER']);
    }

    //untuk menyimpan tanggal PMT yang dibuthkan
    public function update_tgl_dibutuhkan()
    {
        $id = $this->input->post('id');
        $tgl_dibutuhkan = $this->input->post('tgl_dibutuhkan');

        // Update tanggal di database
        $this->db->where('id', $id);
        $this->db->update('t_pmtppic_sementara', ['tgl_dibutuhkan' => $tgl_dibutuhkan]);

        echo json_encode(['status' => 'success']);
    }

    public function delete($id) {
        if ($this->input->is_ajax_request()) {
            // Hapus data dari database
            $this->db->where('id', $id);
            $this->db->delete('t_pmtppic_sementara');
    
            // Kirim respons sukses
            echo json_encode(['status' => 'success']);
        } else {
            // Jika bukan permintaan AJAX, redirect ke halaman lain
            redirect('c_dashboard');
        }
    }    

    public function deleteItem($id) {
        if ($this->m_inventory->deleteById($id)) {
            // Redirect atau beri respon sukses
            echo json_encode(['success' => true]);
        } else {
            // Tangani kesalahan
            echo json_encode(['success' => false]);
        }
    }

    //untuk cetak spk custom
    public function cetak_spk_custom() {
        // Ambil data dari model atau database
        // $data['head'] = $this->spk_model->get_head_data(); // contoh get data head
        // $data['cetak'] = $this->spk_model->get_cetak_data(); // contoh get data cetak
        // $data['operator1'] = $this->spk_model->get_operator_data(); // contoh get data operator

        // Load view cetak
        $this->load->view('v_tampil_spk_custom');
    }

    public function cetak_form_kosong($ID) {
        // Pastikan $ID ada dan valid
        if (empty($ID)) {
            show_error('ID tidak tersedia atau tidak valid.');
        }
    
        // Load model
        $this->load->model('m_inventory');
    
        // Ambil data dari database berdasarkan ID
        $data['form_data'] = $this->m_inventory->get_data_by_id($ID);
    
        // Periksa apakah data ditemukan
        if (!$data['form_data']) {
            show_error('Data tidak ditemukan untuk ID yang diberikan.');
        }
    
        // Load view untuk halaman cetak dan kirimkan data
        $this->load->view('v_custom_kosong', $data);
    }    
    
    public function simpan_data() {
        // Ambil data dari form
        $data = array(
            'barcode_series' => $this->input->post('nomorspk'),
            'id_operator' => $this->input->post('operator'), // Menggunakan 'id_operator' untuk input form
            'id_tahap' => $this->input->post('pekerjaan2'),
            'id_komponen' => $this->input->post('komponen2')
        );
    
        // Load model
        $this->load->model('m_inventory');
    
        // Panggil model untuk menyimpan data
        $this->m_inventory->simpan_data($data);
    }
    
}
?>
