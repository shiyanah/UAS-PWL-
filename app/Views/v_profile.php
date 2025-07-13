<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
History Transaksi Pembelian <strong><?= $username ?? 'Pengguna' ?></strong>
<hr>
<div class="table-responsive">
    <!-- Tabel Riwayat Transaksi -->
    <table class="table datatable">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">ID Pembelian</th>
                <th scope="col">Waktu Pembelian</th>
                <th scope="col">Total Bayar</th>
                <th scope="col">Alamat</th>
                <th scope="col">Status</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Memastikan variabel $buy ada dan tidak kosong
            if (!empty($buy)) :
                foreach ($buy as $index => $item) :
            ?>
                    <tr>
                        <th scope="row"><?php echo $index + 1 ?></th>
                        <td><?php echo $item['id'] ?></td>
                        <td><?php echo $item['created_at'] ?></td>
                        <td><?php echo number_to_currency($item['total_harga'], 'IDR') ?></td>
                        <td><?php echo $item['alamat'] ?></td>
                        <td>
                            <?php
                            // Menampilkan status pesanan berdasarkan nilai dari database
                            if ($item['status_pesanan'] == 'menunggu pembayaran') {
                                echo 'Menunggu Pembayaran';
                            } elseif ($item['status_pesanan'] == 'diproses') {
                                echo 'Diproses';
                            } elseif ($item['status_pesanan'] == 'dikirim') {
                                echo 'Dikirim';
                            } elseif ($item['status_pesanan'] == 'selesai') {
                                echo 'Selesai';
                            } else {
                                echo ucfirst($item['status_pesanan']); // Default jika ada status lain
                            }
                            ?>
                        </td>
                        <td>
                            <!-- Tombol Detail untuk membuka modal -->
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#detailModal-<?= $item['id'] ?>">
                                Detail
                            </button>
                        </td>
                    </tr>
                    <!-- Detail Modal untuk setiap transaksi -->
                    <div class="modal fade" id="detailModal-<?= $item['id'] ?>" tabindex="-1" aria-labelledby="detailModalLabel-<?= $item['id'] ?>" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="detailModalLabel-<?= $item['id'] ?>">Detail Pesanan #<?= $item['id'] ?></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <h6>Produk yang Dibeli:</h6>
                                    <?php
                                    // Memastikan variabel $detail_products ada dan berisi detail untuk transaksi ini
                                    if (isset($detail_products[$item['id']]) && !empty($detail_products[$item['id']])) {
                                        foreach ($detail_products[$item['id']] as $index2 => $item2) : ?>
                                            <p>
                                                <?php echo $index2 + 1 ?>)
                                                <?php if ($item2['foto'] != '' && file_exists("NiceAdmin/assets/img/" . $item2['foto'] . "")) : ?>
                                                    <img src="<?php echo base_url() . "NiceAdmin/assets/img/" . $item2['foto'] ?>" width="50px" class="img-thumbnail me-2">
                                                <?php endif; ?>
                                                <strong><?= $item2['nama_produk'] ?></strong><br>
                                                <?= number_to_currency($item2['harga_satuan'], 'IDR') ?> x <?= $item2['jumlah'] ?> pcs<br>
                                                Subtotal: <?= number_to_currency($item2['subtotal_harga'], 'IDR') ?>
                                            </p>
                                            <hr>
                                        <?php
                                        endforeach;
                                    } else {
                                        echo '<p>Tidak ada detail produk untuk pesanan ini.</p>';
                                    }
                                    ?>
                                    <p><strong>Alamat Pengiriman:</strong> <?= esc($item['alamat']) ?>, <?= esc($item['kelurahan']) ?></p>
                                    <p><strong>Layanan Pengiriman:</strong> <?= esc($item['layanan_pengiriman']) ?></p>
                                    <p><strong>Ongkir:</strong> <?= number_to_currency($item['ongkir'], 'IDR') ?></p>
                                    <p><strong>Total Harga:</strong> <?= number_to_currency($item['total_harga'], 'IDR') ?></p>
                                    <p><strong>Status Pesanan:</strong>
                                        <?php
                                        if ($item['status_pesanan'] == 'menunggu pembayaran') {
                                            echo 'Menunggu Pembayaran';
                                        } elseif ($item['status_pesanan'] == 'diproses') {
                                            echo 'Diproses';
                                        } elseif ($item['status_pesanan'] == 'dikirim') {
                                            echo 'Dikirim';
                                        } elseif ($item['status_pesanan'] == 'selesai') {
                                            echo 'Selesai';
                                        } else {
                                            echo ucfirst($item['status_pesanan']);
                                        }
                                        ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php
                endforeach;
            else :
            ?>
                <tr>
                    <td colspan="7" class="text-center">Tidak ada riwayat transaksi.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>