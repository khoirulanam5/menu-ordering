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
                <div class="tab-content p-0">
                  <div class="chart tab-pane active" id="revenue-chart" style="position: relative;">
                  <canvas id="maChart" width="800" height="400"></canvas>
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
                                          <th style="">No.</th>
                                          <th style="">ID Prediksi</th>
                                          <th style="">Nama produk</th>
                                          <th style="">Nilai</th>
                                          <th style="">Tanggal</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                    <?php
                                      $no = 1;
                                      if (!empty($datas)) {
                                          foreach ($datas as $key => $value) {
                                      ?>
                                              <tr id="<?= $value->id_ma ?>">
                                                  <?php
                                                  echo "<th>" . $no++ . "</th>";
                                                  echo "<th>" . strtoupper($value->id_ma) . "</th>";
                                                  echo "<th>" . strtoupper($value->nama_produk) . "</th>";
                                                  echo "<th>" . strtoupper($value->nilai) . "</th>";
                                                  echo "<th>" . do_formal_date($value->tanggal) . "</th>";
                                                  ?>
                                              </tr>
                                      <?php
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
  var table = $('#tables').DataTable({order:[[0,'desc']]});
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
                            text: 'Tanggal'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Nilai MA'
                        },
                        beginAtZero: true
                    }
                }
            }
        });
    </script>