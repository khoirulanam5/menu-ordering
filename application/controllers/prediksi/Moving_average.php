<?php 
defined("BASEPATH") OR exit("No direct script access allowed");

class Moving_average extends CI_Controller {	

    public function __construct() {
        parent::__construct();
        $this->load->model('MovingAverageModel');
        cekLogin();
    }

    public function index() {
        $datas = $this->MovingAverageModel->get_all_ma();
    
        $data = array(
            "page" => "prediksi/moving_average",
            "menu" => "Moving Average",
            "datas" => (!empty($datas) ? $datas : ""),
            "chart" => $this->MovingAverageModel->get_chart()
        );
        $this->load->view("template/index", $data);
    }    
}