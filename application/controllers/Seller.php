<?php 
defined("BASEPATH") OR exit("No direct script access allowed");

class Seller extends CI_Controller {	
   
  public function __construct() {
    parent::__construct();
  }

  public function index() {
   redirect("public/home");
  }
}
