<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pemesanan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Produk_model');
        $this->load->model('PemesananModel');
        $this->load->model('MovingAverageModel');
        $this->load->library('pagination');
    }

    public function index() {
        // Konfigurasi pagination
        $config = array();
        $config['base_url'] = site_url('transaksi/pemesanan/index');
        $config['total_rows'] = $this->PemesananModel->get_count();
        $config['per_page'] = 10;
        $config['uri_segment'] = 4;
        $config['attributes'] = array('class' => 'page-link');
    
        // Konfigurasi Bootstrap untuk pagination
        $config['full_tag_open'] = '<ul class="pagination justify-content-center">';
        $config['full_tag_close'] = '</ul>';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
    
        $this->pagination->initialize($config);
    
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
    
        $data['pemesanan'] = $this->PemesananModel->get_pemesanan($config['per_page'], $page);
        $data['pagination'] = $this->pagination->create_links();
    
        $data['produk'] = $this->Produk_model->get_all_produk();
        $data['page'] = "penjualan/pemesanan";
        $data['menu'] = "Pemesanan";
    
        $this->load->view("template/index", $data);
    }    

    public function generateNoTransaksi() {
        $unik = "TR" . date('Ym');
        $result = $this->db->query("SELECT MAX(no_transaksi) AS LAST_NO FROM pemesanan WHERE no_transaksi LIKE '".$unik."%'")->row();

        if ($result && $result->LAST_NO) {
            $urutan = (int) substr($result->LAST_NO, 8, 5);
            $urutan++;
        } else {
            $urutan = 1;
        }

        $kode = $unik . sprintf("%05s", $urutan);
        return $kode;
    }

    public function create() {
        
            $no_transaksi = $this->generateNoTransaksi();
            $produk_ids = $this->input->post('id_produk');
            $jumlahs = $this->input->post('jumlah');
            $tanggal = $this->input->post('tanggal');
    
            foreach ($produk_ids as $index => $id_produk) {
                $jumlah = $jumlahs[$index];
                $produk = $this->Produk_model->get_produk_by_id($id_produk);
                $total_harga = $produk->harga_jualpro * $jumlah;
    
                $data = array(
                    'no_transaksi' => $no_transaksi,
                    'id_produk' => $id_produk,
                    'harga' => $produk->harga_jualpro,
                    'jumlah' => $jumlah,
                    'total_harga' => $total_harga,
                    'tanggal' => $tanggal
                );
                $insert = $this->db->insert('pemesanan', $data);
                if ($insert) {
                    $this->Produk_model->update_stok($id_produk, $jumlah);
                }
                $this->MovingAverageModel->hitung();

            }
            $this->session->set_flashdata("message", "swal.fire({title: 'Berhasil', text: 'Simpan data berhasil', icon: 'success'});");
            redirect('transaksi/pemesanan');
    }    

    public function cetak_nota($no_transaksi) {
        $this->load->model('PemesananModel');
        $data['pemesanan'] = $this->PemesananModel->get_pemesanan_by_no_transaksi($no_transaksi);
        $this->load->view('laporan/nota_pemesanan', $data);
    }


    public function cetak_laporan() {
        $this->load->model('PemesananModel');
        $data['pemesanan'] = $this->PemesananModel->get_all_pemesanan();
        $this->load->view('laporan/cetak_laporan', $data);
    }
}
