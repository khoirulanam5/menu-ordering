<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
               <a class="btn btn-xs btn-info" href="<?= base_url('transaksi/penjualan'); ?>"><i class="fa fa-eye"></i> Penjualan</a>
               <?php  
                  if ($this->input->get("act")=="view"){
                      foreach ($datas as $key => $value) {
                        if ($this->input->get('no_transaksi') == $value->no_transaksi){
                          $view = $value;
                        }
                      }
                    $act = "Update";
                  }elseif ($this->input->get("act")=="add") {
                      $view = [
                          0 => (object)array(
                              "no_transaksi"=>"",
                              "nama_pelanggan"=>"",
                              "status_bayar"=>"",
                              "status_kirim"=>"",
                              "kabupaten"=>"",
                              "nama_penerima"=>""
                           )
                        ];
                    $act = "Simpan";
                  }
                  if (!empty($view)){
                    $ttl_bayar = json_decode($view->data_produk);
                    //  $img = file_exists(FCPATH.'uploads/'. $view->bukti_tf) ?  'uploads/'.$view->bukti_tf : 'images/noimages.jpg';
                    ?>

                     <form action="<?= base_url('transaksi/penjualan/detail_penjualan_') . $act?>" method="post">
                      <div class="modal-body row" >
                        <div class="col-md-12">
                          <div class="table_isi">
                              <div class="form-group">
                                  <label for="inputEstimatedBudget">Nama Pelanggan</label>
                                  <input name="no_transaksi" type="hidden"  value="<?=$view->no_transaksi?>" >
                                  <input name="id_pegawai" type="hidden" id="id_pegawai" value="<?=$this->session->username?>" class="form-control">
                                  <input name="id_pelanggan" type="hidden" id="id_pelanggan" value="<?=$view->id_pelanggan?>" class="form-control">
                                  <input name="data_produk" type="hidden" id="data_produk" value='<?=$view->data_produk?>' class="form-control">
                                  <input name="nama_pelanggan" type="text" id="nama_pelanggan" value="<?=$view->nama_pelanggan?>" class="form-control">
                              </div>
                              <div class="form-group">
                                  <label for="inputEstimatedBudget">Status Bayar</label>
                                  <select name="status_bayar" id="" class="form-control">
                                  <?php
                                    if($view->status_bayar == 1){
                                      echo '<option value="1">Lunas | Siap Dikirim</option>';
                                    }else{
                                      echo '<option value="0">Belum bayar</option>';
                                    }
                                    echo '<option value="0">Belum bayar</option>';
                                    echo '<option value="1">Lunas | Siap Dikirim</option>';
                                    ?>
                                  </select>
                              </div>
                              <div class="form-group">
                                  <label for="inputEstimatedBudget">Total Bayar</label>
                                  <input name="total_bayar" type="text" id="total_bayar" value="<?=rp($ttl_bayar->total_bayar)?>" class="form-control" readonly="readonly">
                              </div>
                          </div>
                        </div>
                        <!-- <div class="col-md-4">
                        <div class="form-group">
                            <label for="inputEstimatedBudget">Bukti Bayar / Transfer</label><br>
                            <image src="<?=base_url().$img?>" width="180px" height="230px"/>
                        </div>
                      </div> -->
                      </div>
                      <div class="modal-footer">
                          <input type="submit" class="btn btn-sm btn-primary" id="update" value="<?=$act?>" style="display: block;">
                          <button class="btn btn-sm btn-primary" onclick="batal()" style="display: block;" > Batal</button>
                      </div>
                  </form>
                    <?php
                  }
                ?>

                <div class="tab-content">
                  <div class="chart tab-pane active" id="revenue-chart" style="position: relative;">
                    <?php if ($this->session->flashdata('message')): ?>
                        <script>
                            <?= $this->session->flashdata('message'); ?>
                        </script>
                        <?php $this->session->unset_userdata('message'); ?>
                    <?php endif; ?>
                        <div class="row">
                          <div class="card-body">
                              <table class="table table-bordered table-striped" id="tables" style="font-size: small;">
                                  <thead>
                                      <tr>
                                          <th style="">No resi </th>
                                          <th style="">Nama Pelanggan</th>
                                          <th style="">Status bayar</th>
                                          <th style="">Status Pengiriman</th>
                                          <th style="">Kota Tujuan</th>
                                          <th class="text-center">Aksi</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      <?php
                                          $no = 1;
                                          if (!empty($datas)) {
                                              foreach ($datas as $key => $value) {
                                                if ($value->status_kirim  == 1 ){
                                                  $pengiriman = "<span class='badge badge-primary btn-xs'>Proses Dikirim</span>";
                                                } elseif ($value->status_kirim  == 2) {
                                                  $pengiriman = "<span class='badge badge-success btn-xs'>Selesai Dikirim</span>";
                                                } else {
                                                  $pengiriman = "<span class='badge badge-warning btn-xs'>Pembayaran Belum diverifikasi</span>";
                                                }
                                              ?>
                                              <tr id="<?= $value->no_transaksi ?>">
                                                  <?php
                                                      echo "<th>" . strtoupper($value->no_transaksi) . "</th>";
                                                      echo "<th>" . strtoupper($value->nama_pelanggan) . "</th>";
                                                      echo "<th>" . ($value->status_bayar == 0 ? "<span class='badge badge-warning btn-xs'>Belum Lunas</span>":"<span class='badge badge-success btn-xs'>Lunas") . "</th>";
                                                      echo "<th>" .$pengiriman. "</th>";
                                                      echo "<th>" . strtoupper($value->kabupaten) . "</th>";
                                                  ?>
                                                  <td style="">
                                                      <?php
                                                      if(empty($value->status_kirim)){
                                                        ?>
                                                        <button class="btn btn-xs btn-info"  id="<?= $value->no_transaksi ?>" onclick="action_view('<?= $value->no_transaksi ?>')"><i class="fa fa-edit"></i></button>
                                                        <button class="btn btn-xs btn-danger" onclick="action_delete('<?= $value->no_transaksi ?>')"><i class="fa fa-trash-alt"></i></button>
                                                        <?php
                                                      }
                                                      ?>
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
<script src="<?=base_url()?>src/dataTables/jquery.dataTables.min.js"></script>
<script src="<?=base_url()?>src/dataTables/dataTables.buttons.min.js"></script>
<script src="<?=base_url()?>src/dataTables/dataTables.bootstrap4.min.js"></script>
<script src="<?=base_url()?>src/dataTables/dataTables.responsive.min.js"></script>
<script src="<?=base_url()?>src/dataTables/responsive.bootstrap4.min.js"></script>
<script src="<?=base_url()?>src/dataTables/buttons.bootstrap4.min.js"></script>
<script src="<?=base_url()?>src/dataTables/jszip.min.js"></script>
<script src="<?=base_url()?>src/dataTables/pdfmake.min.js"></script>
<script src="<?=base_url()?>src/dataTables/vfs_fonts.js"></script>
<script src="<?=base_url()?>src/dataTables/buttons.html5.min.js"></script>
<script src="<?=base_url()?>src/dataTables/buttons.print.min.js"></script>
<script src="<?=base_url()?>src/dataTables/buttons.colVis.min.js"></script>
<script type="text/javascript">
  var table = $("#tables").DataTable({order:[[0,'desc']]});

  function action_add(id) {
      location.href = "?act=add";
  }

  function batal() {
    $("form").remove();
    window.location='?';
  }

  const action_view = (id) => {
      var data = table.row("#" + id).data();
      location.href = "?act=view&no_transaksi=" + data[0];
  }

  const action_delete = (id) => {
      Swal.fire({
          title: "Apa kamu yakin?",
          text: "Data yang dihapus tidak dapat dipulihkan!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Delete"
      }).then((result) => {
          if (result.isConfirmed) {
              var row = JSON.stringify(table.row("#" + id).data());
              $.ajax({
                  url: "<?= base_url('transaksi/penjualan/delete'); ?>",
                  type: "POST",
                  data: { row: row },  // Kirim data row dalam bentuk JSON
                  success: function(e) {
                      if(e == "1") {
                          Swal.fire({
                              title: "Berhasil",
                              text: "Hapus data berhasil",
                              icon: "success"
                          }).then(function () {
                              window.location.reload();
                          });
                      }
                  }
              });
          }
      });
  }
</script>
	
