<?php 
defined( 'BASEPATH' ) OR exit( 'No direct script access allowed' );

class Pemesanan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        cekLogin();
    }

    public function index() {
        $data['page'] = 'laporan/pemesanan';
        $data['menu'] = 'Laporan Pemesanan';
        $data['datas'] = $this->db->get('pemesanan')->result();
    
        $this->load->view('template/index', $data);
    }    

    public function cetak() {
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
    
        // Filter berdasarkan jenis periode
        if ($periode == 'harian') {
            $this->db->where('tanggal >=', $awal);
            $this->db->where('tanggal <=', $ahir);
        } elseif ($periode == 'bulanan') {
            $tahunAwal = date('Y', strtotime($awal));
            $tahunAkhir = date('Y', strtotime($ahir));
    
            if ($tahunAwal !== $tahunAkhir) {
                echo "Laporan bulanan hanya bisa dalam tahun yang sama.";
                exit;
            }
    
            $bulanAwal = date('m', strtotime($awal));
            $bulanAkhir = date('m', strtotime($ahir));
    
            $this->db->where("YEAR(tanggal)", $tahunAwal);
            $this->db->where("MONTH(tanggal) BETWEEN $bulanAwal AND $bulanAkhir");
        } elseif ($periode == 'tahunan') {
            $tahunAwal = date('Y', strtotime($awal));
            $tahunAkhir = date('Y', strtotime($ahir));
    
            $this->db->where("YEAR(tanggal) BETWEEN $tahunAwal AND $tahunAkhir");
        } else {
            echo "Jenis periode tidak dikenali.";
            exit;
        }
    
        $this->db->from('pemesanan');
        $this->db->order_by('no_transaksi', 'desc');
        $items = $this->db->get()->result();
    
        $data['items']   = $items;
        $data['awal']    = $awal;
        $data['ahir']    = $ahir;
        $data['periode'] = $periode;
    
        $this->load->view('laporan/cetak_pemesanan', $data);
    }
}
