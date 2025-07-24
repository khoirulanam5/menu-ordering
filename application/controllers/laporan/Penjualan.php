<?php 
defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

class Penjualan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        cekLogin();
        $this->load->model("M_join","joins");
    }

    public function index() {
        $this->joins->detailjualpenjualan();
        $this->db->where("status_bayar >",'0');
        $this->db->order_by('b.no_transaksi','desc');
        $tb = $this->db->get()->result();
        $data = array(
            'page' => 'laporan/penjualan',
            'menu' => 'Laporan Penjualan',
            'datas' => (isset($tb) ? $tb:"")
        );
        $this->load->view('template/index', $data );
    }

    public function periode() {
        // Ambil input
        $awal    = $this->input->get('tanggal1');
        $ahir    = $this->input->get('tanggal2');
        $periode = $this->input->get('periode');
    
        // Validasi input
        if (!$awal || !$ahir || !$periode) {
            echo "Input tanggal dan periode tidak boleh kosong!";
            exit;
        }
    
        // Pastikan tanggal valid
        if (!strtotime($awal) || !strtotime($ahir)) {
            echo "Format tanggal tidak valid!";
            exit;
        }
    
        // Join tabel-tabel terkait
        $this->joins->detailjualpenjualan();
    
        // Filter berdasarkan status pembayaran dan pengiriman
        $this->db->where("status_bayar >", '0');
        $this->db->where("status_kirim", 2);
    
        // Filter berdasarkan jenis periode
        if ($periode == 'harian') {
            $this->db->where('tgl_jual >=', $awal);
            $this->db->where('tgl_jual <=', $ahir);
        } elseif ($periode == 'bulanan') {
            $tahunAwal = date('Y', strtotime($awal));
            $tahunAkhir = date('Y', strtotime($ahir));
    
            if ($tahunAwal !== $tahunAkhir) {
                echo "Laporan bulanan hanya bisa dalam tahun yang sama.";
                exit;
            }
    
            $bulanAwal = date('m', strtotime($awal));
            $bulanAkhir = date('m', strtotime($ahir));
    
            $this->db->where("YEAR(tgl_jual)", $tahunAwal);
            $this->db->where("MONTH(tgl_jual) BETWEEN $bulanAwal AND $bulanAkhir");
        } elseif ($periode == 'tahunan') {
            $tahunAwal = date('Y', strtotime($awal));
            $tahunAkhir = date('Y', strtotime($ahir));
    
            $this->db->where("YEAR(tgl_jual) BETWEEN $tahunAwal AND $tahunAkhir");
        } else {
            echo "Jenis periode tidak dikenali.";
            exit;
        }
    
        $this->db->order_by('b.no_transaksi', 'desc');
        $items = $this->db->get()->result();
    
        $data['items']   = $items;
        $data['awal']    = $awal;
        $data['ahir']    = $ahir;
        $data['periode'] = $periode;
    
        $this->load->view('laporan/cetak_penjualan', $data);
    }
}
