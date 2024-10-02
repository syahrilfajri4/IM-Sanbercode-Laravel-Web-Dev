<?php
class m_stokinventory extends CI_Model
{
    public function count_all()
    {
        $this->db->from('inventory');
        return $this->db->count_all_results();
    }

    public function count_filtered($search_value = '')
    {
        $this->db->from('inventory');
        $this->db->where_not_in('Category', ['Barang Jadi Rehab', 'Barang Jadi Furniture', 'Finish Goods']);
        if (!empty($search_value)) {
            $this->db->like('Item', $search_value);
            $this->db->or_like('ItemName', $search_value);
            $this->db->or_like('Category', $search_value);
            $this->db->or_like('Unit', $search_value);
            $this->db->or_like('stok', $search_value);
        }
        return $this->db->count_all_results();
    }

    public function get_data($limit, $start, $order_column, $order_dir, $search_value = '')
    {
        $this->db->select('*');
        $this->db->from('inventory');
        $this->db->where_not_in('Category', ['Barang Jadi Rehab', 'Barang Jadi Furniture', 'Finish Goods']);
        if (!empty($search_value)) {
            $this->db->like('Item', $search_value);
            $this->db->or_like('ItemName', $search_value);
            $this->db->or_like('Category', $search_value);
            $this->db->or_like('Unit', $search_value);
            $this->db->or_like('stok', $search_value);
        }
        $this->db->limit($limit, $start);
        $this->db->order_by($order_column, $order_dir);
        return $this->db->get()->result();
    }
}
?>
