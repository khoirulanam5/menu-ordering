<?php 
defined("BASEPATH") OR exit("No direct script access allowed");

class Dashboard extends CI_Controller {	

	public function __construct() {
		parent::__construct();
	}

	public function index() {
		$data['title'] = '';
		$this->load->view('template/Css');
		$this->load->view('template/Navtop', $data);
		$this->load->view('template/LeftMenu');
		$this->load->view('dashboard/index');
		$this->load->view('template/footer');
		$this->load->view('template/js');
	}
}
