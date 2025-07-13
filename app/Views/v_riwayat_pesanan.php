<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<?php
if (session()->getFlashData('success')) {
?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashData('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php
}
?>

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Riwayat Pesanan Saya</h5>
        <table class="table datatable">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">ID Pesanan</th>
                    <th scope="col">Total Harga</th>
                    <th scope="col">Status</th>
                    <th scope="col">Tanggal Pesanan</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php if (!empty($pesanan)) : ?>
                    <?php foreach ($pesanan as $item) : ?>
                        <tr>
                            <th scope="row"><?= $no++ ?></th>
                            <td><?= $item['id'] ?></td>
                            <td><?= number_to_currency($item['total_harga'], 'IDR') ?></td>
                            <td>
                                <span class="badge <?= ($item['status_pesanan'] == 'selesai') ? 'bg-success' : (($item['status_pesanan'] == 'dibatalkan') ? 'bg-danger' : (($item['status_pesanan'] == 'dikirim') ? 'bg-info' : 'bg-warning')) ?>">
                                    <?= ucfirst($item['status_pesanan']) ?>
                                </span>
                            </td>
                            <td><?= date('d-m-Y H:i:s', strtotime($item['created_at'])) ?></td>
                            <td>
                                <a href="<?= base_url('pesanan/detail/' . $item['id']) ?>" class="btn btn-info btn-sm">Detail</a>
                                <?php if ($item['status_pesanan'] == 'menunggu pembayaran') : ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="6" class="text-center">Anda belum memiliki riwayat pesanan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>