<?php
function cekLogin()
{
    $CI =& get_instance();
    if (empty($CI->session->userdata("username"))) {
        redirect("login");
    }
}
function custom (){
    $json = file_get_contents(base_url("sources/custommenu.json"));
    $obj  = json_decode($json);
    return $obj;
}
function rp($var = null)
{
    $hasil_rupiah = "Rp " . number_format($var,0,',','.');
    return $hasil_rupiah;
}
function p($val)
{
    echo "<pre>";
    return  print_r($val);
}
function alert_success($var)
{
    $CI =& get_instance();
    return $CI->session->set_flashdata("pesan",'<script>swal({title: "Berhasil",text: "'.$var.'",icon: "success"})</script>');
}
function alert_error($var)
{
    $CI =& get_instance();
    return $CI->session->set_flashdata("pesan",'<script>swal({title: "Gagal",text: "'.$var.'",icon: "error"})</script>');
}
function cek_kirim($var)
{
    $CI =& get_instance();
    $CI->joins->detailjualpenjualan();
    $CI->db->where("status_bayar >",'0');
    $CI->db->where('status_kirim', $var);
    $CI->db->order_by('b.no_transaksi','desc');
    $datase = $CI->db->get()->result();
    return $datase;
}
function cek_bayar($var)
{
    $CI =& get_instance();
    $CI->joins->detailjual_pengiriman_pelanggan();
    $CI->db->where('status_kirim', $var);
    $CI->db->order_by('detail_jual.no_transaksi','desc');
    $datas_detail = $CI->db->get()->result();
    return $datas_detail;
}

function delete_trunc2($data=array(),$id=''){
	$help =& get_instance();
	$table1 = $data['table1'];
	$table2 = $data['table2'];
	$table3 = $data['table3'];
	$field  = $data['field'];
	$help->db->trans_begin();
  $help->db->query("DELETE FROM $table1 WHERE $field ='$id'");
  $help->db->query("DELETE FROM $table2 WHERE $field ='$id'");
  $help->db->query("DELETE FROM $table3 WHERE $field ='$id'");
  if ($help->db->trans_status() === FALSE)
  {
    $help->db->trans_rollback();
    $res = false;
  }
  else
  {
    $help->db->trans_commit();
    $res = true;
  }
  return $res;
}
function upload_file($data=array()){
    $CI =& get_instance();
    $pecah = explode('.', $_FILES[$data['name']]['name']);
    $file = $pecah[count($pecah) - 1];
    
    $config['upload_path'] = './'.$data['path'].'/';
    $config['allowed_types'] = $data['type'];
    $config['file_name'] = time().'_.'.$file;
    $config['max_size'] = 2000;
    $config['max_width'] = 1500;
    $config['max_height'] = 1500;
    $CI->load->library('upload', $config);
    $CI->upload->initialize($config);
    if (!$CI->upload->do_upload($data['name'])) {
        $resp = array('error' => $CI->upload->display_errors());
    } else {
        $resp = array('success' => $CI->upload->data());
    }
    return json_encode($resp);
}

function do_formal_date($date='',$delimiter = '',$is_day=false)
	{
		if (empty($date)) 
		{
			$date = date('d M Y');
		}

		if (!empty($date)) 
		{
			$day = '';
			if ($is_day) 
			{
				$days = ['Saturday' => 'Sabtu',
						 'Sunday' 	=> 'Minggu', 
						 'Monday' 	=> 'Senin', 
						 'Tuesday'  => 'Selasa', 
						 'Wednesday'=> 'Rabu', 
						 'Thursday' => 'Kamis',
						 'Friday' 	=> 'Jum\'at'];
				$day = $days[date('l', strtotime($date))].', ';
			}
			$months =['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
			$d = date('d', strtotime($date));
			$m = date('m', strtotime($date));
			$y = date('Y', strtotime($date));

			$delimiter = !empty($delimiter) ? $delimiter : ' ';
			return $day.$d.$delimiter.$months[intval($m)].$delimiter.$y;
		}
	}