<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<?php if (isset($product_detail)) : ?>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Detail Produk</h5>
            <div class="row">
                <div class="col-md-4">
                    <?php if ($product_detail['foto'] != '' && file_exists("NiceAdmin/assets/img/" . $product_detail['foto'])) : ?>
                        <img src="<?php echo base_url() . "NiceAdmin/assets/img/" . $product_detail['foto'] ?>" class="img-fluid" alt="<?= $product_detail['nama'] ?>">
                    <?php endif; ?>
                </div>
                <div class="col-md-8">
                    <h3><?= $product_detail['nama'] ?></h3>
                    <h4><?= number_to_currency($product_detail['harga'], 'IDR') ?></h4>
                    <p><strong>Stok Tersedia:</strong> <?= $product_detail['jumlah'] ?></p>
                    <p><strong>Deskripsi Produk:</strong> <?= nl2br($product_detail['deskripsi'] ?? 'Deskripsi belum tersedia.') ?></p>
                    <?php // Add more details like ISBN, Publisher, etc. if available in your product data 
                    ?>

                    <div class="d-flex justify-content-start align-items-center mt-3">
                        <a href="<?= base_url('/') ?>" class="btn btn-secondary me-2">Kembali ke Beranda</a>
                        <?= form_open('keranjang', ['class' => 'd-inline-block']) ?>
                        <?php
                        echo form_hidden('id', $product_detail['id']);
                        echo form_hidden('nama', $product_detail['nama']);
                        echo form_hidden('harga', $product_detail['harga']);
                        echo form_hidden('foto', $product_detail['foto']);
                        ?>
                        <button type="submit" class="btn btn-primary">Tambah ke Keranjang</button>
                        <?= form_close() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if (!empty($recommended_products)) : ?>
    <div class="mt-4">
        <h4>Produk Lain yang Mungkin Anda Suka</h4>
        <div class="row">
            <?php foreach ($recommended_products as $item) : ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <img src="<?php echo base_url() . "NiceAdmin/assets/img/" . $item['foto'] ?>" class="img-fluid mb-2" alt="..." style="max-height: 150px; object-fit: cover;">
                            <h6 class="card-title"><?php echo $item['nama'] ?></h6>
                            <p class="card-text"><?php echo number_to_currency($item['harga'], 'IDR') ?></p>
                            <div class="d-flex justify-content-start">
                                <a href="<?= base_url('produk_detail/' . $item['id']) ?>" class="btn btn-info btn-sm rounded-pill me-2">Detail</a>
                                <?= form_open('keranjang') ?>
                                <?php
                                echo form_hidden('id', $item['id']);
                                echo form_hidden('nama', $item['nama']);
                                echo form_hidden('harga', $item['harga']);
                                echo form_hidden('foto', $item['foto']);
                                ?>
                                <button type="submit" class="btn btn-primary btn-sm rounded-pill">Beli</button>
                                <?= form_close() ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>