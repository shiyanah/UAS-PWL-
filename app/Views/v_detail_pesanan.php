<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<section class="section profile">
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body pt-3">
                    <h5 class="card-title">Detail Pesanan #<?= $pesanan['id'] ?? '' ?></h5>

                    <div class="row">
                        <div class="col-lg-6 col-md-6 label ">Informasi Pelanggan</div>
                        <div class="col-lg-6 col-md-6 label ">Informasi Pesanan</div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-md-4 label">Username:</div>
                        <div class="col-lg-3 col-md-8"><?= $pesanan['username'] ?? 'N/A' ?></div>
                        <div class="col-lg-3 col-md-4 label">Tanggal Pesanan:</div>
                        <div class="col-lg-3 col-md-8"><?= date('d-m-Y H:i:s', strtotime($pesanan['tanggal_transaksi'] ?? date('Y-m-d H:i:s'))) ?></div>
                    </div>

                    <div class="row">
                        <div class="col-lg-3 col-md-4 label">Alamat Pengiriman:</div>
                        <div class="col-lg-3 col-md-8">
                            <?= nl2br($pesanan['alamat_pengiriman'] ?? 'Alamat belum tersedia.') ?>
                        </div>
                        <div class="col-lg-3 col-md-4 label">Status Pesanan:</div>
                        <div class="col-lg-3 col-md-8">
                            <?php
                            $statusClass = '';
                            switch ($pesanan['status_pesanan'] ?? '') {
                                case 'menunggu pembayaran':
                                    $statusClass = 'badge bg-warning';
                                    break;
                                case 'menunggu verifikasi':
                                    $statusClass = 'badge bg-info';
                                    break;
                                case 'diproses':
                                    $statusClass = 'badge bg-primary';
                                    break;
                                case 'dikirim':
                                    $statusClass = 'badge bg-secondary';
                                    break;
                                case 'selesai':
                                    $statusClass = 'badge bg-success';
                                    break;
                                case 'dibatalkan':
                                    $statusClass = 'badge bg-danger';
                                    break;
                                default:
                                    $statusClass = 'badge bg-light text-dark';
                                    break;
                            }
                            ?>
                            <span class="<?= $statusClass ?>"><?= ucfirst($pesanan['status_pesanan'] ?? 'Tidak Diketahui') ?></span>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-3 col-md-4 label">Layanan Pengiriman:</div>
                        <div class="col-lg-3 col-md-8"><?= $pesanan['layanan_kurir'] ?? 'N/A' ?></div>
                        <div class="col-lg-3 col-md-4 label">Total Harga (termasuk ongkir):</div>
                        <div class="col-lg-3 col-md-8"><?= number_to_currency($pesanan['total_harga'] ?? 0, 'IDR', 'id_ID') ?></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-md-4 label">Ongkir:</div>
                        <div class="col-lg-3 col-md-8"><?= number_to_currency($pesanan['ongkir'] ?? 0, 'IDR', 'id_ID') ?></div>
                        <div class="col-lg-3 col-md-4 label"></div>
                        <div class="col-lg-3 col-md-8"></div>
                    </div>

                    <?php if (session()->get('role') === 'admin' && ($pesanan['bukti_transfer'] ?? '') !== '') : ?>
                        <hr>
                        <h5 class="card-title">Detail Konfirmasi Pembayaran (Admin)</h5>
                        <div class="row">
                            <div class="col-lg-3 col-md-4 label">Nama Pengirim:</div>
                            <div class="col-lg-3 col-md-8"><?= $pesanan['nama_pengirim_bank'] ?? 'N/A' ?></div>
                            <div class="col-lg-3 col-md-4 label">Bank Pengirim:</div>
                            <div class="col-lg-3 col-md-8"><?= $pesanan['bank_pengirim'] ?? 'N/A' ?></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-4 label">Tanggal Konfirmasi:</div>
                            <div class="col-lg-3 col-md-8"><?= date('d-m-Y H:i:s', strtotime($pesanan['tanggal_konfirmasi'] ?? date('Y-m-d H:i:s'))) ?></div>
                            <div class="col-lg-3 col-md-4 label">Bukti Transfer:</div>
                            <div class="col-lg-3 col-md-8">
                                <?php if (!empty($pesanan['bukti_transfer']) && file_exists("NiceAdmin/assets/bukti_transfer/" . $pesanan['bukti_transfer'])) : ?>
                                    <a href="<?= base_url("NiceAdmin/assets/bukti_transfer/" . $pesanan['bukti_transfer']) ?>" target="_blank">
                                        <img src="<?= base_url("NiceAdmin/assets/bukti_transfer/" . $pesanan['bukti_transfer']) ?>" alt="Bukti Transfer" class="img-fluid" style="max-width: 150px;">
                                    </a>
                                <?php else : ?>
                                    Tidak ada bukti transfer.
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <hr>
                    <h5 class="card-title">Produk dalam Pesanan</h5>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Nama Produk</th>
                                <th scope="col">Foto</th>
                                <th scope="col">Harga Satuan</th>
                                <th scope="col">Jumlah Beli</th>
                                <th scope="col">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($detail_pesanan)) : ?>
                                <?php foreach ($detail_pesanan as $item) : ?>
                                    <tr>
                                        <td><?= $item['nama_produk'] ?? 'N/A' ?></td>
                                        <td>
                                            <?php if (!empty($item['foto']) && file_exists("NiceAdmin/assets/img/" . $item['foto'])) : ?>
                                                <img src="<?= base_url("NiceAdmin/assets/img/" . $item['foto']) ?>" alt="<?= $item['nama_produk'] ?>" width="50">
                                            <?php else : ?>
                                                Tidak ada foto
                                            <?php endif; ?>
                                        </td>
                                        <td><?= number_to_currency($item['harga_satuan'] ?? 0, 'IDR', 'id_ID') ?></td>
                                        <td><?= $item['jumlah'] ?? 0 ?></td>
                                        <td><?= number_to_currency($item['subtotal_harga'] ?? 0, 'IDR', 'id_ID') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada produk dalam pesanan ini.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>

                    <div class="text-end mt-3">
                        <a href="<?= base_url('riwayat-pesanan') ?>" class="btn btn-secondary">Kembali ke Riwayat Pesanan</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
=======
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