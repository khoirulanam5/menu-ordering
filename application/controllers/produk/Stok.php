<?php 
defined("BASEPATH") OR exit("No direct script access allowed");

class Stok extends CI_Controller {	

    public function __construct() {
        parent::__construct();
        cekLogin();
    }
    public function index() {
        $this->db->select('tb_stok.*, produk.nama_produk');
        $this->db->from('tb_stok');
        $this->db->join('produk', 'tb_stok.id_produk = produk.id_produk', 'left');
        $datas = $this->db->get()->result();
        
        $data = array(
        "page" => "produk/stok",
        "menu" => "Data Stok",
        'datas' => (!empty($datas) ? $datas : "")
    );
        $this->load->view("template/index", $data);
    }
    
    public function simpan() {
        $data  = array(
            "id_produk" =>$this->input->post("id_produk"),
            "jml_stok" => $this->input->post("jml_stok")	
        );
        $insert = $this->db->insert("tb_stok", $data);
            if($insert) {
                $this->session->set_flashdata("message", "swal.fire({title: 'Berhasil',text: 'Tambah data berhasil',icon:'success'});");
            }else {
                $this->session->set_flashdata("message", "swal.fire({title: 'Error',text: 'Tambah data gagal',icon:'error'});");
            }
        redirect("produk/stok/");
    }

    public function update() {
        $data = array(
            "id_produk" => $this->input->post("id_produk"),
            "jml_stok" => $this->input->post("jml_stok")
        );

        $this->db->where("id_stok", $this->input->post("id_stok"));
        $update = $this->db->update("tb_stok", $data);
    
        if ($update) {
            $this->session->set_flashdata("message", "swal.fire({title: 'Berhasil', text: 'Update data berhasil', icon: 'success'});");
        } else {
            $this->session->set_flashdata("message", "swal.fire({title: 'Error', text: 'Update data gagal', icon: 'error'});");
        }
        redirect("produk/stok/");
    }    

    public function delete($id) {
        $this->db->where('id_stok', $id);
        $this->db->delete('tb_stok');
    }
}
