<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<section class="section pembayaran">
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Instruksi Pembayaran</h5>
                    <?php if (session()->getFlashData('success')) : ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= session()->getFlashData('success') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    <?php if (session()->getFlashData('failed')) : ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= session()->getFlashData('failed') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($transaction)) : ?>
                        <p>Pesanan Anda **#<?= $transaction['id'] ?>** berhasil dibuat.</p>
                        <p>Total yang harus dibayar adalah:
                        <h3><?= number_to_currency($transaction['total_harga'], 'IDR', 'id_ID') ?></h3>
                        </p>

                        <hr>

                        <h6>Detail Pembayaran:</h6>
                        <pre style="background-color: #f8f9fa; padding: 15px; border-radius: 5px; white-space: pre-wrap; word-wrap: break-word;"><?= $instruksi_pembayaran ?></pre>

                        <hr>

                        <p>Setelah melakukan pembayaran, mohon konfirmasi pembayaran Anda.</p>

                        <?php if ($transaction['status_pesanan'] === 'menunggu pembayaran') : ?>
                            <a href="<?= base_url('konfirmasi-pembayaran/' . $transaction['id']) ?>" class="btn btn-primary mt-3 me-2">Konfirmasi Pembayaran</a>
                        <?php endif; ?>

                        <div class="mt-4">
                            <a href="<?= base_url('riwayat-pesanan/detail/' . $transaction['id']) ?>" class="btn btn-info me-2">Lihat Detail Pesanan</a>
                            <a href="<?= base_url('riwayat-pesanan') ?>" class="btn btn-secondary">Kembali ke Riwayat Pesanan</a>
                        </div>

                    <?php else : ?>
                        <div class="alert alert-warning">
                            Detail transaksi tidak ditemukan.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>