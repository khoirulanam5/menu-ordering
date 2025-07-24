<script src="<?= base_url('src/js/') ?>hm_sweetalert.min.js"></script>

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
              <?php
              if ($this->input->get("act") == "view") {
                $view = $this->db->get_where("detail_jual", array("no_transaksi" => $this->input->get("no_transaksi")))->result();
                $act = "Update";
              } elseif ($this->input->get("act") == "add") {
                $view = [
                  0 => (object) array(
                    "no_transaksi" => '',
                    "lokasi_tujuan" => '',
                    "jenis" => '',
                    "berat" => '',
                    "total_bayar" => '',
                    "no_resi" => ''
                  )
                ];
                $act = "Simpan";
              }
              if (!empty($view)) {
                $data = json_decode($view[0]->data_produk);
                ?>
                <form action="<?= base_url('/transaksi/pengiriman/update_no_resi'); ?>" method="post">
                  <div class="modal-body">
                    <div class="table_isi">
                      <div class="form-group">
                        <label for="inputEstimatedBudget">No Transaksi</label>
                        <input name="no_transaksi" type="text" value="<?= $view[0]->no_transaksi ?>" readonly
                          class="form-control">
                      </div>
                      <div class="form-group">
                        <label for="inputEstimatedBudget">Jasa Pengiriman</label>
                        <input name="jenis_jasa" type="text" value="<?= strtoupper($data->ongkos_kirim->jenis) ?>" readonly
                          class="form-control">
                      </div>
                      <div class="form-group"><label for="inputEstimatedBudget">No Resi</label>
                        <input name="no_resi" type="text" id="1" value="<?= $view[0]->no_resi ?>" class="form-control">
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <input type="submit" class="btn btn-success" value="<?= $act ?>" style="display: block;">
                    <button class="btn btn-success" onclick="batal()" style="display: block;"> Batal</button>
                  </div>
                </form>
              <?php
              }
              ?>
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
                      <table class="table table-bordered table-striped" id="tables">
                        <thead>
                          <tr>
                            <th style="">No Transaksi</th>
                            <th style="">Lokasi Tujuan</th>
                            <th style="">Jasa Kirim</th>
                            <th style="">Berat</th>
                            <th style="">Total Bayar</th>
                            <th style="">No Resi</th>
                            <th class="text-center">Aksi</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $no = 1;
                          if (!empty($datas)) {
                            foreach ($datas as $key => $value) {
                              $data = json_decode($value->data_produk);
                              ?>
                              <tr id="<?= $value->no_transaksi ?>">
                                <?php
                                echo "<th>" . strtoupper($value->no_transaksi) . "</th>";
                                echo "<th>" . strtoupper($data->ongkos_kirim->lokasi_tujuan) . "</th>";
                                echo "<th>" . strtoupper($data->ongkos_kirim->jenis) . "</th>";
                                echo "<th>" . strtoupper($data->berat) . "</th>";
                                echo "<th>" . strtoupper($data->total_bayar) . "</th>";
                                echo "<th>" . strtoupper($value->no_resi) . "</th>";
                                ?>
                                <td class="text-center">
                                  <button class="btn btn-xs btn-primary" href="" id="<?= $value->no_transaksi ?>"
                                    onclick="action_view('<?= $value->no_transaksi ?>')"><i class="fa fa-eye"></i></button>
                                  <button class="btn btn-xs btn-primary"
                                    onclick="action_delete('<?= $value->no_transaksi ?>')"><i
                                      class="fa fa-trash-alt"></i></button>
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
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>src/dataTables/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>src/dataTables/dataTables.buttons.min.js"></script>
<script src="<?= base_url() ?>src/dataTables/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>src/dataTables/dataTables.responsive.min.js"></script>
<script src="<?= base_url() ?>src/dataTables/responsive.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>src/dataTables/buttons.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>src/dataTables/jszip.min.js"></script>
<script src="<?= base_url() ?>src/dataTables/pdfmake.min.js"></script>
<script src="<?= base_url() ?>src/dataTables/vfs_fonts.js"></script>
<script src="<?= base_url() ?>src/dataTables/buttons.html5.min.js"></script>
<script src="<?= base_url() ?>src/dataTables/buttons.print.min.js"></script>
<script src="<?= base_url() ?>src/dataTables/buttons.colVis.min.js"></script>
<script type="text/javascript">
  var table = $("#tables").DataTable();

  function action_add(id) {
    location.href = "?act=add";
  }

  function batal() {
    $("form").remove();
  }

  const action_view = (id) => {
    var data = table.row("#" + id).data();
    console.log(data);
    location.href = "?act=view&no_transaksi=" + data[0];
  }

  const action_delete = (id) => {
    $.ajax({
      url: "<?= base_url('transaksi/pengiriman/delete/'); ?>" + id,
      success: function (e) {
        if (e == "1") {
          swal({
            title: "Good",
            text: "Hapus data berhasil",
            type: "success"
          }).then(function () {
            window.location.reload();
          })
        }
      }
    })
  }
</script>