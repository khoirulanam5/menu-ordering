<?php

    // hak akses
	function ispemilik()
	{
		$ci = get_instance();
		$jabatan = $ci->session->userdata('level');
		if ($jabatan != 'pemilik') {
			redirect('public/home');
		}
	}
	function iskasir()
	{
		$ci = get_instance();
		$jabatan = $ci->session->userdata('level');
		if ($jabatan != 'kasir') {
			redirect('public/home');
		}
	}
	function ispelanggan()
	{
		$ci = get_instance();
		$jabatan = $ci->session->userdata('pelanggan');
		if ($jabatan != 'pelanggan') {
			redirect('public/home');
		}
	}

    // get userdata
    function userData()
	{
		$ci = get_instance();
		$ci->db->where('username =', $ci->session->userdata('username'));
		return $ci->db->get('tb_users')->row();
	}