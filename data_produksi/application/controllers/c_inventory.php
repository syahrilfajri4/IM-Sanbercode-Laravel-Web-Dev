<?php

class c_inventory extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('m_stokinventory');
    }

    public function index()
    {
        $this->load->view('v_stokinventory');
    }

    public function fetch_data()
    {
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order_column = $this->input->post('order')[0]['column'];
        $order_dir = $this->input->post('order')[0]['dir'];
        $search_value = $this->input->post('search')['value'];

        $inventory = $this->m_stokinventory->get_data($limit, $start, $order_column, $order_dir, $search_value);
        $total_data = $this->m_stokinventory->count_all();
        $total_filtered = $this->m_stokinventory->count_filtered($search_value);

        $data = [];
        foreach ($inventory as $item) {
            $data[] = [
                $item->Item,
                $item->ItemName,
                $item->Category,
                $item->Unit,
                $item->stok
            ];
        }

        $output = [
            "draw" => intval($this->input->post('draw')),
            "recordsTotal" => $total_data,
            "recordsFiltered" => $total_filtered,
            "data" => $data,
        ];

        echo json_encode($output);
    }
}
?>
