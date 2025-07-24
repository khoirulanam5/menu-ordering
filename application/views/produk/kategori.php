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
               <button class="btn btn-xs btn-primary"  onclick="action_add()"><i class="fa fa-plus"></i> Tambah</button>
               <?php  
                  if($this->input->get("act")=="view"){
                      $view = $this->db->get_where("tb_kategori",array("id_kategori"=>$this->input->get("id_kategori")))->result();
                      $act = "Update";
                  }elseif($this->input->get("act")=="add"){
                      $view = [
                          0 => (object)array(
                              "id_kategori"=>"",
                              "jenis"=>"",
                              "keterangan"=>"",
                           )
                        ];
                    $act = "Simpan";
                  }
                  if(!empty($view)){
                    ?>

                     <form action="<?= base_url('produk/kategori/'); ?><?=$act?>" method="post">
                      <div class="modal-body">
                          <div class="table_isi">
                              <div class="form-group">
                                <label for="inputEstimatedBudget">Kode</label>
                                  <input name="id_kategori" type="hidden"  value="<?=$view[0]->id_kategori?>" >
                              </div>
                              <div class="form-group">
                                <label for="inputEstimatedBudget">Nama</label>
                                  <input name="jenis" type="text" id="1" value="<?=$view[0]->jenis?>" class="form-control">
                              </div>
                              <div class="form-group">
                                  <label for="inputEstimatedBudget">Keterangan</label>
                                  <input name="keterangan" type="text" id="2" value="<?=$view[0]->keterangan?>" class="form-control">
                              </div>
                          </div>
                      </div>
                      <div class="modal-footer">
                          <input type="submit" class="btn btn-sm btn-primary" value="<?=$act?>" style="display: block;">
                          <button class="btn btn-sm btn-primary" onclick="batal()" style="display: block;" > Batal</button>
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
                                          <th>No.</th>
                                          <th>Nama</th>
                                          <th>Keterangan</th>
                                          <th class="text-center">Aksi</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      <?php
                                          $no = 1;
                                          if (!empty($datas)) {
                                              foreach ($datas as $key => $value) {
                                      ?>
                                      <tr id="<?= $value->id_kategori ?>">
                                          <td><?= $no++ ?></td>
                                          <td><?= strtoupper($value->jenis) ?></td>
                                          <td><?= strtoupper($value->keterangan) ?></td>
                                          <td class="text-center">
                                              <button class="btn btn-xs btn-primary" id="<?= $value->id_kategori ?>" onclick="action_view('<?= $value->id_kategori ?>')">
                                                  <i class="fa fa-eye"></i>
                                              </button>
                                              <button class="btn btn-xs btn-primary" onclick="action_delete('<?= $value->id_kategori ?>')">
                                                  <i class="fa fa-trash-alt"></i>
                                              </button>
                                          </td>
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
  var table = $("#tables").DataTable();

  function action_add(id) {
      location.href = "?act=add";
  }

  function batal() {
    $("form").remove();
  }

  function action_view (id) {
      var data = table.row("#" + id).data();
      location.href = "?act=view&id_kategori=" +id;
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
                  $.ajax({
                      url: "<?= base_url('produk/kategori/delete/'); ?>" + id,
                      type: "POST",
                      success: function(response) {
                          Swal.fire({
                              title: "Berhasil",
                              text: "Hapus data berhasil",
                              icon: "success"
                          }).then(function () {
                              window.location.reload();
                          });
                      }
                  });
              }
          });
      };
</script>
	
