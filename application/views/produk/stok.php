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
                      $view = $this->db->get_where("tb_stok",array("id_stok"=>$this->input->get("id_stok")))->result();
                      $act = "Update";
                  }elseif($this->input->get("act")=="add"){
                      $view = [
                          0 => (object)array(
                              "id_stok"=>"",
                              "id_produk" =>"",
                              "jml_stok" => "",
                              "satuan" => ""
                           )
                        ];
                      $act = "Simpan";
                  }
                  if(!empty($view)){
                    ?>
                     <form action="<?= base_url('produk/stok/'); ?><?=$act?>" method="post" enctype="multipart/form-data">
                      <div class="modal-body">
                          <div class="table_isi">
                            <div class="form-group">
                                <label for="inputEstimatedBudget">Nama Produk</label>
                                    <input name="id_stok" type="hidden"  value="<?=$view[0]->id_stok?>" >
                                    <select name="id_produk" id="id_produk" class="form-control">
                                        <option value="">--Pilih--</option>
                                        <?php
                                        $kat = $this->db->get('produk')->result();
                                        foreach ($kat as $key => $value) {
                                            echo '<option value="'.$value->id_produk.'">'.$value->nama_produk.'</option>';
                                        }
                                    ?>
                                </select>
                          </div>
                              <div class="form-group">
                                  <label for="inputEstimatedBudget">Jumlah Stok</label>
                                  <input name="jml_stok" type="text" id="5" value="<?=$view[0]->jml_stok?>" class="form-control">
                              </div>
                              <div class="form-group">
                                <label for="satuan">Satuan</label>
                                <select name="satuan" id="satuan" class="form-control">
                                    <option value="Pcs" <?= $view[0]->satuan == 'Pcs' ? 'selected' : '' ?>>Pcs</option>
                                    <option value="Porsi" <?= $view[0]->satuan == 'Porsi' ? 'selected' : '' ?>>Porsi</option>
                                </select>
                            </div>
                          </div>
                      </div>
                      <div class="modal-footer">
                          <input type="submit" class="btn btn-sm btn-primary" id="update" value="<?=$act?>" style="display: block;">
                          <button class="btn btn-sm btn-primary" onclick="batal()" style="display: block;"> Batal</button>
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
                                          <th style="">No.</th>
                                          <th style="">Nama</th>
                                          <th style="">Jumlah</th>
                                          <th style="">Satuan</th>
                                          <th class="text-center">Aksi</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                    <?php
                                    $no = 1;
                                    if (!empty($datas)) {
                                        foreach ($datas as $key => $value) {
                                        ?>
                                            <tr id="<?= $value->id_stok ?>">
                                                <?php
                                                echo "<th>" . $no++ . "</th>";
                                                echo "<th>" . strtoupper($value->nama_produk) . "</th>";
                                                echo "<th>" . strtoupper($value->jml_stok) . "</th>";
                                                echo "<th>" . strtoupper($value->satuan) . "</th>";
                                                ?>
                                                <td class="text-center">
                                                    <button class="btn btn-xs btn-primary" href="" id="<?= $value->id_stok ?>" onclick="action_view('<?= $value->id_stok ?>')"><i class="fa fa-eye"></i></button>
                                                    <button class="btn btn-xs btn-primary" onclick="action_delete('<?= $value->id_stok ?>')"><i class="fa fa-trash-alt"></i></button>
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
  var table = $('#tables').DataTable({order:[[0,'asc']]});

  function action_add(id) {
      location.href = "?act=add";
  }

  function batal() {
    $("form").remove();
  }

  function action_view (id) {
      var data = table.row("#" + id).data();
      console.log(data);
      location.href = "?act=view&id_stok=" +id;
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
                      url: "<?= base_url('produk/stok/delete/'); ?>" + id,
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