<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php if ($this->session->flashdata('message')): ?>
    <script>
        <?= $this->session->flashdata('message'); ?>
    </script>
        <?php $this->session->unset_userdata('message'); ?>
<?php endif; ?>
<div class="row">
    <div class="col-md-9 col-lg-9">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table product-overview">
                        <thead>
                            <tr>
                                <th>Foto</th>
                                <th>Detail</th>
                                <th style="width: 100px;">Harga/Pcs</th>
                                <th style="width: 100px;">Jumlah </th>
                                <th style="text-align:center">Total Harga</th>
                                <th style="text-align:center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $profil = $this->db->get_where("pelanggan", array("id_pelanggan" => $this->session->username))->row();
                            if(!empty($custom[0]->id_custom)) {
                                foreach($custom as $key => $val) {
                                    $img = file_exists(FCPATH.'images/'.$profil->images) ? 'noimages.jpg' : 'noimages.jpg';
                                    $hargasatuan = $val->harga_satuan*$val->panjang*$val->lebar*$val->tinggi;
                            ?>
                                <tr>
                                    <td width="150"><img src="<?=base_url('images/').$img?>" alt="iMac" width="80"></td>
                                    <td width="450">
                                        <h5 class="font-500"><?="Pesanan Custom"?></h5>
                                        <p><?=$val->keterangan?></p>
                                    </td>
                                    <td width="150"><?=rp($hargasatuan)?></td>
                                    <td width="80">
                                        <input type="text" class="form-control" placeholder="1" value="<?=$val->jumlah?>" readonly>
                                    </td>
                                    <td width="150" align="center" class="font-500"><?=rp($val->jumlah*$hargasatuan)?></td>
                                    <td align="center">
                                        <a href="<?=base_url('public/home/keranjang_del/').$val->id_detail_produk?>?ses=<?=$this->session->username?>" class="text-inverse" title="" data-bs-toggle="tooltip" data-original-title="Delete"><i data-feather="trash-2" class="fill-white feather-sm text-dark"></i></a>
                                    </td>
                                </tr>
                            <?php
                                }
                            }

                            if(!empty($keranjang[0]->id_produk)) {
                                foreach($keranjang as $key => $val) {
                                    $img = file_exists(FCPATH.'images/'.$val->images) ? $val->images : 'noimages.jpg';
                            ?>
                                <tr>
                                    <td width="150"><img src="<?=base_url('images/').$img?>" alt="iMac" width="80"></td>
                                    <td width="450">
                                        <h5 class="font-500"><?=$val->nama_produk?></h5>
                                        <p><?=$val->diskripsi?></p>
                                    </td>
                                    <td width="150"><?=rp($val->harga_jualpro)?></td>
                                    <td width="80">
                                        <input type="number" class="form-control" value="<?=$val->jumlah?>" min="1" onchange="updateHarga(this, <?=$val->harga_jualpro?>, <?=$val->id_detail_produk?>)">
                                    </td>
                                    <td width="150" align="center" class="font-500 harga-total"><?=rp($val->jumlah * $val->harga_jualpro)?></td>
                                    <td align="center">
                                        <a href="<?=base_url('public/home/keranjang_del/').$val->id_detail_produk?>?ses=<?=$this->session->username?>" class="text-inverse" title="" data-bs-toggle="tooltip" data-original-title="Delete"><i data-feather="trash-2" class="fill-white feather-sm text-dark"></i></a>
                                    </td>
                                </tr>
                            <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>

                    <div class="d-flex no-block align-items-center">
                        <a href="<?= base_url('public/home'); ?>" class="btn btn-info btn-outline"><i data-feather="arrow-left" class="fill-white feather-sm"></i> Lanjut Belanja</a>
                        <div class="ms-auto">
                            <a href="<?= base_url('public/home/checkout'); ?>" class="btn btn-info"><i data-feather="shopping-cart" class="fill-white feather-sm"></i> Checkout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Column -->
    <div class="col-md-3 col-lg-3">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Hubungi Kami</h5>
                <hr>
                <center>
                    <h4><i class="ti-mobile"></i> 9998979695 </h4> <small>Silahkan kirimkan pesan kepada kami jika ada pertanyaan.</small>
                </center>
            </div>
        </div>
    </div>
</div>

<script>
function updateHarga(input, hargaSatuan, idProduk) {
    var jumlahBaru = parseInt(input.value);
    var hargaTotalBaru = jumlahBaru * hargaSatuan;
    var hargaTotalElem = $(input).closest('tr').find('.harga-total');

    hargaTotalElem.text('Rp ' + hargaTotalBaru.toLocaleString('id-ID'));

    $.ajax({
        url: '<?=base_url("public/home/update_keranjang")?>',
        type: 'POST',
        data: {
            id_detail_produk: idProduk,
            jumlah: jumlahBaru
        },
        success: function(response) {
            response = JSON.parse(response);
            if (response.status === 'success') {
                updateTotalBayar(); // Panggil fungsi untuk update total bayar
            } else {
                alert(response.message);
            }
        },
        error: function(error) {
            console.error(error);
        }
    });
}

function updateTotalBayar() {
    var totalBayar = 0;

    $('.harga-total').each(function() {
        var harga = parseInt($(this).text().replace(/Rp\s|,/g, ''));
        totalBayar += harga;
    });

    $('#total_bayar').text('Rp ' + totalBayar.toLocaleString('id-ID'));
}
</script>
