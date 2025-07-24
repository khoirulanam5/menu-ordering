<?php 
defined("BASEPATH") OR exit("No direct script access allowed");

class Penjualan extends CI_Controller {	

    public function __construct() {
        parent::__construct();
        cekLogin();
        $this->load->model("M_join","joins");
        $this->load->model("Penjualan_model");
    }

    public function index() {
        $this->joins->detailjualpenjualan();
        $this->db->where("status_bayar >",'0');
        $this->db->order_by('b.no_transaksi','desc');
        $datas = $this->db->get()->result();
       
        $this->joins->detailjual_pengiriman_pelanggan();
        $this->db->order_by('detail_jual.no_transaksi','desc');
        $datas_detail = $this->db->get()->result();

        $total['selesai'] = 0;
        $total['proses'] = 0;
        $total['belum_verifikasi'] = 0;
        foreach ($datas as $key => $value) {
            if (!empty($value->tgl_jual)) {
                $total['selesai']++;
            }
            if ($value->status_kirim == 1) {
                $total['proses']++;
            }
        }
        foreach ($datas_detail as $key => $value) {
            if ($value->status_kirim == 0) {
                $total['belum_verifikasi']++;
            }
        }
        $total['penjualan'] = $total['selesai']+$total['proses']+$total['belum_verifikasi'];
        $data = array(
        "page" => "penjualan/penjualan",
        "menu" => "Data Penjualan",
        "total" => $total,
        "datas" => $datas
         );
        $this->load->view("template/index",$data);
    }

    public function cek_penjualan($resi) {
        $this->db->select("*");
        $this->db->from("penjualan p");
        $this->db->join("pelanggan n","p.id_pelanggan = n.id_pelanggan","left");
        $this->db->where("p.no_transaksi", $resi);
        $penjualan = $this->db->get()->row();
        echo json_encode($penjualan);
    }

    public function diterima_pembeli() {
        $data  = array(
            "tgl_jual" =>$this->input->post("tgl_jual"),
        );
        $this->db->where("id_penjualan",$this->input->post("id_penjualan"));
        $this->db->update("penjualan",$data);
        $datas  = array(
            "status_kirim" =>$this->input->post("status_kirim"),
            "nama_penerima" =>$this->input->post("nama_penerima"),
        );
        $this->db->where("no_transaksi",$this->input->post("no_transaksi"));
        $this->db->update("pengiriman",$datas);

        // masukan function dalam bentuk $no_transaksi
        // $this->sendNotifTerima($this->input->post('no_transaksi'));

        echo true;
    }   

    public function update() {
        $data  = array(
            "tgl_jual" =>$this->input->post("tgl_jual"),
        );
        $this->db->where("id_penjualan",$this->input->post("id_penjualan"));
        $this->db->update("penjualan",$data);
        $datas  = array(
            "status_kirim" =>$this->input->post("status_kirim"),
            "nama_penerima" =>$this->input->post("nama_penerima"),
        );
        $this->db->where("no_transaksi",$this->input->post("no_transaksi"));
        $this->db->update("pengiriman",$datas);
        $this->session->set_flashdata("message", "swal.fire({title: 'Berhasil',text: 'Update data berhasil',icon:'success'});");
        redirect("transaksi/penjualan/");
    }   
    
    public function detail_penjualan_Update() {
        if($this->session->username == 'kasir' ){
            $this->session->set_flashdata("message", "swal.fire({title: 'Gagal',text: 'Anda harus login sebagai kasir',icon:'error'});");
            redirect("transaksi/penjualan/detail_pejualan");
        }
        $dts = json_decode($this->input->post('data_produk'));
        $data  = array(
            "status_bayar" =>$this->input->post("status_bayar")	
        );
        $this->db->where("no_transaksi",$this->input->post("no_transaksi"));
        $this->db->update("detail_jual",$data);
        $kirim = (($this->input->post("status_bayar") == 1) ? 1:0);
        $datas = array(
            "status_kirim" =>$kirim,
        );
        $this->db->where("no_transaksi",$this->input->post("no_transaksi"));
        $this->db->update("pengiriman",$datas);
        $id_pegawai =$this->db->get_where('pegawai',array("email"=>$this->session->username))->row();
     
        $jual = array(
         "id_pelanggan" =>$this->input->post("id_pelanggan"),
         "no_transaksi" =>$this->input->post("no_transaksi"),
         "id_pegawai" =>$id_pegawai->id_pegawai,
         "tgl_jual" =>$this->input->post("tgl_jual"),	
        );
        $this->db->where("no_transaksi",$this->input->post("no_transaksi"));
        $this->db->insert('penjualan',$jual);

        // $this->sendNotifPelanggan($this->input->post('no_transaksi'));

        $this->session->set_flashdata("message", "swal.fire({title: 'Berhasil',text: 'Pesanan sudah dikirim',icon:'success'});");
        redirect("transaksi/penjualan/detail_pejualan");
    }   

    public function simpan() {
        $data  = array(
            "tgl_jual" =>$this->input->post("tgl_jual"),
            "id_pegawai" =>$this->input->post("id_pegawai"),
            "id_pelanggan" =>$this->input->post("id_pelanggan"),
            "total_bayar" =>$this->input->post("total_bayar"),
            "bayar" =>$this->input->post("bayar"),
            "kembali" =>$this->input->post("kembali")
        );
        $ins = $this->db->insert( "penjualan", $data );
        $this->session->set_flashdata("message", "swal.fire({title: 'Berhasil',text: 'Tambah data berhasil',icon:'success'});");
        redirect("transaksi/penjualan/");
    }

    public function delete() {
        $data = json_decode($this->input->post("row"));
        $datas = array(
            "table1"=>"penjualan",
            "table2"=>"detail_jual",
            "table3"=>'pengiriman',
            "field"=>"no_transaksi"
        );
        echo delete_trunc2($datas,$data[0]);
    }

    public function cetak_nota($no_transaksi) {
        $data['value'] = $this->Penjualan_model->get_transaksi_id($no_transaksi);
        $this->load->view('laporan/nota_penjualan', $data);
    }

    public function detail_pejualan() {
        $this->joins->detailjual_pengiriman_pelanggan();
        $this->db->order_by('detail_jual.no_transaksi','desc');
        $datas = $this->db->get()->result();
        
        $data = array(
        "page" => "penjualan/detail_penjualan",
        "menu" => "Detail Penjualan",
        "datas" => $datas
         );
        $this->load->view("template/index",$data);
    }

    public function cek_harga() {
        $data['origin']      = $this->input->post('origin');
        $data['destination'] = $this->input->post('destination');
        $data['courier']     = $this->input->post('kurir');
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.rajaongkos_kirim.com/starter/cost',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => $data,
          CURLOPT_HTTPHEADER => array(
            'key: 00b8f2653dec48a32b872c686fff55ca'
          ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        echo $response;
    }
}
