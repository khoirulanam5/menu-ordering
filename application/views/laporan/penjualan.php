    <style>
        .form-group {
            max-width: 600px;
            margin: 0 auto;
        }

        .form-group label {
            display: inline-block;
            width: 150px;
            margin-bottom: 10px;
        }

        .form-group input, .form-group select {
            width: calc(100% - 160px);
            display: inline-block;
            margin-bottom: 10px;
        }

        .form-group a, .form-group input[type="submit"] {
            margin-top: 10px;
        }

        .form-group hr {
            margin: 10px 0;
        }
    </style>

  <script src="<?=base_url()?>src/js/hm_sweetalert.min.js"></script>

  <div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2 align-items-center">
        <!-- Kolom Kiri (Menu) -->
        <div class="col-md-4 text-left">
          <h1 class="m-0">
            <?= ucwords(str_replace("_", " ", $menu)) ?>
          </h1>
        </div>
        
        <!-- Kolom Tengah (Title) -->
        <div class="col-md-4 text-center">
          <h1 class="m-0">
            <?= ucwords(str_replace("_", " ", $title)) ?>
          </h1>
        </div>
        
        <!-- Kolom Kanan (Kosong atau Breadcrumb) -->
        <div class="col-md-4">
          <!-- Opsional: Breadcrumb atau lainnya -->
        </div>
      </div>
    </div>
  </div>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <section class="col-lg-12 connectedSortable">
            <div class="card">
              <div class="card-body">
            <div class="bg-light ">
            <form action="<?= base_url('laporan/penjualan/periode'); ?>" method="get" class="col-md-4">
              <div class="row">
                  <div class="form-group">
                      <br>
                      <h5>Cetak Penjualan</h5>
                      <hr>
                      <label for="tanggal1">Dari Tanggal: </label>
                      <input type="date" id="tanggal1" name="tanggal1" class="form-control" required>
                      <br>
                      <label for="tanggal2">Sampai Tanggal: </label>
                      <input type="date" id="tanggal2" name="tanggal2" class="form-control" required>
                      <br>
                      <label for="periode">Periode: </label>
                      <select name="periode" id="periode" class="form-control" required>
                          <option value="">-- Pilih Periode --</option>
                          <option value="harian">Harian</option>
                          <option value="bulanan">Bulanan</option>
                      </select>
                      <br>
                      <input type="submit" class="btn btn-sm btn-success" value="Cetak">
                  </div>
              </div>
          </form>
              </div>
               <?php  
                  if($this->input->get("act")=="view"){
                    foreach ($datas as $key => $value) {
                      if($this->input->get('no_transaksi') == $value->no_transaksi){
                        $view = $value;
                      }
                    }
                    $act = "Update";
                  }elseif($this->input->get("act")=="add"){
                      $view = [
                          0 => (object)array(
                              "id_penjualan"=>"",
                              "tgl_jual"=>"",
                              "id_pegawai"=>"",
                              "id_pelanggan"=>"",
                              "total_bayar"=>"",
                              "bayar"=>"",
                              "kembali"=>""
                           )
                        ];
                      $act = "Simpan";
                  }
                  if(!empty($view)){
                    $total = json_decode($view->data_produk);
                    $data_produk = json_decode($view->data_produk);
                    ?>
                      <div class="modal-body">
                          <div class="table_isi row nota">
                                <div class="col-md-12">
                                    <center><h4>Penjualan No Resi : <?=$this->input->get('no_transaksi')?></h4></center>
                                    <div class="garis"></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEstimatedBudget">Id Pelanggan</label>
                                        <div><?=$view->id_pelanggan?></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEstimatedBudget">Total Bayar</label>
                                        <div><?=$total->total_bayar?></div>
                                    </div>
                                    <div class="form-group"><label for="inputEstimatedBudget">Tanggal Jual</label>
                                        <div><?=$view->tgl_jual?></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEstimatedBudget">Status Pengiriman</label>
                                        <div>
                                        <?php
                                            if($value->status_kirim  == 1 ){
                                                echo '<option value="1">Pengiriman Kelokasi</option>';
                                            }elseif ($value->status_kirim  == 2) {
                                                echo '<option value="2">Paket Sudah Diterima</option>';
                                            } else {
                                                echo '<option value="0">Pembayaran Belum diverifikasi</option>';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEstimatedBudget">Nama Penerima</label>
                                        <div><?=$view->nama_penerima?></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="inputEstimatedBudget">Nama Pelanggan</label>
                                            <div><?=$data_produk->almt->nama_pelanggan?></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEstimatedBudget">Alamat</label>
                                            <div><?=$data_produk->almt->desa." ".$data_produk->almt->rt."/".$data_produk->almt->rw." ".$data_produk->almt->kecamatan?></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEstimatedBudget">Pesanan</label>
                                            <div><?php
                                            if(!empty($data_produk->keranjang)){
                                              foreach ($data_produk->keranjang as $key => $value) {
                                                echo '- '.$value->nama_produk."<br>";
                                              }
                                            }
                                            if(!empty($data_produk->custom)){
                                              $total = count($data_produk->custom);
                                              echo "- ".$total." Produk Custom";
                                            }
                                            ?></div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEstimatedBudget">Jenis Pesanan</label>
                                            <div>
                                                <?php
                                                if(!empty($data_produk->custom)){
                                                    foreach($data_produk->custom as $key => $value){
                                                        echo "- P x L x T = ".$value->panjang." x ".$value->lebar." x ".$value->tinggi."<br>";
                                                        echo "- Keterangan : ".$value->keterangan."<br>";
                                                    };
                                                }else{
                                                    foreach($data_produk->keranjang as $key => $value){
                                                        echo "- ".$value->nama_produk."<br>";
                                                    };
                                                }?>
                                            </div>
                                        </div>
                                </div>
                          </div>
                      </div>
                    <?php
                  }
                  ?>
                <div class="tab-content p-0">
                  <div class="chart tab-pane active" id="revenue-chart" style="position: relative;">
                    <div>
                          <?php $action = custom(); echo $this->session->flashdata("message"); ?>
                          <div class="row">
                          </div>
                          <div class="card-body">
                              <table class="table table-bordered table-striped" id="tables">
                                  <thead>
                                      <tr>
                                          <th style="">No Transaksi </th>
                                          <th style="">Total Bayar</th>
                                          <th style="">Status Pengiriman</th>
                                          <th style="">Tgl Jual</th>
                                          <th style="">Nama Penerima</th>
                                          <th class="text-center">Aksi</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      <?php
                                          $no = 1;
                                          if (!empty($datas)) {
                                              
                                              foreach ($datas as $key => $value) {
                                                $total = json_decode($value->data_produk);
                                                if($value->status_kirim == 1){
                                                  $pengiriman = "Proses dikirim";
                                                }elseif($value->status_kirim == 2){
                                                  $pengiriman = "Paket sudah diterima";
                                                }else{
                                                  $pengiriman = "Pembayaran belum diverifikasi";
                                                }
                                              ?>
                                              <tr id="<?= $value->no_transaksi ?>">
                                                  <?php
                                                      echo "<th>" . strtoupper($value->no_transaksi) . "</th>";
                                                      echo "<th>" . strtoupper($total->total_bayar) . "</th>";
                                                      echo "<th>" . strtoupper($pengiriman) . "</th>";
                                                      echo "<th>" . strtoupper(($value->tgl_jual == NULL) ? "-" : date('d-m-Y', strtotime($value->tgl_jual))). "</th>";
                                                      echo "<th>" . strtoupper($value->nama_penerima) . "</th>";
                                                  ?>
                                                  <td class="text-center">
                                                      <button class="btn btn-xs btn-primary"  id="<?= $value->no_transaksi ?>" onclick="action_view('<?= $value->no_transaksi ?>')"><i class="fa fa-eye"></i></button>
                                                  </td>
                                              </tr>
                                              <?php $no++;
                                                  }
                                              } 
                                         ?>
                                  </tbody>
                              </table>
                          </div>
                      </div>      
                  </div>
                  <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;">
                    <div>Donut</div>
                </div>
                </div>
              </div>
            </div>
          </section>
        </div>
    </section>
  </div>
<script src="<?=base_url()?>src/js/jquery.min.js"></script>
<script src="<?= base_url()?>src/dataTables/jquery.dataTables.min.js"></script>
<script src="<?= base_url()?>src/dataTables/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url()?>src/dataTables/dataTables.responsive.min.js"></script>
<script src="<?= base_url()?>src/dataTables/dataTables.buttons.min.js"></script>
<script src="<?= base_url()?>src/dataTables/responsive.bootstrap4.min.js"></script>
<script src="<?= base_url()?>src/dataTables/buttons.bootstrap4.min.js"></script>
<script src="<?= base_url()?>src/dataTables/jszip.min.js"></script>
<script src="<?= base_url()?>src/dataTables/pdfmake.min.js"></script>
<script src="<?= base_url()?>src/dataTables/vfs_fonts.js"></script>
<script src="<?= base_url()?>src/dataTables/buttons.html5.min.js"></script>
<script src="<?= base_url()?>src/dataTables/buttons.print.min.js"></script>
<script src="<?= base_url()?>src/dataTables/buttons.colVis.min.js"></script>
<script type="text/javascript">
  var table = $("#tables").DataTable({
          order:[[0,'desc']],
          responsive: true
      });
      
  function action_add(id) {
      location.href = "?act=add";
  }

  function batal() {
    $("form").remove();
  }

  const action_view = (id) => {
    console.log(id);
      var data = table.row("#" + id).data();
      console.log(data);
      location.href = "?act=view&no_transaksi=" + data[0];
  }

  const action_delete = (id) => {
    console.log(id);
      var row = JSON.stringify(table.row("#" + id).data());
      $.ajax({
          url: "<?= base_url('transaksi/penjualan/delete'); ?>",
          type: "POST",
          data: {
              row
          },
          success: function(e) {
            console.log(e);
              if(e == "1"){
                  swal({
                  title: "Good",
                  text: "Hapus data berhasil",
                  type: "success"
                  }).then(function() {
                      window.location.reload();
                  });
              }
          }
      })
  }
</script>
<style>
    .garis{
        border: solid 1px;
        margin-bottom: 10px;
    }
    .card-body{
        background: #ddd;
    }
    .nota{
        padding: 20px;
        background: #fff;
    }
</style>