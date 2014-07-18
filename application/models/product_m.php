<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Product_m extends CI_Model {

    public function save() {
        $data = array(
            'product_name' => $this->input->post('product_name'),
            'product_code' => $this->input->post('product_code'),
            'product_id' => $this->input->post('product_id'),
            'product_rate' => $this->input->post('product_rate'),
            'product_discount' => $this->input->post('product_discount'),
            'product_discription' => $this->input->post('product_description')
        );

        return $this->db->insert('product', $data);
    }

    public function fetch() {
        $this->db->select('*');
        $sql = $this->db->get('product');
        return $sql->result();
    }

    public function get_productlist($list) {

        $products_array = unserialize($list);
        foreach ($products_array as $key => $value) {
            $products[] = $key;
        }
        $this->db->select('*');
        $this->db->where_in('id', $products);
        $sql = $this->db->get('product');
        return $sql->result();
    }

    public function get_product($id) {
        $this->db->select('*');
        $this->db->where('id', $id);
        $sql = $this->db->get('product');
        return $sql->result();
    }

    public function fetch_product($id) {
        $this->db->select('*');
        $this->db->where('id', $id);
        $sql = $this->db->get('product');
        return $sql->row();
    }

    public function edit_update_product() {
        $id = $this->input->post('pro_id');
        $data = array(
            'product_name' => $this->input->post('product_name'),
            'product_code' => $this->input->post('product_code'),
            'product_id' => $this->input->post('product_id'),
            'product_rate' => $this->input->post('product_rate'),
            'product_discount' => $this->input->post('product_discount'),
            'product_discription' => $this->input->post('product_description')
        );
        $this->db->where('id', $id);
        return $this->db->update('product', $data);
    }

    public function delete_product() {
        $id = $this->input->post('p_id');
        $this->db->where('id', $id);
        $this->db->delete('product');
        echo "Product Deleted..!";
    }

    public function product_attachment($temp_pro_attach) {
        $data = array(
            'attachment_name' => $this->input->post('attachment_name'),
            'attachment_file' => $temp_pro_attach
        );
        return $this->db->insert('product_attachment', $data);
    }

}
