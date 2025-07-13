<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<section class="section konfirmasi-pembayaran">
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Form Konfirmasi Pembayaran</h5>
                    <?php if (session()->getFlashData('success')) : ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= session()->getFlashData('success') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    <?php if (session()->getFlashData('failed')) : ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php
                            // Tampilkan error validasi jika ada
                            if (is_array(session()->getFlashData('failed'))) {
                                foreach (session()->getFlashData('failed') as $error) {
                                    echo '<p>' . $error . '</p>';
                                }
                            } else {
                                echo '<p>' . session()->getFlashData('failed') . '</p>';
                            }
                            ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($transaction)) : ?>
                        <p>Anda akan mengkonfirmasi pembayaran untuk Pesanan **#<?= $transaction['id'] ?>**.</p>
                        <p>Jumlah yang harus dibayar: <strong><?= number_to_currency($transaction['total_harga'], 'IDR', 'id_ID') ?></strong></p>

                        <hr>

                        <?= form_open_multipart('proses-konfirmasi-pembayaran') ?> <!-- Pastikan menggunakan form_open_multipart -->
                        <?= csrf_field() ?>
                        <input type="hidden" name="transaction_id" value="<?= $transaction['id'] ?>">

                        <div class="mb-3">
                            <label for="nama_pengirim_bank" class="form-label">Nama Pengirim (Sesuai Rekening Bank)</label>
                            <input type="text" class="form-control" id="nama_pengirim_bank" name="nama_pengirim_bank" value="<?= old('nama_pengirim_bank') ?>" required>
                            <?php if (session()->getFlashData('failed') && isset(session()->getFlashData('failed')['nama_pengirim_bank'])) : ?>
                                <div class="text-danger"><?= session()->getFlashData('failed')['nama_pengirim_bank'] ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="bank_pengirim" class="form-label">Bank Pengirim</label>
                            <input type="text" class="form-control" id="bank_pengirim" name="bank_pengirim" value="<?= old('bank_pengirim') ?>" placeholder="Contoh: BCA, Mandiri, BRI" required>
                            <?php if (session()->getFlashData('failed') && isset(session()->getFlashData('failed')['bank_pengirim'])) : ?>
                                <div class="text-danger"><?= session()->getFlashData('failed')['bank_pengirim'] ?></div>
                            <?php endif; ?>
                        </div>
                        <div class="mb-3">
                            <label for="bukti_transfer" class="form-label">Upload Bukti Transfer (Gambar)</label>
                            <input type="file" class="form-control" id="bukti_transfer" name="bukti_transfer" accept="image/*" required>
                            <div class="form-text">Format: JPG, JPEG, PNG. Max 2MB.</div>
                            <?php if (session()->getFlashData('failed') && isset(session()->getFlashData('failed')['bukti_transfer'])) : ?>
                                <div class="text-danger"><?= session()->getFlashData('failed')['bukti_transfer'] ?></div>
                            <?php endif; ?>
                        </div>

                        <button type="submit" class="btn btn-primary mt-3">Kirim Konfirmasi</button>
                        <a href="<?= base_url('riwayat-pesanan/detail/' . $transaction['id']) ?>" class="btn btn-secondary mt-3 ms-2">Batal</a>
                        <?= form_close() ?>

                    <?php else : ?>
                        <div class="alert alert-warning">
                            Transaksi tidak ditemukan untuk konfirmasi.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>