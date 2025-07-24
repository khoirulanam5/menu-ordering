<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Midtrans {
    public function __construct() {
        // Kode inisialisasi library Midtrans Anda di sini
        require_once APPPATH . 'libraries/Midtrans/Config.php';
        require_once APPPATH . 'libraries/Midtrans/Transaction.php';
        require_once APPPATH . 'libraries/Midtrans/ApiRequestor.php';
        require_once APPPATH . 'libraries/Midtrans/Notification.php';
        require_once APPPATH . 'libraries/Midtrans/CoreApi.php';
        require_once APPPATH . 'libraries/Midtrans/Snap.php';
        require_once APPPATH . 'libraries/Midtrans/Sanitizer.php';
    }
}
