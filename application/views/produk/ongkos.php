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
              <button class="btn btn-xs btn-primary" onclick="action_add()">
                <i class="fa fa-plus"></i> Tambah
              </button>

              <?php  
              if ($this->input->get("act") == "view") {
                $view = $this->db->get_where("ongkos_kirim", ["id_ongkos" => $this->input->get("id_ongkos")])->result();
                $act = "Update";
              } elseif ($this->input->get("act") == "add") {
                $view = [
                  0 => (object)[
                    "id_ongkos" => "",
                    "lokasi_tujuan" => "",
                    "jarak" => "",
                    "jenis" => "JASA TOKO",
                    "biaya" => "",
                  ]
                ];
                $act = "Simpan";
              }

              if (!empty($view)) { 
              ?>
              
              <form class="form-ongkir" action="<?= base_url('transaksi/ongkir_toko/'); ?><?=$act?>" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                  <div class="table_isi">
                    <?php if (empty($view[0]->id_ongkos)) { ?>
                      <div class="form-group">
                        <label for="id_ongkos">Id Lokasi</label>
                        <input name="id_ongkos" type="text" class="form-control">
                      </div>
                    <?php } else { ?>
                      <input name="id_ongkos" type="hidden" value="<?=$view[0]->id_ongkos?>">
                    <?php } ?>
                    
                    <div class="form-group">
                      <label for="lokasi_tujuan">Lokasi Tujuan</label>
                      <input name="lokasi_tujuan" type="text" value="<?=$view[0]->lokasi_tujuan?>" class="form-control">
                    </div>

                    <div class="form-group">
                      <label for="jenis">Jenis</label>
                      <input name="jenis" type="text" value="<?=$view[0]->jenis?>" class="form-control">
                    </div>

                    <div class="form-group">
                      <label for="biaya">Biaya</label>
                      <input name="biaya" type="number" min="1" value="<?=$view[0]->biaya?>" class="form-control">
                    </div>
                  </div>
                </div>

                <div class="modal-footer">
                  <button type="submit" class="btn btn-sm btn-primary" id="update"><?=$act?></button>
                  <button type="button" class="btn btn-sm btn-secondary" onclick="batal(event)">Batal</button>
                </div>
              </form>

              <?php } ?>

              <div class="tab-content p-0">
                <div class="chart tab-pane active" id="revenue-chart" style="position: relative;">
                <?php if ($this->session->flashdata('message')): ?>
                        <script>
                            <?= $this->session->flashdata('message'); ?>
                        </script>
                          <?php $this->session->unset_userdata('message'); ?>
                      <?php endif; ?>
                  <div class="card-body">
                    <table class="table table-bordered table-striped" id="tables">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Lokasi Tujuan</th>
                          <th>Jenis</th>
                          <th>Biaya</th>
                          <th class="text-center">Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $no = 1;
                        if (!empty($datas)) {
                          foreach ($datas as $key => $value) {
                            if ($value->id_ongkos != 6) { 
                        ?>
                        <tr id="<?= $value->id_ongkos ?>">
                          <th><?= strtoupper($value->id_ongkos) ?></th>
                          <th><?= strtoupper($value->lokasi_tujuan) ?></th>
                          <th><?= strtoupper($value->jenis) ?></th>
                          <th><?= strtoupper($value->biaya) ?></th>
                          <td class="text-center">
                            <button class="btn btn-xs btn-primary" onclick="action_view('<?= $value->id_ongkos ?>')"><i class="fa fa-eye"></i></button>
                            <button class="btn btn-xs btn-danger" onclick="action_delete('<?= $value->id_ongkos ?>')"><i class="fa fa-trash-alt"></i></button>
                          </td>
                        </tr>
                        <?php $no++; }}} ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </section>
        </div>
      </div>
    </div>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url()?>src/dataTables/jquery.dataTables.min.js"></script>
<script src="<?= base_url()?>src/dataTables/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url()?>src/dataTables/dataTables.responsive.min.js"></script>
<script src="<?= base_url()?>src/dataTables/responsive.bootstrap4.min.js"></script>

<script type="text/javascript">
  var table = $('#tables').DataTable();

  function action_add() {
    location.href = "?act=add";
  }

  function batal(event) {
    event.preventDefault();  // Prevent form submission
    $('.form-ongkir').remove();  // Remove form-ongkir element
  }

  function action_view(id) {
    var data = table.row("#" + id).data();
    location.href = "?act=view&id_ongkos=" + data[0];
  }

  function action_delete(id) {
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
        $.ajax({
          url: "<?= base_url('transaksi/ongkir_toko/delete/'); ?>" + id,
          type: "POST",
          success: function(response) {
            Swal.fire("Berhasil", "Hapus data berhasil", "success")
              .then(() => {
                window.location.reload();  // Reload page after successful deletion
              });
          },
          error: function(xhr, status, error) {
            Swal.fire("Gagal", "Terjadi kesalahan saat menghapus data", "error");
          }
        });
      }
    });
  }
</script>
