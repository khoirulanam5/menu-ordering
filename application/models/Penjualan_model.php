<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penjualan_model extends CI_Model {

    public function get_transaksi_id($no_transaksi) {
        $this->db->select('*');
        $this->db->from('pengiriman');
        $this->db->where('pengiriman.no_transaksi', $no_transaksi);
        $query = $this->db->get();
        return $query->row();
    }
}
