<?php 
defined("BASEPATH") OR exit("No direct script access allowed");

class Produk extends CI_Controller {

    public function __construct() {
        parent::__construct();
        cekLogin();
    }

    public function index() {
        $this->db->select('produk.*, tb_kategori.jenis');
        $this->db->from('produk');
        $this->db->join('tb_kategori', 'produk.jenis_pro = tb_kategori.jenis', 'left');
        $this->db->order_by('produk.id_produk', 'DESC');

        $datas = $this->db->get()->result();
        
        $data = array(
        "page" => "produk/produk",
        "menu" => "Data Produk",
        'datas' => (!empty($datas) ? $datas : "")
    );
        $this->load->view("template/index",$data);
    }

    public function update() {
        $rand = time();
        $ekstensi =  array('png','jpg','jpeg','gif');
        $data  = array(
            "nama_produk" =>$this->input->post("nama_produk"),
            "jenis_pro" =>$this->input->post("jenis_pro"),
            "diskripsi" =>$this->input->post("diskripsi"),
            "harga_jualpro" =>$this->input->post("harga_jualpro")
        );
        $this->db->where("id_produk",$this->input->post("id_produk"));
        if(!empty($_FILES['images']['name'])){
            $filename = $_FILES['images']['name'];
            $ukuran = $_FILES['images']['size'];
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            $data["images"] = $rand.'_'.$filename; 
    
            if(!in_array($ext,$ekstensi) ) {
                $this->session->set_flashdata("message", "swal.fire({title: 'Gagal',text: 'Gagal Upload File',icon:'error'});");
            }else{
                if($ukuran < 1044070){		
                    move_uploaded_file($_FILES['images']['tmp_name'], 'images/'.$rand.'_'.$filename);
                    $this->db->update("produk",$data);
                    $this->session->set_flashdata("message", "swal.fire({title: 'Berhasil',text: 'Update data berhasil',icon:'success'});");
                }else{
                    $this->session->set_flashdata("message", "swal.fire({title: 'Gagal',text: 'Update data gagal',icon:'error'});");
                }
            }
        }else{
            $this->db->update("produk", $data);
            $this->session->set_flashdata("message", "swal.fire({title: 'Berhasil',text: 'Update data berhasil',icon:'success'});");
        }
        redirect("produk/produk/");
    }   

    public function simpan() {
        $rand = rand();
        $ekstensi =  array('png','PNG','jpg','JPG','JPEG','jpeg','gif');
        $filename = $_FILES['images']['name'];
        $ukuran = $_FILES['images']['size'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $data  = array(
            "nama_produk" =>$this->input->post("nama_produk"),
            "jenis_pro" =>$this->input->post("jenis_pro"),
            "diskripsi" =>$this->input->post("diskripsi"),
            "harga_jualpro" =>$this->input->post("harga_jualpro"),
            "images" =>$rand.'_'.$filename	
        );
        if(!in_array($ext,$ekstensi) ) {
            $this->session->set_flashdata("message", "swal.fire({title: 'Gagal',text: 'Gagal upload file',icon:'error'});");
        }else{
            if($ukuran < 1044070){		
                move_uploaded_file($_FILES['images']['tmp_name'], 'images/'.$rand.'_'.$filename);
                $ins = $this->db->insert("produk", $data );
                $this->session->set_flashdata("message", "swal.fire({title: 'Berhasil',text: 'Tambah data berhasil',icon:'success'});");
            }else{
                $this->session->set_flashdata("message", "swal.fire({title: 'Error',text: 'Tambah data gagal',icon:'error'});");
            }
        }
        redirect("produk/produk/");
    }

    public function delete($id) {
        $this->db->where("id_produk", $id);
        $this->db->delete("produk");
    }
}
