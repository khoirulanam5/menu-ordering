<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cetak Nota</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        h2, h3 {
            text-align: center;
        }
    </style>
</head>
<body>

    <h2>Nota Penjualan</h2>
    <h3>No. Transaksi: <?= $pemesanan[0]->no_transaksi ?></h3>
    
    <p><strong>Tanggal Jual:</strong> <?= do_formal_date($pemesanan[0]->tanggal) ?></p>
    
    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pemesanan as $item): ?>
            <tr>
                <td><?= $item->nama_produk ?></td>
                <td><?= number_format($item->harga, 0, ',', '.') ?></td>
                <td><?= $item->jumlah ?></td>
                <td><?= number_format($item->total_harga, 0, ',', '.') ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
    <h3>Total Pembayaran: Rp. <?= number_format(array_sum(array_column($pemesanan, 'total_harga')), 0, ',', '.') ?></h3>
    
    <script>
        window.print();
    </script>

</body>
</html>
