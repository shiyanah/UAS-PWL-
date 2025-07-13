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
        <h5 class="card-title">Manajemen Pesanan</h5>
        <table class="table datatable">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">ID Pesanan</th>
                    <th scope="col">Pelanggan</th>
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
                            <td><?= esc($item['username']) ?></td>
                            <td><?= number_to_currency($item['total_harga'], 'IDR') ?></td>
                            <td>
                                <span class="badge <?= ($item['status_pesanan'] == 'selesai') ? 'bg-success' : (($item['status_pesanan'] == 'dibatalkan') ? 'bg-danger' : (($item['status_pesanan'] == 'dikirim') ? 'bg-info' : 'bg-warning')) ?>">
                                    <?= ucfirst($item['status_pesanan']) ?>
                                </span>
                            </td>
                            <td><?= date('d-m-Y H:i:s', strtotime($item['created_at'])) ?></td>
                            <td>
                                <a href="<?= base_url('pesanan/detail/' . $item['id']) ?>" class="btn btn-info btn-sm">Detail</a>
                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editStatusModal-<?= $item['id'] ?>">Ubah Status</button>
                                <a href="<?= base_url('pesanan/delete/' . $item['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus pesanan ini?')">Hapus</a>
                            </td>
                        </tr>

                        <div class="modal fade" id="editStatusModal-<?= $item['id'] ?>" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Ubah Status Pesanan #<?= $item['id'] ?></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="<?= base_url('pesanan/updateStatus/' . $item['id']) ?>" method="post" class="form-update-status">
                                        <?= csrf_field(); ?>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="status_pesanan">Status Pesanan</label>
                                                <select name="status_pesanan" id="status_pesanan" class="form-control">
                                                    <option value="menunggu pembayaran" <?= ($item['status_pesanan'] == 'menunggu pembayaran') ? 'selected' : '' ?>>Menunggu Pembayaran</option>
                                                    <option value="diproses" <?= ($item['status_pesanan'] == 'diproses') ? 'selected' : '' ?>>Diproses</option>
                                                    <option value="dikirim" <?= ($item['status_pesanan'] == 'dikirim') ? 'selected' : '' ?>>Dikirim</option>
                                                    <option value="selesai" <?= ($item['status_pesanan'] == 'selesai') ? 'selected' : '' ?>>Selesai</option>
                                                    <option value="dibatalkan" <?= ($item['status_pesanan'] == 'dibatalkan') ? 'selected' : '' ?>>Dibatalkan</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada pesanan.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    $(document).ready(function() {
        $('.form-update-status').submit(function(e) {
            e.preventDefault();
            var form = $(this);
            var url = form.attr('action');
            var formData = form.serialize();

            $.ajax({
                type: 'POST',
                url: url,
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        alert(response.message);
                        location.reload(); // Reload halaman untuk melihat perubahan
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function() {
                    alert('Terjadi kesalahan saat memperbarui status.');
                }
            });
        });
    });
</script>
<?= $this->endSection() ?>