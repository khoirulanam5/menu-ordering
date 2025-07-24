<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penjualan_model extends CI_Model {
    
    public function get_all_penjualan() {
        $this->db->select('penjualan_off.no_transaksi, penjualan_off.no_plat, GROUP_CONCAT(produk.nama_produk SEPARATOR ", ") as nama_produk, GROUP_CONCAT(penjualan_off.harga_jualpro SEPARATOR ", ") as harga_produk, GROUP_CONCAT(penjualan_off.jumlah SEPARATOR ", ") as jumlah_produk, SUM(penjualan_off.total_harga) as total_harga, penjualan_off.tanggal');
        $this->db->from('penjualan_off');
        $this->db->join('produk', 'produk.id_produk = penjualan_off.id_produk');
        $this->db->group_by('penjualan_off.no_transaksi');
        $this->db->order_by('penjualan_off.no_transaksi', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_penjualan_by_no_transaksi($no_transaksi) {
        $this->db->select('penjualan_off.*, produk.nama_produk');
        $this->db->from('penjualan_off');
        $this->db->join('produk', 'produk.id_produk = penjualan_off.id_produk');
        $this->db->where('penjualan_off.no_transaksi', $no_transaksi);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_transaksi_id($no_transaksi) {
        $this->db->select('*');
        $this->db->from('pengiriman');
        $this->db->where('pengiriman.no_transaksi', $no_transaksi);
        $query = $this->db->get();
        return $query->row();
    }
    
    // Fungsi untuk menghitung total data penjualan
    public function get_count() {
        $this->db->select('COUNT(DISTINCT penjualan_off.no_transaksi) as total');
        $this->db->from('penjualan_off');
        $this->db->join('produk', 'penjualan_off.id_produk = produk.id_produk');
        $query = $this->db->get();
        return $query->row()->total;
    }      

    // Fungsi untuk mengambil data penjualan dengan batas tertentu
    public function get_penjualan($limit, $start) {
        $this->db->select('penjualan_off.no_transaksi, penjualan_off.no_plat, GROUP_CONCAT(produk.nama_produk SEPARATOR ", ") as nama_produk, GROUP_CONCAT(produk.harga_jualpro SEPARATOR ", ") as harga_jualpro, GROUP_CONCAT(penjualan_off.jumlah SEPARATOR ", ") as jumlah, SUM(penjualan_off.total_harga) as total_harga, penjualan_off.tanggal');
        $this->db->from('penjualan_off');
        $this->db->join('produk', 'penjualan_off.id_produk = produk.id_produk');
        $this->db->group_by('penjualan_off.no_transaksi, penjualan_off.no_plat, penjualan_off.tanggal');
        $this->db->order_by('penjualan_off.no_transaksi', 'DESC');
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result();
    }
}
