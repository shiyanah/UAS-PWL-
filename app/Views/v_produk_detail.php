<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="container mt-5">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title"><?= $product['nama'] ?></h5>
            <div class="row">
                <div class="col-md-6 text-center">
                    <?php if ($product['foto'] != '' && file_exists("NiceAdmin/assets/img/" . $product['foto'] . "")) : ?>
                        <img src="<?= base_url() . "NiceAdmin/assets/img/" . $product['foto'] ?>" class="img-fluid" alt="<?= $product['nama'] ?>">
                    <?php endif; ?>
                </div>
                <div class="col-md-6">
                    <h2><?= $product['nama'] ?></h2>
                    <h3>IDR <?= number_format($product['harga'], 0, ',', '.') ?></h3>
                    <p><strong>Stok Tersedia:</strong> <?= $product['jumlah'] ?></p>
                    <p><strong>Deskripsi Produk:</strong> <br>
                        <?= nl2br($product['deskripsi'] ?? 'Deskripsi produk belum tersedia.') ?>
                    </p>

                    <hr>

                    <?= form_open('keranjang') ?>
                    <?php
                    echo form_hidden('id', $product['id']);
                    echo form_hidden('nama', $product['nama']);
                    echo form_hidden('harga', $product['harga']);
                    echo form_hidden('foto', $product['foto']);
                    ?>

                    <a href="<?= base_url() ?>" class="btn btn-secondary">Kembali ke Beranda</a>
                    <button type="submit" class="btn btn-primary">Tambah ke Keranjang</button>
                    <?= form_close() ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>