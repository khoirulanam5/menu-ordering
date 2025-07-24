<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex no-block align-items-center">
                    <div class="ms-auto">    
                        <a href="<?= base_url('public/home'); ?>" class="btn btn-info btn-autline" ><i data-feather="arrow-left" class="fill-white feather-sm"></i>Back</a>
                    </div>
                </div>
                <hr>
                <?php if ($this->session->flashdata('message')): ?>
                    <script>
                        <?= $this->session->flashdata('message'); ?>
                    </script>
                        <?php $this->session->unset_userdata('message'); ?>
                    <?php endif; ?>
                <div class="row">
                        <h3 class="card-title"><?=ucwords($datas->nama_produk)?></h3>
                        <h6 class="card-subtitle"><?=$datas->jenis_pro?></h6>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-6">
                        <div class="white-box text-center"> <img src="<?=base_url("images/") . $datas->images?>" class="img-fluid"> </div>
                    </div>
                    <div class="col-lg-9 col-md-9 col-sm-6">
                        <?php if (empty($this->session->username)) { ?>
                            <a class="btn btn-primary btn-rounded ms-2" href="#" data-bs-toggle="modal" data-bs-target="#bs-example-modal-md">Daftar</a>
                            <?php } ?>
                            <div class="modal fade" id="bs-example-modal-md" tabindex="-1" aria-labelledby="bs-example-modal-md" aria-hidden="true">
                                <div class="modal-dialog modal-md">
                                    <div class="modal-content">
                                        <div class="modal-header d-flex align-items-center bg-info">
                                            <h4 class="modal-title text-center w-100 text-white" id="myLargeModalLabel">Daftar Akun</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <?php $this->load->view("public/pendaftaran_v"); ?>
                                        </div>
                                        <div class="modal-footer"></div>
                                    </div>
                                </div>
                            </div>
                        <h4 class="box-title mt-5">Diskripsi Barang</h4>
                        <p><?=$datas->diskripsi?></p>
                        <h2 class="mt-5"><?=rp($datas->harga_jualpro) ?></h2>
                        <form action="<?= base_url('public/home/keranjang/'); ?>" method="post">
                            <div class="d-flex align-items-center">
                                <ul class="list-group list-group-horizontal mb-0">
                                    <li class="itm list-group-item">
                                        <a class="btn btn-info btn-rounded me-1" href="<?= base_url('public/home/cart'); ?>" data-bs-toggle="tooltip" title="" data-original-title="Add to cart">
                                            <i data-feather="shopping-cart" class="fill-white feather-sm"></i>
                                        </a>
                                    </li>
                                    <li class="itm list-group-item my-auto">
                                        <input type="hidden" name="id_produk" id="id_produk" value="<?=$datas->id_produk?>">
                                        <input type="hidden" name="id_pel" id="id_pel" value="<?=$this->session->username?>">
                                        <input type="hidden" name="jml_stok" id="jml_stok" value="<?=$datas->jml_stok?>" style="width:60px" readonly="readonly">
                                        <input type="number" name="jumlah_order" id="jumlah_order" style="width:60px" placeholder="0" required="required" onchange="stock()">
                                    </li>
                                    <li class="itm list-group-item">
                                        <input type="submit" class="btn btn-info btn-rounded" value="Masukkan Keranjang">
                                    </li>
                                </ul>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    ul li.itm{
        border: none;
    }
</style>
<script src="<?=base_url()?>src/js/hm_sweetalert.min.js"></script>
<script src="<?=base_url()?>src/js/jquery.min.js"></script>
<script>
    function stock() {
        var stok = <?=$datas->jml_stok?>,
        order = parseInt($("#jumlah_order").val());
        console.log("order "+order)
        stok = stok-order;
        if(stok >= 0 && order < 0 ){
            $("#jumlah_order").val(0);
            swal({title:'Gagal',text:'Tidak Boleh Kurang dari Nol',type:'error'});
        }else if(stok >= 0 && order <= <?=$datas->jml_stok?> ){
            $("#jml_stok").val(stok);
        }else{
            if(order <= stok){
                if(order < 0){
                    $("#jumlah_order").val(0);
                    swal({title:'Gagal',text:'Tidak Boleh Kurang dari Nol',type:'error'});
                }else{
                    $("#jumlah_order").val(order);
                }
               
            }else{
                $("#jumlah_order").val(<?=$datas->jml_stok?>);
                swal({title:'Gagal',text:'Stok Habis',type:'error'});
            }
        }
    }
</script>
