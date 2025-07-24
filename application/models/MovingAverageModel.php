<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MovingAverageModel extends CI_Model {
    
    public function get_all_ma() {
        $this->db->select('movingaverage.*, pemesanan.id_produk, produk.nama_produk');
        $this->db->from('movingaverage');
        $this->db->join('pemesanan', 'pemesanan.id_pemesanan = movingaverage.id_pemesanan');
        $this->db->join('produk', 'produk.id_produk = pemesanan.id_produk');
        $query = $this->db->get();
        return $query->result();
    }    
    
    public function hitung() {
        $this->db->select('tanggal');
        $this->db->group_by('tanggal');
        $this->db->order_by('tanggal', 'asc');
        $tanggalList = $this->db->get('pemesanan')->result();
    
        foreach ($tanggalList as $tgl) {
            $tanggal = $tgl->tanggal;
    
            // ambil total pemesanan 30 hari ke belakang dari tanggal ini
            $this->db->select_sum('jumlah');
            $this->db->where('tanggal <=', $tanggal);
            $this->db->where('tanggal >=', date('Y-m-d', strtotime($tanggal . ' -29 days')));
            $total = $this->db->get('pemesanan')->row()->jumlah;
    
            // hitung rata-rata harian
            $this->db->where('tanggal <=', $tanggal);
            $this->db->where('tanggal >=', date('Y-m-d', strtotime($tanggal . ' -29 days')));
            $this->db->select('tanggal');
            $this->db->group_by('tanggal');
            $jumlahHari = $this->db->get('pemesanan')->num_rows();
    
            $nilai_ma = $jumlahHari > 0 ? round($total / $jumlahHari, 2) : 0;
    
            // Ambil id_pemesanan terakhir berdasarkan tanggal
            $this->db->select('id_pemesanan');
            $this->db->where('tanggal', $tanggal);
            $this->db->order_by('id_pemesanan', 'desc');
            $this->db->limit(1);
            $id_pemesanan = $this->db->get('pemesanan')->row('id_pemesanan');
    
            // buat id_ma unik dengan uniqid
            $id_ma = "PRD" . uniqid();
    
            $data = [
                'id_ma' => $id_ma,
                'id_pemesanan' => $id_pemesanan,
                'nilai' => $nilai_ma,
                'tanggal' => $tanggal
            ];
    
            // Cek apakah sudah ada untuk tanggal ini
            $cek = $this->db->get_where('movingaverage', ['tanggal' => $tanggal])->row();
            if ($cek) {
                $this->db->where('tanggal', $tanggal);
                $this->db->update('movingaverage', $data);
            } else {
                $this->db->insert('movingaverage', $data);
            }
        }
    }
    
    public function get_chart() {
        $this->db->select('tanggal, nilai');
        $this->db->from('movingaverage');
        $this->db->order_by('tanggal', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }    
}
