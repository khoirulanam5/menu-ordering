<?php 
defined("BASEPATH") OR exit("No direct script access allowed");

class M_join extends CI_Model {	

    public function __construct() {
        parent::__construct();
    }

    public function pdetail() {
        $this->db->select('a.id_detail_produk ,a.id_pelanggan ,a.id_produk ,sum(a.jumlah) as jumlah ,a.tanggal ,b.nama_produk ,b.jenis_pro ,b.diskripsi, b.harga_jualpro, b.images ,c.jml_stok');
        $this->db->from("detail_beli_produk a");
        $this->db->join("produk b","a.id_produk = b.id_produk","left");
        return $this->db->join("tb_stok c", "b.id_produk = c.id_produk");
    }

    public function pdetailjual() {
        $this->db->select('*');
        $this->db->from("detail_jual a");
        return $this->db->join("pengiriman b","b.no_transaksi = a.no_transaksi","left");
    }

    public function detailjualpenjualan() {
        $this->db->select('*');
        $this->db->from("detail_jual a");
        $this->db->join("penjualan b","b.no_transaksi = a.no_transaksi","left");
        return $this->db->join("pengiriman c","c.no_transaksi = b.no_transaksi","left");
    }

    public function detailjual_pengiriman_pelanggan() {
        $this->db->select( "*" );
        $this->db->from( "detail_jual" );
        $this->db->join( "pengiriman","detail_jual.no_transaksi = pengiriman.no_transaksi","left" );
        return $this->db->join( "pelanggan","detail_jual.id_pelanggan = pelanggan.id_pelanggan","left" );
    }
}