<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .nota {
            width: 100%;
            border-collapse: collapse;
        }
        .nota th, .nota td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        .nota th {
            background-color: #f2f2f2;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body onload="window.print()">
    <div class="container">
        <h2 class="text-center">Nota Transaksi</h2>
        <table class="nota">
            <tr>
                <th>No. Transaksi</th>
                <td><?= strtoupper($value->no_transaksi) ?></td>
            </tr>
            <tr>
                <th>Status Kirim</th>
                <td>
                    <?php if ($value->status_kirim == 1): ?>
                        Proses Dikirim
                    <?php elseif ($value->status_kirim == 2): ?>
                        Paket Sudah Diterima
                    <?php else: ?>
                        <?= strtoupper($value->status_kirim) ?>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <th>Nama Penerima</th>
                <td><?= strtoupper($value->nama_penerima) ?></td>
            </tr>
        </table>
        <p class="text-center">Terima kasih telah berbelanja!</p>
    </div>
</body>
</html>
