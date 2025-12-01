<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PemesananModel extends CI_Model {
    
    public function get_all_pemesanan() {
        $this->db->select('pemesanan.no_transaksi, GROUP_CONCAT(produk.nama_produk SEPARATOR ", ") as nama_produk, GROUP_CONCAT(pemesanan.harga SEPARATOR ", ") as harga_produk, GROUP_CONCAT(pemesanan.jumlah SEPARATOR ", ") as jumlah_produk, SUM(pemesanan.total_harga) as total_harga, pemesanan.tanggal');
        $this->db->from('pemesanan');
        $this->db->join('produk', 'produk.id_produk = pemesanan.id_produk');
        $this->db->group_by('pemesanan.no_transaksi');
        $this->db->order_by('pemesanan.no_transaksi', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_pemesanan_by_no_transaksi($no_transaksi) {
        $this->db->select('pemesanan.*, produk.nama_produk');
        $this->db->from('pemesanan');
        $this->db->join('produk', 'produk.id_produk = pemesanan.id_produk');
        $this->db->where('pemesanan.no_transaksi', $no_transaksi);
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
    
    public function get_count() {
        $this->db->select('COUNT(DISTINCT pemesanan.no_transaksi) as total');
        $this->db->from('pemesanan');
        $this->db->join('produk', 'pemesanan.id_produk = produk.id_produk');
        $query = $this->db->get();
        return $query->row()->total;
    }      

    public function get_pemesanan($limit, $start) {
        $this->db->select('pemesanan.no_transaksi, GROUP_CONCAT(produk.nama_produk SEPARATOR ", ") as nama_produk, GROUP_CONCAT(produk.harga_jualpro SEPARATOR ", ") as harga_jualpro, GROUP_CONCAT(pemesanan.jumlah SEPARATOR ", ") as jumlah, SUM(pemesanan.total_harga) as total_harga, pemesanan.tanggal');
        $this->db->from('pemesanan');
        $this->db->join('produk', 'pemesanan.id_produk = produk.id_produk');
        $this->db->group_by('pemesanan.no_transaksi, pemesanan.tanggal');
        $this->db->order_by('pemesanan.no_transaksi', 'DESC');
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result();
    }

    public function pemesanan_cetak() {
        $this->db->select('pemesanan.no_transaksi, GROUP_CONCAT(produk.nama_produk SEPARATOR ", ") as nama_produk, GROUP_CONCAT(produk.harga_jualpro SEPARATOR ", ") as harga_jualpro, GROUP_CONCAT(pemesanan.jumlah SEPARATOR ", ") as jumlah, SUM(pemesanan.total_harga) as total_harga, pemesanan.tanggal');
        $this->db->from('pemesanan');
        $this->db->join('produk', 'pemesanan.id_produk = produk.id_produk');
        $this->db->group_by('pemesanan.no_transaksi, pemesanan.tanggal');
        $this->db->order_by('pemesanan.no_transaksi', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }
}
