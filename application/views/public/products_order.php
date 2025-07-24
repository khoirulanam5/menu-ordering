<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php if ($this->session->flashdata('message')): ?>
    <script>
        <?= $this->session->flashdata('message'); ?>
    </script>
        <?php $this->session->unset_userdata('message'); ?>
<?php endif; ?>
<div class="row">
    <!-- Column -->
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table product-overview" id="zero_config">
                        <thead>
                            <tr>
                                <th>No Transaksi</th>
                                <th>Pesanan</th>
                                <th>Total Bayar</th>
                                <th>Status</th>
                                <th>
                                    <center>Pengiriman</center>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($list as $key => $value) {
                                ?>
                                <tr>
                                    <td><?= $value->no_transaksi ?></td>
                                    <td>
                                        <ul>
                                            <?php
                                            $isi = json_decode($value->data_produk);
                                            foreach ($isi->keranjang as $key2 => $val) {
                                                echo "<li>" . $val->nama_produk . ", " . $val->jumlah . "pcs ( " . rp($val->harga_jualpro) . " )</li>";
                                            }
                                            ?>
                                        </ul>
                                    </td>
                                    <td><?= rp($isi->total_bayar) ?></td>
                                    <td>
                                        <?php
                                        if ($value->status_bayar == 1) {
                                            echo '<span class="badge bg-success font-weight-100">Lunas</span>';
                                        } else {
                                            echo '<span class="badge bg-warning font-weight-100">Menunggu Verifikasi</span>';
                                        }
                                        ?>
                                    </td>
                                    <td style="text-align:center">
                                        <?php
                                        if ($value->status_kirim == 1) {
                                            echo '<center><h4>sedang dikirim ke tempat tujuan</h4></center> 
                                            <span> Klik pesanan diterima</span>
                                            <button class="btn btn-xs btn-success" onclick="barang_diterima(\'' . $value->no_transaksi . '\')"> Diterima</button>';
                                        } elseif ($value->status_kirim == 2) {
                                            echo "<span class='badge bg-success'>Selesai Dikirim</span>";
                                        } else {
                                            echo "<center><span class='badge bg-warning'>Pembayaran Belum diverifikasi</span></center>";
                                        }
                                        ?>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Column -->
</div>
<!-- Modal -->
<?php
foreach ($list as $k => $val) {
    ?>
    <div class="modal fade" id="exampleModal<?= $val->no_transaksi ?>" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Pengiriman</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php
                    if ($val->status_kirim == 1) {
                        echo $pengiriman = "<center><h4>sedang dikirim ke tempat tujuan</h4></center>";
                    } elseif ($val->status_kirim == 2) {
                        echo $pengiriman = "<span class='btn btn-warning btn-xs'>Selesai Dikirim</span>";
                    } else {
                        echo $pengiriman = "<center><span class='btn btn-warning btn-xs'>Pembayaran Belum diverifikasi</span></center>";
                    }
                    ?>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>
<script>
    const barang_diterima = (resi) => {
        var today = new Date();
        var yyyy = today.getFullYear();
        let mm = today.getMonth() + 1; // Months start at 0!
        let dd = today.getDate();
        if (dd < 10) dd = '0' + dd;
        if (mm < 10) mm = '0' + mm;
        var today = yyyy + '-' + mm + '-' + dd;
        var isi = [];
        $.ajax({
            url: "<?= base_url() ?>transaksi/penjualan/cek_penjualan/" + resi,
            type: "get",
            success: function (a) {
                let data = JSON.parse(a),
                    isi = {
                        'id_pelanggan': "<?= $this->session->username ?>",
                        'id_penjualan': data.id_penjualan,
                        'no_transaksi': resi,
                        'tgl_jual': today,
                        'status_kirim': 2,
                        'nama_penerima': data.nama_pelanggan,
                    };
                $.ajax({
                    url: "<?= base_url() ?>transaksi/penjualan/diterima_pembeli",
                    type: "post",
                    data: isi,
                    success: function (post) {
                        if (post == true) {
                            swal.fire({ title: 'Berhasil', text: 'Barang telah diterima', icon: 'success' })
                                .then(() => {
                                    location.reload();
                                });
                        }
                    }
                });

            }

        });
    }
</script>