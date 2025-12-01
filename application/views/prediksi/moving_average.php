<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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

            <!-- Filter tanggal -->
            <form method="get" action="<?= base_url('prediksi/Moving_average'); ?>" class="form-inline mb-4">
              <label for="tanggal" class="mr-2">Prediksi Pada Tanggal:</label>
              <input type="date" name="tanggal" id="tanggal" class="form-control mr-2"
                value="<?= set_value('tanggal', $this->input->get('tanggal')) ?>">
              <button type="submit" class="btn btn-primary">Cari</button>
            </form>

            <!-- Grafik Moving Average -->
            <div class="mb-4">
              <canvas id="maChart" width="800" height="400"></canvas>
            </div>

            <!-- Tabel data histori -->
            <div>
            <?php if ($is_prediksi): ?>
              <h5>Hasil Prediksi untuk Tanggal: <?= do_formal_date($this->input->get('tanggal')) ?></h5>
              <table class="table table-bordered table-striped" id="tabelPrediksi">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>Nama Menu</th>
                    <th class="text-center">Jumlah</th>
                    <th>Satuan</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no = 1;
                  if (!empty($datas)) {
                    foreach ($datas as $value) {
                      echo "<tr>
                              <td>{$no}</td>
                              <td>" . strtoupper($value->nama_produk) . "</td>
                              <td class='text-center'>" . number_format($value->jumlah_prediksi) . "</td>
                              <td>" . strtoupper($value->satuan) . "</td>
                            </tr>";
                      $no++;
                    }
                  } else {
                    echo "<tr><td colspan='4' class='text-center'>Data prediksi tidak tersedia</td></tr>";
                  }
                  ?>
                </tbody>
              </table>
            <?php else: ?>
              <h5>Data Historis Moving Average</h5>
              <table class="table table-bordered table-striped" id="tables">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>ID Prediksi</th>
                    <th>Nama Produk</th>
                    <th class="text-center">Nilai</th>
                    <th>Satuan</th>
                    <th>Tanggal</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no = 1;
                  if (!empty($datas)) {
                    foreach ($datas as $value) {
                      echo "<tr id='{$value->id_ma}'>
                              <td>{$no}</td>
                              <td>" . strtoupper($value->id_ma) . "</td>
                              <td>" . strtoupper($value->nama_produk) . "</td>
                              <td class='text-center'>" . number_format($value->nilai) . "</td>
                              <td>" . strtoupper($value->satuan) . "</td>
                              <td>" . do_formal_date($value->tanggal) . "</td>
                            </tr>";
                      $no++;
                    }
                  } else {
                    echo "<tr><td colspan='5' class='text-center'>Data tidak tersedia</td></tr>";
                  }
                  ?>
                </tbody>
              </table>
            <?php endif; ?>
            </div>

          </div>
        </div>
      </section>
    </div>
  </div>
</section>

</div>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
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
  var table = $('#tables').DataTable({order:[[0,'asc']]});
</script>

  <script>
        const labels = <?= json_encode(array_map(fn($d) => $d->tanggal, $chart)); ?>;
        const data = <?= json_encode(array_map(fn($d) => $d->nilai, $chart)); ?>;

        const ctx = document.getElementById('maChart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Moving Average',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgb(75, 192, 192)',
                    data: data,
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Periode Tanggal'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Nilai MoVing Average'
                        },
                        beginAtZero: true
                    }
                }
            }
        });
  </script>