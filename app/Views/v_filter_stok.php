<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="container-fluid mt-4">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Filter Stok Produk</h3>
        </div>
        <div class="card-body">
            <form method="get" action="filter-stok" class="d-flex flex-wrap align-items-end mb-4 gap-3">
                <div class="form-group flex-grow-1">
                    <label for="start_date" class="form-label">Tanggal Mulai:</label>
                    <input type="date" id="start_date" name="start_date" class="form-control rounded-md shadow-sm" value="<?= esc($start_date ?? '') ?>" />
                </div>
                <div class="form-group flex-grow-1">
                    <label for="end_date" class="form-label">Tanggal Akhir:</label>
                    <input type="date" id="end_date" name="end_date" class="form-control rounded-md shadow-sm" value="<?= esc($end_date ?? '') ?>" />
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary rounded-md shadow-sm">Filter</button>
                    <button id="btnExportPDF" type="button" class="btn btn-danger rounded-md shadow-sm">Ekspor PDF</button>
                </div>
            </form>

            <table id="filterStokTable" class="table table-bordered table-striped w-full">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Jumlah Stok</th>
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
        </div>
    </div>
</div>

<script>
    document.getElementById('btnExportPDF').addEventListener('click', function() {
        const startDate = document.getElementById('start_date').value;
        const endDate = document.getElementById('end_date').value;
        // PERBAIKAN: URL untuk ekspor PDF menggunakan jalur relatif
        let url = 'filter-stok/export-pdf';

        const params = new URLSearchParams();
        if (startDate) {
            params.append('start_date', startDate);
        }
        if (endDate) {
            params.append('end_date', endDate);
        }

        if (params.toString()) {
            url += '?' + params.toString();
        }

        window.open(url, '_blank');
    });
</script>
<?= $this->endSection() ?>