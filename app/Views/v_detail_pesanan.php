<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Detail Pesanan #<?= $pesanan['id'] ?></h5>

        <div class="row">
            <div class="col-md-6">
                <h6>Informasi Pelanggan</h6>
                <p><strong>Username:</strong> <?= esc($pesanan['username']) ?></p>
                <p><strong>Alamat Pengiriman:</strong> <?= esc($pesanan['alamat']) ?></p>
                <p><strong>Kelurahan:</strong> <?= esc($pesanan['kelurahan']) ?></p>
                <p><strong>Layanan Pengiriman:</strong> <?= esc($pesanan['layanan_pengiriman']) ?></p>
                <p><strong>Ongkir:</strong> <?= number_to_currency($pesanan['ongkir'], 'IDR') ?></p>
            </div>
            <div class="col-md-6">
                <h6>Informasi Pesanan</h6>
                <p><strong>Tanggal Pesanan:</strong> <?= date('d-m-Y H:i:s', strtotime($pesanan['created_at'])) ?></p>
                <p><strong>Status Pesanan:</strong>
                    <span class="badge <?= ($pesanan['status_pesanan'] == 'selesai') ? 'bg-success' : (($pesanan['status_pesanan'] == 'dibatalkan') ? 'bg-danger' : (($pesanan['status_pesanan'] == 'dikirim') ? 'bg-info' : 'bg-warning')) ?>">
                        <?= ucfirst($pesanan['status_pesanan']) ?>
                    </span>
                </p>
                <p><strong>Total Harga (termasuk ongkir):</strong> <?= number_to_currency($pesanan['total_harga'], 'IDR') ?></p>
            </div>
        </div>

        <hr>

        <h6>Produk dalam Pesanan</h6>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Produk</th>
                    <th>Foto</th>
                    <th>Harga Satuan</th>
                    <th>Jumlah Beli</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($detail_pesanan)) : ?>
                    <?php foreach ($detail_pesanan as $item) : ?>
                        <tr>
                            <td><?= esc($item['nama_produk']) ?></td>
                            <td>
                                <?php if ($item['foto'] != '' && file_exists("NiceAdmin/assets/img/" . $item['foto'])) : ?>
                                    <img src="<?= base_url("NiceAdmin/assets/img/" . $item['foto']) ?>" width="50px">
                                <?php else : ?>
                                    Tidak ada foto
                                <?php endif; ?>
                            </td>
                            <td><?= number_to_currency($item['harga_satuan'], 'IDR') ?></td>
                            <td><?= esc($item['jumlah']) ?></td>
                            <td><?= number_to_currency($item['subtotal_harga'], 'IDR') ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada produk dalam pesanan ini.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="text-end">
            <?php if (session()->get('role') == 'admin') : ?>
                <a href="<?= base_url('pesanan') ?>" class="btn btn-secondary">Kembali ke Daftar Pesanan</a>
            <?php else : ?>
                <a href="<?= base_url('riwayat-pesanan') ?>" class="btn btn-secondary">Kembali ke Riwayat Pesanan</a>
            <?php endif; ?>
        </div>

    </div>
</div>

<?= $this->endSection() ?>