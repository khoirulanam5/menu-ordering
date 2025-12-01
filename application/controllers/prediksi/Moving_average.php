<?php 
defined("BASEPATH") OR exit("No direct script access allowed");

class Moving_average extends CI_Controller {    

    public function __construct() {
        parent::__construct();
        $this->load->model('MovingAverageModel');
        cekLogin();
    }

    public function index() {
        $tanggal = $this->input->get('tanggal');
        
        $is_prediksi = false;
        if ($tanggal) {
            $datas = $this->MovingAverageModel->predict_by_tanggal($tanggal);
            $is_prediksi = true;
        } else {
            $datas = $this->MovingAverageModel->get_all_ma();
        }

        // Ambil data untuk chart
        $chart = $this->MovingAverageModel->get_chart();

        $data = [
            "page"        => "prediksi/moving_average",
            "menu"        => "Moving Average",
            "datas"       => $datas ?: [],
            "is_prediksi" => $is_prediksi,
            "chart"       => $chart ?: []
        ];        

        $this->load->view("template/index", $data);
    }
}
