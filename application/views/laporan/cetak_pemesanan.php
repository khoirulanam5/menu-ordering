<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('src/img/wm.jpeg'); ?>">
    <title>Laporan <?= ucwords($this->input->get('periode')) ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #000;
            margin: 20px;
        }
        .header {
            position: relative;
            margin-top: 30px;
            margin-bottom: 20px;
        }
        .header img {
            position: absolute;
            left: 0;
            top: 0;
            width: 80px;
            height: auto;
        }
        .header-text {
            text-align: center;
        }
        .header-text h2,
        .header-text p {
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table, th, td {
            border: 1px solid #444;
        }
        th {
            background: #f0f0f0;
        }
        th, td {
            padding: 8px;
            text-align: center;
        }
        .title {
            text-align: center;
            margin-top: 20px;
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
        }
        @media print {
            body {
                margin: 0;
            }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="header">
        <img src="<?= base_url('src/img/wm.jpeg') ?>" alt="Logo">
        <div class="header-text">
            <h2>WM GARANG ASEM PODO ROSO</h2>
            <p>Jl. Patimura, Karangwatu, Loram Kulon, Kec. Jati, Kab. Kudus, Jawa Tengah</p>
        </div>
    </div>

    <div class="title">
        Laporan <?= ucwords($this->input->get('periode')) ?>
        <br>
        Periode: <?= do_formal_date(date('d-m-Y', strtotime($awal))) ?> s/d <?= do_formal_date(date('d-m-Y', strtotime($ahir))) ?>
    </div>

    <table>
        <thead>
            <tr>
                <th>No Transaksi</th>
                <th>ID Produk</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Total Harga</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($items)) {
                foreach ($items as $value) { ?>
                    <tr>
                        <td><?= $value->no_transaksi ?></td>
                        <td><?= $value->id_produk ?></td>
                        <td><?= $value->harga ?></td>
                        <td><?= $value->jumlah ?></td>
                        <td><?= $value->total_harga ?></td>
                        <td><?= do_formal_date($value->tanggal) ?></td>
                    </tr>
            <?php }
            } else { ?>
                <tr>
                    <td colspan="5">Tidak ada data ditemukan untuk periode ini.</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

</body>
</html>
