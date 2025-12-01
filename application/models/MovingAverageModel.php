<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MovingAverageModel extends CI_Model {

    // Ambil semua data MA + info produk
    public function get_all_ma() {
        $this->db->select('movingaverage.*, pemesanan.id_produk, produk.nama_produk, tb_stok.satuan');
        $this->db->from('movingaverage');
        $this->db->join('pemesanan', 'pemesanan.id_pemesanan = movingaverage.id_pemesanan');
        $this->db->join('produk', 'produk.id_produk = pemesanan.id_produk');
        $this->db->join('tb_stok', 'tb_stok.id_produk = produk.id_produk');
        $query = $this->db->get();
        return $query->result();
    }

    // Proses perhitungan MA dan simpan ke tabel movingaverage
    public function hitung() {
        // Ambil semua tanggal unik pemesanan
        $this->db->select('tanggal');
        $this->db->group_by('tanggal');
        $this->db->order_by('tanggal', 'asc');
        $tanggalList = $this->db->get('pemesanan')->result();

        foreach ($tanggalList as $tgl) {
            $tanggal = $tgl->tanggal;

            // Hitung total jumlah pesanan 30 hari ke belakang
            $this->db->select_sum('jumlah');
            $this->db->where('tanggal <=', $tanggal);
            $this->db->where('tanggal >=', date('Y-m-d', strtotime($tanggal . ' -29 days')));
            $total = $this->db->get('pemesanan')->row()->jumlah;

            // Hitung jumlah hari unik yang memiliki data
            $this->db->select('tanggal');
            $this->db->where('tanggal <=', $tanggal);
            $this->db->where('tanggal >=', date('Y-m-d', strtotime($tanggal . ' -29 days')));
            $this->db->group_by('tanggal');
            $jumlahHari = $this->db->get('pemesanan')->num_rows();

            $nilai_ma = $jumlahHari > 0 ? round($total / $jumlahHari, 2) : 0;

            // Ambil id_pemesanan terakhir di tanggal tersebut
            $this->db->select('id_pemesanan');
            $this->db->where('tanggal', $tanggal);
            $this->db->order_by('id_pemesanan', 'desc');
            $this->db->limit(1);
            $id_pemesanan = $this->db->get('pemesanan')->row('id_pemesanan');

            $data = [
                'id_ma' => "PRD" . uniqid(),
                'id_pemesanan' => $id_pemesanan,
                'nilai' => $nilai_ma,
                'tanggal' => $tanggal
            ];

            // Insert atau update MA untuk tanggal ini
            $cek = $this->db->get_where('movingaverage', ['tanggal' => $tanggal])->row();
            if ($cek) {
                $this->db->where('tanggal', $tanggal);
                $this->db->update('movingaverage', $data);
            } else {
                $this->db->insert('movingaverage', $data);
            }
        }
    }

    public function predict_by_tanggal($tanggal_prediksi) {
        // Hitung tanggal 30 hari sebelumnya
        $tanggal_awal = date('Y-m-d', strtotime("$tanggal_prediksi -30 days"));
    
        // Ambil data pemesanan dalam rentang 30 hari sebelum tanggal prediksi
        $this->db->select('produk.id_produk, produk.nama_produk, pemesanan.jumlah, tb_stok.satuan');
        $this->db->from('pemesanan');
        $this->db->join('produk', 'produk.id_produk = pemesanan.id_produk');
        $this->db->join('tb_stok', 'tb_stok.id_produk = produk.id_produk');
        $this->db->where('pemesanan.tanggal >=', $tanggal_awal);
        $this->db->where('pemesanan.tanggal <', $tanggal_prediksi); // tidak termasuk hari prediksi
        $this->db->order_by('pemesanan.tanggal', 'ASC');
        $query = $this->db->get();
    
        $result = $query->result();
    
        if (empty($result)) {
            return []; // Tidak ada data dalam 30 hari terakhir
        }
    
        // Kelompokkan jumlah pemesanan per produk
        $produk_data = [];
        foreach ($result as $row) {
            if (!isset($produk_data[$row->id_produk])) {
                $produk_data[$row->id_produk] = [
                    'nama_produk' => $row->nama_produk,
                    'satuan'      => $row->satuan,
                    'total' => 0,
                    'count' => 0
                ];
            }
            $produk_data[$row->id_produk]['total'] += $row->jumlah;
            $produk_data[$row->id_produk]['count']++;
        }
    
        // Hitung Moving Average (rata-rata harian) per produk
        $prediksi = [];
        foreach ($produk_data as $id_produk => $data) {
            $average = $data['count'] > 0 ? $data['total'] / $data['count'] : 0;
    
            $prediksi[] = (object)[
                'tanggal_prediksi' => $tanggal_prediksi,
                'id_produk'        => $id_produk,
                'nama_produk'      => $data['nama_produk'],
                'jumlah_prediksi'  => round($average),
                'satuan'           => $data['satuan']
            ];
        }
    
        return $prediksi;
    }      

    // Ambil data untuk chart (semua tanggal)
    public function get_chart() {
        $this->db->select('tanggal, nilai');
        $this->db->from('movingaverage');
        $this->db->order_by('tanggal', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }
}