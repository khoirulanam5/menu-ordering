<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>WM Garang Asem</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <!-- AdminLTE CSS (Pastikan URL ini benar) -->
    <link rel="stylesheet" href="path/to/adminlte.min.css">
</head>
<body>
    <div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2 align-items-center">
                <!-- Kolom kiri: Pemesanan -->
                <div class="col-md-4 text-left">
                    <h1 class="m-0">Pemesanan</h1>
                </div>

                <!-- Kolom tengah: WM GARANG ASEM -->
                <div class="col-md-4 text-center">
                    <h1 class="m-0">WM GARANG ASEM</h1>
                </div>

                <!-- Kolom kanan: bisa kosong atau isi breadcrumb jika perlu -->
                <div class="col-md-4"></div>
            </div>
        </div>
    </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <!-- Form Penjualan -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Form Pemesanan</h3>
                            </div>
                            <div class="card-body">
                                <?php if ($this->session->flashdata('message')): ?>
                                    <script>
                                        <?= $this->session->flashdata('message'); ?>
                                    </script>
                                    <?php $this->session->unset_userdata('message'); ?>
                                <?php endif; ?>
                                <?php echo validation_errors(); ?>
                                <form method="post" action="<?= base_url('transaksi/pemesanan/create'); ?>">

                                    <div id="product-container">
                                        <div class="form-group product-row">
                                            <label for="id_produk">Nama Produk</label>
                                            <select name="id_produk[]" class="form-control product-select" required>
                                                <option value="" data-harga="0">--- Pilih Menu ---</option>
                                                <?php foreach ($produk as $p): ?>
                                                    <option value="<?php echo $p->id_produk; ?>" data-harga="<?php echo $p->harga_jualpro; ?>"><?php echo $p->nama_produk; ?></option>
                                                <?php endforeach; ?>
                                            </select>

                                            <label for="harga_jualpro">Harga</label>
                                            <input type="text" name="harga_jualpro[]" class="form-control harga-input" readonly>

                                            <label for="jumlah">Jumlah</label>
                                            <input type="text" name="jumlah[]" class="form-control jumlah-input" required>

                                            <label for="total_harga">Total Harga</label>
                                            <input type="text" name="total_harga[]" class="form-control total-harga-input" readonly>

                                            <label for="tanggal">Tanggal</label>
                                            <input type="date" name="tanggal" class="form-control total-harga-input" required>
                                            <br>
                                            <button type="button" class="btn btn-sm btn-danger remove-row">Hapus</button>
                                        </div>
                                    </div>
                                    
                                    <button type="button" id="add-row" class="btn btn-sm btn-primary">Tambah</button>
                                    <input class="btn btn-sm btn-success" type="submit" value="Pesan">
                                </form>

                            </div>
                        </div>
                        
                        <!-- Daftar Penjualan -->
                        <div class="card mt-4">
                            <div class="card-header">
                                <h3 class="card-title">Daftar Pemesanan</h3>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered" id="tables">
                                <thead>
                                    <tr>
                                        <th style="width: 7%;">No.</th>
                                        <th style="width: 10%;">No Transaksi</th>
                                        <th style="width: 20%;">Nama</th>
                                        <th style="width: 10%;">Harga</th>
                                        <th style="width: 10%;">Jumlah</th>
                                        <th style="width: 15%;">Total Harga</th>
                                        <th style="width: 20%;">Tanggal</th>
                                        <th style="width: 13%;">Nota</th>
                                    </tr>
                                </thead>
                                    <tbody>
                                        <?php 
                                        $no = 1;
                                        foreach ($pemesanan as $p): ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $p->no_transaksi; ?></td>
                                            <td><?= $p->nama_produk; ?></td>
                                            <td><?= $p->harga_jualpro; ?></td>
                                            <td><?= $p->jumlah; ?></td>
                                            <td><?= $p->total_harga; ?></td>
                                            <td><?= do_formal_date($p->tanggal); ?></td>
                                            <td>
                                                <a href="<?= base_url('transaksi/pemesanan/cetak_nota/'.$p->no_transaksi); ?>" class="btn btn-sm btn-primary" target="_blank"><i class="fa fa-print"></i></a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <br>
                                <div class="pagination-links">
                                    <?= $pagination; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- jQuery -->
    <script src="<?= base_url() ?>src/js/jquery.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <!-- AdminLTE JS (Pastikan URL ini benar) -->
    <script src="path/to/adminlte.min.js"></script>
    <!-- Inisialisasi DataTables -->
    <script>
        $(document).ready(function() {
        // Fungsi untuk menghitung total harga
        function calculateTotalPrice(row) {
            var harga = parseFloat(row.find('.harga-input').val()) || 0;
            var jumlah = parseFloat(row.find('.jumlah-input').val()) || 0;
            var totalHarga = harga * jumlah;
            row.find('.total-harga-input').val(totalHarga);
        }

        // Update harga ketika produk dipilih
        $(document).on('change', '.product-select', function() {
            var row = $(this).closest('.product-row');
            var harga = $(this).find(':selected').data('harga');
            row.find('.harga-input').val(harga);
            calculateTotalPrice(row);
        });

        // Update total harga ketika jumlah diubah
        $(document).on('input', '.jumlah-input', function() {
            var row = $(this).closest('.product-row');
            var jumlahValue = $(this).val();
            calculateTotalPrice(row);
        });

        // Tambah baris produk baru
        $('#add-row').click(function() {
            var newRow = $('.product-row:first').clone();
            newRow.find('input').val('');
            $('#product-container').append(newRow);
        });

        // Hapus baris produk
        $(document).on('click', '.remove-row', function() {
            if ($('.product-row').length > 1) {
                $(this).closest('.product-row').remove();
            }
        });

        // Inisialisasi DataTables jika ada tabel
        if ($('#tables').length) {
            $('#tables').DataTable();
        }
    });
    </script>
</body>
</html>
