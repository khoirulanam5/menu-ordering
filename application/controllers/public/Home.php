<?php 
defined("BASEPATH") or exit("No direct script access allowed");

class Home extends CI_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->model("M_join", "joins");
    $this->load->helper(array('form', 'url'));
    $this->load->library('midtrans');
    $this->load->config('midtrans');
        
    \Midtrans\Config::$serverKey = $this->config->item('server_key');
    \Midtrans\Config::$isProduction = $this->config->item('is_production');
    \Midtrans\Config::$isSanitized = $this->config->item('is_sanitized');
    \Midtrans\Config::$is3ds = $this->config->item('is_3ds');
  }

  public function index() {
        $this->db->select('produk.*, tb_stok.jml_stok');
        $this->db->from('produk');
        $this->db->join('tb_stok', 'produk.id_produk = tb_stok.id_produk', 'left');
        $datas = $this->db->get()->result();

        $this->joins->pdetail();
        $this->db->where("a.id_pelanggan", $this->session->username);
        $this->db->where("a.id_produk >", '0');
        $this->db->group_by("b.id_produk");
        $keranjang = $this->db->get()->result();

        // Total transaksi pelanggan (tidak lagi digunakan untuk diskon)
        $this->db->where('id_pelanggan', $this->session->username);
        $total_transaksi = $this->db->count_all_results('penjualan');

        // Tidak ada diskon
        $diskon_pelanggan = 0;

        // Hitung total pembelian keranjang
        $total_p = 0;
        foreach ($keranjang as $key => $val) {
            $total_p += ($val->jumlah * $val->harga_jualpro);
        }

        $data = array(
            "page" => "public/pages",
            "tabs" => "WM Garang Asem",
            "keranjang" => $keranjang,
            "notif" => 1,
            'datas' => (!empty($datas) ? $datas : "")
        );
        $this->load->view("public/index", $data);
    }

    public function detail($id) {
        $this->db->select('produk.*, tb_stok.jml_stok');
        $this->db->from('produk');
        $this->db->join('tb_stok', 'produk.id_produk = tb_stok.id_produk', 'left');
        $this->db->where('produk.id_produk', $id);
        $item = $this->db->get()->result();
    
        // Hapus logika diskon, hanya tampilkan data produk
    
        $data = array(
            "page" => "public/products_detail",
            "tabs" => "WM Garang Asem",
            "datas" => !empty($item) ? $item[0] : null,
        );
        $this->load->view("public/index", $data);
    }    

    public function cart() {
        $this->joins->pdetail();
        $this->db->where("a.id_pelanggan", $this->session->username);
        $this->db->where("a.id_produk >", '0');
        $this->db->group_by("b.id_produk");
        $keranjang = $this->db->get()->result();
    
        $total_p = 0;
    
        // Perhitungan total tanpa diskon
        foreach ($keranjang as $key => $val) {
            $total_p += ($val->jumlah * $val->harga_jualpro);
        }
    
        $total_bayar = $total_p;
    
        $data = array(
            "page" => "public/products_cart",
            "tabs" => "Keranjang",
            "keranjang" => $keranjang,
            "total_bayar" => $total_bayar,
        );
        $this->load->view("public/index", $data);
    }    

    public function checkout() {
        if ($this->session->level != "pelanggan") {
            $this->session->set_flashdata("message", "swal.fire({title: 'Maaf',text: 'Anda harus login terlebih dahulu',icon:'warning'});");
            redirect("public/home");
        }
    
        $this->joins->pdetail();
        $this->db->where("a.id_pelanggan", $this->session->username);
        $this->db->where("a.id_produk >", '0');
        $this->db->group_by("b.id_produk");
        $keranjang = $this->db->get()->result();
    
        $total_p = 0;
    
        // Perhitungan total harga (tanpa diskon)
        foreach ($keranjang as $key => $val) {
            $total_p += ($val->jumlah * $val->harga_jualpro);
        }
    
        $almt = $this->db->get_where("pelanggan", array("id_pelanggan" => $this->session->username))->row();
        $default_ongkos_kirim = $this->db->get_where("ongkos_kirim", array("lokasi_tujuan" => $almt->kabupaten))->row();
    
        $data = array(
            "almt" => $almt,
            "ongkos_kirim" => $default_ongkos_kirim,
            "keranjang" => $keranjang,
            "total_bayar" => ($total_p + $default_ongkos_kirim->biaya),
        );
        $data["detail_jual"] = json_encode($data);
        $data["page"] = "public/products_checkout";
        $data["tabs"] = "Pembayaran";
    
        $this->load->view("public/index", $data);
    }    

  public function keranjang() {
    if ($this->session->level != "pelanggan") {
        $this->session->set_flashdata("message", "swal.fire({title: 'Maaf',text: 'Anda harus login terlebih dahulu',icon:'warning'});");
        redirect("public/home");
    }

    $id = $this->input->post('id_produk');

    if (!empty($this->input->post("id_pel"))) {
        if ($this->input->post("jumlah_order") > 0) {
            // Ambil data stok dari tabel stok
            $stok = $this->db->get_where("tb_stok", array('id_produk' => $id))->row();
            
            if ($stok && $stok->jml_stok >= $this->input->post("jumlah_order")) {
                // Insert data ke tabel detail_beli_produk
                $data = array(
                    "id_produk" => $id,
                    "id_pelanggan" => $this->input->post("id_pel"),
                    "jumlah" => $this->input->post("jumlah_order"),
                    "tanggal" => date("Y-m-d")
                );
                $this->db->insert("detail_beli_produk", $data);
                
                // Update jumlah stok di tabel stok
                $sisa = $stok->jml_stok - $this->input->post("jumlah_order");
                $this->db->where('id_produk', $id);
                $this->db->update("tb_stok", array("jml_stok" => $sisa));

                $this->session->set_flashdata("message", 'swal.fire({
                    title: "Berhasil",
                    text: "Tambah item ke keranjang",
                    icon: "success"
                });');
            } else {
                $this->session->set_flashdata("message", 'swal.fire({
                    title: "Gagal!",
                    text: "Jumlah pesanan melebihi stok yang tersedia",
                    icon: "error"
                });');
            }
        } else {
            $this->session->set_flashdata("message", 'swal.fire({
                title: "Gagal!",
                text: "Jumlah Pesanan Tidak Boleh kurang dari 1",
                icon: "error"
            });');
        }
    } else {
        $this->session->set_flashdata("message", 'swal.fire({
            title: "Gagal!",
            text: "Silahkan Login",
            icon: "error"
        });');
    }
    redirect("public/home/detail/$id");
  }

  public function update_keranjang() {
    $id_detail_produk = $this->input->post('id_detail_produk');
    $jumlah_baru = $this->input->post('jumlah');

    // Ambil data produk dari tabel detail_beli_produk
    $detail_produk = $this->db->get_where('detail_beli_produk', ['id_detail_produk' => $id_detail_produk])->row();

    if ($detail_produk) {
        $id_produk = $detail_produk->id_produk;

        // Ambil data stok yang ada
        $stok = $this->db->get_where('tb_stok', ['id_produk' => $id_produk])->row();

        // Hitung perubahan jumlah stok
        $stok_baru = $stok->jml_stok + $detail_produk->jumlah - $jumlah_baru;

        if ($stok_baru >= 0) {
            // Update jumlah produk di keranjang
            $this->db->where('id_detail_produk', $id_detail_produk);
            $this->db->update('detail_beli_produk', ['jumlah' => $jumlah_baru]);

            // Update stok produk
            $this->db->where('id_produk', $id_produk);
            $this->db->update('tb_stok', ['jml_stok' => $stok_baru]);

            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Stok tidak mencukupi']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Produk tidak ditemukan']);
    }
  }

  public function keranjang_del($id) {
      if (!empty($this->input->get("ses"))) {
          $cek = $this->db->get_where("detail_beli_produk", array("id_detail_produk" => $id))->row();
          if (!empty($cek)) {
              if ($cek->id_produk > 0) {
                  $this->db->select("sum(jumlah) as jumlah");
                  $this->db->from("detail_beli_produk");
                  $this->db->where("id_produk", $cek->id_produk);
                  $this->db->group_by('id_produk');
                  $produk = $this->db->get()->row();
                  $stok = $this->db->get_where("tb_stok", array("id_produk" => $cek->id_produk))->row();
                  $jml = $stok->jml_stok + $produk->jumlah;
                  $this->db->where("id_produk", $cek->id_produk);
                  $this->db->update("tb_stok", array("jml_stok" => $jml));

                  $this->db->where("id_produk", $cek->id_produk);
                  $this->db->delete("detail_beli_produk");
              }
              $this->session->set_flashdata("message", "swal.fire({title: 'Berhasil',text: 'Hapus berhasil',icon:'success'});");
          }
      }
      redirect("public/home/cart");
  }

  public function ongkos_kirim($id) {
    $ongkos = $this->db->get_where("ongkos_kirim", array("id_ongkos" => $id))->result();
    echo json_encode($ongkos);
  }

  public function pengiriman() {
    $id = $this->input->post("datas");
    if (!empty($this->input->post('courier'))) {
      $jasalain = array(
        'courier' => $this->input->post('courier'),
        'ongkos_kirim' => $this->input->post('ongkos_kirim')
      );
      $keterangan = json_encode($jasalain);
    } else {
      $keterangan = '';
    }
    $dt = json_decode(base64_decode($this->input->post('datas')));
    if (!empty($this->input->post('courier'))) {
      $dt->total_bayar = ($dt->total_bayar - $dt->ongkos_kirim->biaya) + $this->input->post('ongkos_kirim');
      $dt->ongkos_kirim->biaya = $this->input->post('ongkos_kirim');
      $dt->ongkos_kirim->jenis = $this->input->post('courier');
      $dt->ongkos_kirim->id_ongkos = 6;
    }

    $isi = base64_decode($id);
    $data = array(
      "no_transaksi" => "WM" . time(),
      "id_pelanggan" => $this->session->username,
      "data_produk" => json_encode($dt),
      "tanggal_order" => date('Y-m-d'),
      "tipe_pembayaran" => 'Midtrans'
    );
    $this->db->insert("detail_jual", $data);
    $this->db->select("no_transaksi");
    $this->db->from("detail_jual");
    $this->db->order_by("no_transaksi desc");

    $resi = $this->db->get()->row();
    $data_isi = json_decode($isi);

    $pengiriman = array(
      "no_transaksi" => $data['no_transaksi'],
      "id_ongkos" => $data_isi->ongkos_kirim->id_ongkos,
      "keterangan" => $keterangan,
    );
    $this->db->insert("pengiriman", $pengiriman);
    $this->db->where("id_pelanggan", $this->session->username);
    $this->db->delete("detail_beli_produk");

    // Setelah proses pengiriman, panggil fungsi untuk mengirim notifikasi
    // $this->sendNotifPesanan($data['no_transaksi']);

    $this->session->set_flashdata("message", "swal.fire({title: 'Berhasil',text: 'Pesanan akan diproses Setelah pembayaran berhasil diverifikasi kasir',icon:'success'});");
    redirect("public/home/product_order");
  }

  public function product_order() {
    $this->joins->pdetailjual();
    $this->db->where("id_pelanggan", $this->session->username);
    $this->db->order_by("b.no_transaksi", "desc");
    $list = $this->db->get()->result();
    $data = array(
      "page" => "public/products_order",
      "tabs" => "Semua Pesanan",
      "list" => $list
    );
    $this->load->view("public/index", $data);
  }

  public function tes() {
    $this->load->library('pdf');
    $this->pdf->setPaper('A4', 'potrait');
    $this->pdf->filename = "iniFile.pdf";
    $this->pdf->previewpdf("public/pages");
  }

  public function editprofil() {
    $this->db->select("*");
    $this->db->from("tb_users");
    $this->db->join("pelanggan",'id_pelanggan=username','left');
    $this->db->where('id_pelanggan',$this->session->userdata('username'));
    $user = $this->db->get()->row();
    
    $data = array(
      "page" => "public/edit_profil",
      "tabs" => "Edit Profil",
    );
    $data['detail'] = $user;
    $this->load->view("public/index", $data);
  }

  public function token() {
    $rawData = $this->input->post('datas');
    log_message('debug', 'Raw data received: ' . $rawData);

    $data_produk = json_decode(base64_decode($rawData), true);

    if (!$data_produk) {
        log_message('error', 'Data produk tidak valid.');
        echo json_encode(['error' => 'Data produk tidak valid.']);
        return;
    }

    // Siapkan data transaksi untuk Midtrans
    $transaction_details = [
        'order_id' => uniqid(),
        'gross_amount' => $data_produk['total_bayar']
    ];

    $item_details = [];
    foreach ($data_produk['keranjang'] as $item) {
        $price = $item['harga_jualpro']; // Gunakan harga normal

        $item_details[] = [
            'id' => $item['id_produk'],
            'price' => $price,
            'quantity' => $item['jumlah'],
            'name' => $item['nama_produk']
        ];
    }

    $item_details[] = [
        'id' => 'ongkir',
        'price' => $data_produk['ongkos_kirim']['biaya'],
        'quantity' => 1,
        'name' => 'Ongkos Kirim'
    ];

    $customer_details = [
        'first_name' => $data_produk['almt']['nama_pelanggan'],
        'email' => $data_produk['almt']['email'],
        'phone' => $data_produk['almt']['no_hp']
    ];

    $transaction_data = [
        'transaction_details' => $transaction_details,
        'item_details' => $item_details,
        'customer_details' => $customer_details
    ];

    try {
        $snapToken = \Midtrans\Snap::getSnapToken($transaction_data);
        log_message('debug', 'Snap token generated: ' . $snapToken);
        echo json_encode(['snap_token' => $snapToken]);
    } catch (Exception $e) {
        log_message('error', 'Midtrans error: ' . $e->getMessage());
        echo json_encode(['error' => $e->getMessage()]);
    }
}

  public function finish() {
    // ini data dari ajax finis tadi
      $result = json_decode($this->input->post('result_data'));

      if (!$result) {
          echo json_encode(['status' => 'error', 'message' => 'Data transaksi tidak valid.']);
          return;
      }

      $data = array(
          'id_pembayaran' => uniqid('PAY-'),
          'order_id' => $result->order_id,
          'transaction_id' => $result->transaction_id,
          'payment_type' => $result->payment_type,
          'gross_amount' => $result->gross_amount,
          'transaction_time' => $result->transaction_time,
          'transaction_status' => $result->transaction_status,
          'bank' => $result->va_numbers[0]->bank ?? null, // Jika pembayaran menggunakan bank transfer
          'va_number' => $result->va_numbers[0]->va_number ?? null // Virtual Account Number
      );

      $insert = $this->db->insert('tb_pembayaran', $data);


      if ($insert) {
          echo json_encode(['status' => 'success']);
      } else {
          echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan pembayaran ke database.']);
      }
  }
} 