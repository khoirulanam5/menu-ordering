<?php 
defined("BASEPATH") OR exit("No direct script access allowed");

class Pengiriman extends CI_Controller {	
	public function __construct() {
		parent::__construct();
        cekLogin();
	}

	public function index() {
        $this->db->select( "*" );
        $this->db->from( "pengiriman p" );
        $this->db->join('detail_jual d','p.no_transaksi = d.no_transaksi','left');
        $datas = $this->db->get()->result();

		$data = array(
			"page" => "penjualan/pengiriman",
            "menu" => "pengiriman",
			"datas" => $datas
		);
			$this->load->view("template/index",$data);
		}

    public function update() {
        $this->db->where("id_pengiriman",$this->input->post("id_pengiriman"));
        $data  = array(
            "nama_pengiriman" => $this->input->post("nama_pengiriman"),
            "alamat" => $this->input->post("alamat"),
            "no_hp" => $this->input->post("no_hp"),
            "email" => $this->input->post("email")
        );
        $this->db->update("pengiriman",$data);
        $this->session->set_flashdata("message", "swal({title: 'Berhasil',text: 'Update data berhasil',icon:'success'});");
        redirect("transaksi/pengiriman/");
    }   

    public function simpan() {
        $data  = array(
            "nama_pengiriman" => $this->input->post("nama_pengiriman"),
            "alamat" => $this->input->post("alamat"),
            "no_hp" => $this->input->post("no_hp"),
            "email" => $this->input->post("email")
        );
        $ins = $this->db->insert( "pengiriman", $data );
        $this->session->set_flashdata("message", "swal({title: 'Berhasil',text: 'Tambah data berhasil',icon:'success'});");
        redirect("transaksi/pengiriman/");
    }

    public function delete($id) {
        $this->db->where("no_transaksi",$id);
        $delt = $this->db->delete("detail_jual");
        $this->db->where("no_transaksi",$id);
        $delt = $this->db->delete("pengiriman");
        echo ( $delt > 0 ) ? "1" : "0";
    }
    
    public function update_no_resi() {
        $no_transaksi = $this->input->post('no_transaksi');
        $data = array(
            "no_resi" => $this->input->post('no_resi')
        );
        $cek = $this->db->get_where('detail_jual',array('no_transaksi'=>$no_transaksi))->row();
       if(!empty($cek)){
            $this->db->where('no_transaksi', $no_transaksi);
            $update = $this->db->update('detail_jual', $data);
            if ( $update > 0 ){
                $this->session->set_flashdata("message", "swal({title: 'Berhasil',text: 'Tambah data berhasil',icon:'success'});");
                redirect("transaksi/pengiriman/");
            }
       }
    }   
}
