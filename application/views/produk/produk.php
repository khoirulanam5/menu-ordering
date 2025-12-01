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
                      $view = $this->db->get_where("produk",array("id_produk"=>$this->input->get("id_produk")))->result();
                      $act = "Update";
                  }elseif($this->input->get("act")=="add"){
                      $view = [
                          0 => (object)array(
                              "id_produk"=>"",
                              "nama_produk" =>"",
                              "jenis_pro" =>"",
                              "harga_jualpro" =>"",
                              "diskripsi" =>"",
                              "images" =>""
                           )
                        ];
                      $act = "Simpan";
                  }
                  if(!empty($view)){
                    ?>

                     <form action="<?= base_url('produk/produk/'); ?><?=$act?>" method="post" enctype="multipart/form-data">
                      <div class="modal-body">
                          <div class="table_isi">
                            <div class="form-group"><label for="inputEstimatedBudget">Nama Produk</label>
                            <input name="id_produk" type="hidden"  value="<?=$view[0]->id_produk?>" >
                            <input name="nama_produk" type="text" id="0" value="<?=$view[0]->nama_produk?>"
                            class="form-control">
                          </div>
                              <?php
                              if(!empty($view[0]->images)){
                                $imgcek = file_exists(FCPATH.'images/'.$view[0]->images) ? $view[0]->images : 'noimages.jpg';
                                ?>
                                <img src="<?=base_url("images/").$imgcek?>"  width="100px" alt="">
                                <input name="images" type="hidden" id="0" value="<?=$view[0]->images?>" >
                                <?php
                              }
                              ?>
                              <div class="form-group"><label for="inputEstimatedBudget">Images</label>
                                  <input name="images" type="file" id="0" class="form-control" accept="image/*">
                              </div>
                              <div class="form-group">
                                  <label for="inputEstimatedBudget">Kategori</label>
                                  <select name="jenis_pro" id="jenis_pro" class="form-control">
                                      <option value="">--Pilih--</option>
                                      <?php
                                      $kat = $this->db->get('tb_kategori')->result();
                                      foreach ($kat as $key => $value) {
                                          echo '<option value="'.$value->jenis.'">'.$value->jenis.'</option>';
                                      }
                                      ?>
                                  </select>
                                </div>
                              <div class="form-group">
                                  <label for="inputEstimatedBudget">Diskripsi Produk</label>
                                  <textarea name="diskripsi" type="text" id="1" rowspan="3" class="form-control"><?=$view[0]->diskripsi?></textarea>
                              </div>
                              <div class="form-group">
                                  <label for="inputEstimatedBudget">Harga</label>
                                  <input name="harga_jualpro" type="text" id="4" value="<?=$view[0]->harga_jualpro?>"
                                      class="form-control">
                              </div>
                          </div>
                      </div>
                      <div class="modal-footer">
                          <input type="submit" class="btn btn-sm btn-primary" id="update" value="<?=$act?>" style="display: block;">
                          <button class="btn btn-sm btn-primary" onclick="batal()" style="display: block;" > Batal</button>
                      </div>
                  </form>
                    <?php
                  }
                  ?>
                <div class="tab-content p-0">
                  <div class="chart tab-pane active" id="revenue-chart" style="position: relative;">
                    <?php if ($this->session->flashdata('message')): ?>
                      <script>
                        <?= $this->session->flashdata('message'); ?>
                      </script>
                        <?php $this->session->unset_userdata('message'); ?>
                    <?php endif; ?>
                        <div class="row">
                          <div class="card-body">
                              <table class="table table-bordered table-striped" id="tables">
                                  <thead>
                                      <tr>
                                          <th>No.</th>
                                          <th>Nama</th>
                                          <th>Jenis</th>
                                          <th>Harga</th>
                                          <th class="text-center">Aksi</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                    <?php
                                    $no = 1;
                                    if (!empty($datas)) {
                                      foreach ($datas as $key => $value) {
                                    ?>
                                      <tr id="<?= $value->id_produk ?>">
                                        <td><?= $no++ ?></td>
                                        <td><?= strtoupper($value->nama_produk) ?></td>
                                        <td><?= strtoupper($value->jenis) ?></td> <!-- dari join tb_kategori -->
                                        <td>Rp <?= number_format($value->harga_jualpro, 0, ',', '.') ?></td>
                                        <td class="text-center">
                                          <button class="btn btn-xs btn-primary" id="<?= $value->id_produk ?>" onclick="action_view('<?= $value->id_produk ?>')">
                                            <i class="fa fa-eye"></i>
                                          </button>
                                          <button class="btn btn-xs btn-primary" onclick="action_delete('<?= $value->id_produk ?>')">
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
      location.href = "?act=view&id_produk=" +id;
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
                      url: "<?= base_url('produk/produk/delete/'); ?>" + id,
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