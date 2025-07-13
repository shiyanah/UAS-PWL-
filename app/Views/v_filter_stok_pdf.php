<!DOCTYPE html>
<html>

<head>
    <title>Laporan Filter Stok Produk</title>
    <style>
        body {
            font-family: sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .text-center {
            text-align: center;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Laporan Filter Stok Produk</h1>
        <?php if (!empty($start_date) || !empty($end_date)) : ?>
            <p>Periode:
                <?php if (!empty($start_date)) echo date('d-m-Y', strtotime($start_date)); ?>
                <?php if (!empty($start_date) && !empty($end_date)) echo ' sampai '; ?>
                <?php if (!empty($end_date)) echo date('d-m-Y', strtotime($end_date)); ?>
            </p>
        <?php endif; ?>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Tanggal Dibuat</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($produk)) : ?>
                <?php $no = 1; ?>
                <?php foreach ($produk as $item) : ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= esc($item->nama) ?></td>
                        <td><?= esc($item->harga) ?></td>
                        <td><?= esc($item->jumlah) ?></td>
                        <td><?= esc($item->created_at) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data produk yang ditemukan dalam rentang tanggal ini.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>

</html>