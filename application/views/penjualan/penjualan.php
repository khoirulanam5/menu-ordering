<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
  .ttl_jual {
    margin:25px;
  }
</style>

  <<div class="content-wrapper">
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
              <div class="card-header">
                <div class="row col-md-12">
                  <h3 class="card-title">
                    <i class="fas fa-chart-pie mr-1"></i>
                    Total Penjualan : <?=$total['penjualan']?>
                  </h3>
                </div>
                <div class="row ttl_jual">
                  <div class="form-check form-check-inline btn btn-success">
                    <input class="form-check-input" type="radio" name="ops_penjualan" id="inlineRadio1" value="selesai" <?=($this->input->get('ops')=='selesai') ? 'checked':'';?> >
                    <label class="form-check-label" for="inlineRadio1">Transaksi Selesai : <?=$total['selesai']?></label>
                  </div>
                  <div class="form-check form-check-inline btn btn-warning">
                    <input class="form-check-input" type="radio" name="ops_penjualan" id="inlineRadio2" value="proses" <?=($this->input->get('ops')=='proses') ? 'checked':'';?>>
                    <label class="form-check-label" for="inlineRadio2">Proses pengiriman : <?=$total['proses']?></label>
                  </div>
                  <div class="form-check form-check-inline btn btn-danger">
                    <input class="form-check-input" type="radio" name="ops_penjualan" id="inlineRadio3" value="verifikasi" <?=($this->input->get('ops')=='verifikasi') ? 'checked':'';?>>
                    <label class="form-check-label" for="inlineRadio3">Pembayaran belum diverifikasi : <?=$total['belum_verifikasi']?></label>
                  </div>
                </div>
              </div>
              <div class="card-body">
               <a class="btn btn-xs btn-info" href="<?= base_url('transaksi/penjualan/detail_pejualan'); ?>"><i class="fa fa-eye"></i> Detail Penjualan</a>
                <div class="tab-content p-0">
                  <div class="chart tab-pane active" id="revenue-chart" style="position: relative;">
                    <div>
                        <?php if ($this->session->flashdata('message')): ?>
                          <script>
                            <?= $this->session->flashdata('message'); ?>
                          </script>
                            <?php $this->session->unset_userdata('message'); ?>
                        <?php endif; ?>
                          <div class="row">
                        </div>
                          <div class="card-body">
                            <?php
                            if (!empty($this->input->get('ops'))) {
                              $this->load->view('template/getdatatable');
                            }else {
                            ?>
                              <table class="table table-bordered table-striped" id="tables">
                                  <thead>
                                      <tr>
                                          <th style="">No Resi </th>
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
                                                if ($value->status_kirim == 1){
                                                    $pengiriman = "Proses dikirim";
                                                } elseif ($value->status_kirim == 2){
                                                    $pengiriman = "Paket sudah diterima";
                                                } else {
                                                    $pengiriman = "Pembayaran belum diverifikasi";
                                                }
                                                ?>
                                                <tr id="<?= $value->no_transaksi ?>">
                                                    <?php
                                                        echo "<th>" . strtoupper($value->no_transaksi) . "</th>";
                                                        echo "<th>" . strtoupper($total->total_bayar) . "</th>";
                                                        echo "<th>" . strtoupper($pengiriman) . "</th>";
                                                        echo "<th>" . strtoupper(($value->tgl_jual == NULL) ? "-" : date('d-m-Y', strtotime($value->tgl_jual))) . "</th>"; // Ubah format tanggal
                                                        echo "<th>" . strtoupper($value->nama_penerima) . "</th>";
                                                    ?>
                                                    <td class="text-center">
                                                        <!-- <button class="btn btn-xs btn-primary" id="<?= $value->no_transaksi ?>" onclick="action_view('<?= $value->no_transaksi ?>')"><i class="fa fa-eye"></i></button> -->
                                                        <a href="<?php echo site_url('transaksi/penjualan/cetak_nota/' . $value->no_transaksi); ?>" class="btn btn-xs btn-primary" target="_blank"><i class="fa fa-print"></i></a>
                                                        <button class="btn btn-xs btn-primary" onclick="action_delete('<?= $value->no_transaksi ?>')"><i class="fa fa-trash-alt"></i></button>
                                                    </td>
                                                </tr>
                                                <?php $no++;
                                            }
                                        } 
                                    ?>
                                </tbody>
                              </table>
                            <?php
                            }
                            ?>
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
<script src="<?= base_url()?>src/dataTables/dataTables.buttons.min.js"></script>
<script src="<?= base_url()?>src/dataTables/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url()?>src/dataTables/dataTables.responsive.min.js"></script>
<script src="<?= base_url()?>src/dataTables/responsive.bootstrap4.min.js"></script>
<script src="<?= base_url()?>src/dataTables/buttons.bootstrap4.min.js"></script>
<script src="<?= base_url()?>src/dataTables/jszip.min.js"></script>
<script src="<?= base_url()?>src/dataTables/pdfmake.min.js"></script>
<script src="<?= base_url()?>src/dataTables/vfs_fonts.js"></script>
<script src="<?= base_url()?>src/dataTables/buttons.html5.min.js"></script>
<script src="<?= base_url()?>src/dataTables/buttons.print.min.js"></script>
<script src="<?= base_url()?>src/dataTables/buttons.colVis.min.js"></script>
<script type="text/javascript">
  var table = $("#tables").DataTable({order:[[0,'desc']]});

  function action_add(id) {
      location.href = "?act=add";
  }

  function batal() {
    $("form").remove();
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

  $('input[name="ops_penjualan"]').on('click',function(){
    var ops = $('input[name="ops_penjualan"]:checked').val();
    location.href = '?ops='+ops;
    console.log(ops);
  })
</script>
