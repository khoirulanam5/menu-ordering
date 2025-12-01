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
  <!-- Header -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2 align-items-center">
        <div class="col-md-4 text-left">
          <h1 class="m-0"><?= ucwords(str_replace("_", " ", $menu)) ?></h1>
        </div>
        <div class="col-md-4 text-center">
          <h1 class="m-0"><?= ucwords(str_replace("_", " ", $title)) ?></h1>
        </div>
        <div class="col-md-4 text-right">
          <!-- Breadcrumb (opsional) -->
        </div>
      </div>
    </div>
  </div>

  <!-- Content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <section class="col-lg-12 connectedSortable">
          <div class="card shadow">
            <div class="card-header bg-light">
              <h5 class="mb-0">Cetak Laporan Pemesanan</h5>
            </div>
            <div class="card-body">
              <!-- Form Filter -->
              <form action="<?= base_url('laporan/pemesanan/cetak'); ?>" method="get" class="row g-3 mb-4">
                <div class="col-md-4">
                  <label for="tanggal1">Dari Tanggal:</label>
                  <input type="date" id="tanggal1" name="tanggal1" class="form-control" required>
                </div>
                <div class="col-md-4">
                  <label for="tanggal2">Sampai Tanggal:</label>
                  <input type="date" id="tanggal2" name="tanggal2" class="form-control" required>
                </div>
                <div class="col-md-3">
                  <label for="periode">Periode:</label>
                  <select name="periode" id="periode" class="form-control" required>
                    <option value="">-- Pilih Periode --</option>
                    <option value="harian">Harian</option>
                    <option value="bulanan">Bulanan</option>
                  </select>
                </div>
                <div class="col-md-1 d-flex align-items-end">
                  <input type="submit" class="btn btn-success w-100" value="Cetak">
                </div>
              </form>

              <!-- Flash Message -->
              <?= $this->session->flashdata("message") ?>

              <!-- Tabel Data -->
              <div class="table-responsive">
                <table class="table table-bordered table-striped" id="tables">
                  <thead class="thead-dark">
                    <tr>
                      <th>No.</th>
                      <th>No Transaksi</th>
                      <th>ID Produk</th>
                      <th>Harga</th>
                      <th>Jumlah</th>
                      <th>Total Harga</th>
                      <th>Tanggal</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $no = 1;
                    if (!empty($datas)) {
                      foreach ($datas as $value) {
                    ?>
                      <tr id="<?= $value->no_transaksi ?>">
                        <td><?= $no++ ?></td>
                        <td><?= strtoupper($value->no_transaksi) ?></td>
                        <td><?= strtoupper($value->id_produk) ?></td>
                        <td><?= number_format($value->harga, 0, ',', '.') ?></td>
                        <td><?= $value->jumlah ?></td>
                        <td><?= number_format($value->total_harga, 0, ',', '.') ?></td>
                        <td><?= do_formal_date($value->tanggal) ?></td>
                      </tr>
                    <?php
                      }
                    } else {
                      echo '<tr><td colspan="7" class="text-center">Data tidak ditemukan</td></tr>';
                    }
                    ?>
                  </tbody>
                </table>
              </div>

            </div> <!-- /.card-body -->
          </div> <!-- /.card -->
        </section>
      </div>
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
          order:[[0,'asc']],
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
          url: "<?= base_url('transaksi/pemesanan/delete'); ?>",
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