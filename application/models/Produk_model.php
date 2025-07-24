<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk_model extends CI_Model {
    
    public function get_all_produk() {
        $query = $this->db->get('produk');
        return $query->result();
    } 

    public function get_produk_by_id($id_produk) {
        $this->db->where('id_produk', $id_produk);
        $query = $this->db->get('produk');
        return $query->row();
    }

    public function update_stok($id_produk, $jumlah) {
        $this->db->set('jml_stok', 'jml_stok - ' . (int)$jumlah, FALSE);
        $this->db->where('id_produk', $id_produk);
        return $this->db->update('tb_stok');
    }
}
