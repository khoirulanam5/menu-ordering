<?php 
defined("BASEPATH") or exit("No direct script access allowed");

class Kategori extends CI_Controller {

    public function __construct() {
        parent::__construct();
        cekLogin();
    }

    public function index() {
        $datas = $this->db->get('tb_kategori')->result();
        $data = array(
            "page" => "produk/kategori",
            "menu" => "Data Kategori",
            "datas" => $datas
        );
        $this->load->view("template/index", $data);
    }

    public function update() {
        $this->db->where("id_kategori", $this->input->post("id_kategori"));

        $data = $this->input->post();
        array_shift($data);

        if ($this->db->update("tb_kategori", $data)) {
            $this->session->set_flashdata("message", "swal.fire({title: 'Berhasil',text: 'Update data berhasil',icon:'success'});");
        } else {
            $this->session->set_flashdata("message", "swal.fire({title: 'Gagal',text: 'Update data gagal',icon:'success'});");
        }
        redirect("produk/kategori");
    }

    public function simpan() {
        $data = $this->input->post();
        array_shift($data);
    
        if ($this->db->insert("tb_kategori", $data)) {
            $this->session->set_flashdata("message", "swal.fire({title: 'Berhasil',text: 'Tambah data berhasil',icon:'success'});");
        } else {
            $this->session->set_flashdata("message", "swal.fire({title: 'Gagal',text: 'Tambah data gagal',icon:'error'});");
        }
        redirect("produk/kategori");
    }

    public function delete($id) {
        $this->db->where("id_kategori", $id);
        $this->db->delete("tb_kategori");
    }
}
