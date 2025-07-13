<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<?php
if (session()->getFlashData('success')) {
?>
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <?= session()->getFlashData('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php
}
?>
<?php
if (session()->getFlashData('failed')) {
?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session()->getFlashData('failed') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php
}
?>
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
    Tambah Data
</button>
<<<<<<< HEAD
<a type="button" class="btn btn-success" href="<?= base_url() ?> produk/download">
=======
<a type="button" class="btn btn-success" href="<?= base_url() ?>produk/download">
>>>>>>> bfdcf628f4796abd741fe54c214b1529241a8247
    Download Data
</a>

<table class="table datatable">
    <thead>
        <tr>
<<<<<<< HEAD
            <th scope="col" style="width: 5%;">#</th>
            <th scope="col" style="width: 15%;">Nama</th>
            <th scope="col" style="width: 10%;">Harga</th>
            <th scope="col" style="width: 8%;">Jumlah</th>
            <th scope="col" style="width: 30%;">Deskripsi</th>
            <th scope="col" style="width: 12%;">Foto</th>
            <th scope="col" style="width: 20%;">Aksi</th>
=======
            <th scope="col">#</th>
            <th scope="col">Nama</th>
            <th scope="col">Harga</th>
            <th scope="col">Jumlah</th>
            <th scope="col">Foto</th>
            <th scope="col">Deskripsi</th>
            <th scope="col">Aksi</th>
>>>>>>> bfdcf628f4796abd741fe54c214b1529241a8247
        </tr>
    </thead>
    <tbody>
        <?php foreach ($product as $index => $produk) : ?>
            <tr>
                <th scope="row"><?php echo $index + 1 ?></th>
                <td><?php echo $produk['nama'] ?></td>
<<<<<<< HEAD
                <td><?php echo number_to_currency($produk['harga'], 'IDR', 'id_ID') ?></td>
                <td><?php echo $produk['jumlah'] ?></td>
                <td><?php echo nl2br(substr($produk['deskripsi'] ?? 'N/A', 0, 150)) . (strlen($produk['deskripsi'] ?? '') > 150 ? '...' : '') ?></td>
                <td>
                    <?php if ($produk['foto'] != '' and file_exists("NiceAdmin/assets/img/" . $produk['foto'] . "")) : ?>
                        <img src="<?php echo base_url() . "NiceAdmin/assets/img/" . $produk['foto'] ?>" width="80px" height="auto" style="object-fit: cover;">
                    <?php endif; ?>
                </td>
                <td>
                    <div class="d-flex flex-column gap-2">
                        <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#editModal-<?= $produk['id'] ?>">
                            Ubah
                        </button>
                        <a href="<?= base_url('produk/delete/' . $produk['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus data ini ?')">
                            Hapus
                        </a>
                    </div>
=======
                <td><?php echo $produk['harga'] ?></td>
                <td><?php echo $produk['jumlah'] ?></td>
                <td>
                    <?php if ($produk['foto'] != '' and file_exists("NiceAdmin/assets/img/" . $produk['foto'] . "")) : ?>
                        <img src="<?php echo base_url() . "NiceAdmin/assets/img/" . $produk['foto'] ?>" width="100px">
                    <?php endif; ?>
                </td>
                <td><?= $produk['deskripsi'] ?? 'Tidak ada deskripsi' ?></td>
                <td>
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editModal-<?= $produk['id'] ?>">
                        Ubah
                    </button>
                    <a href="<?= base_url('produk/delete/' . $produk['id']) ?>" class="btn btn-danger" onclick="return confirm('Yakin hapus data ini ?')">
                        Hapus
                    </a>
>>>>>>> bfdcf628f4796abd741fe54c214b1529241a8247
                </td>
            </tr>
            <div class="modal fade" id="editModal-<?= $produk['id'] ?>" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Data</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="<?= base_url('produk/edit/' . $produk['id']) ?>" method="post" enctype="multipart/form-data">
                            <?= csrf_field(); ?>
                            <div class="modal-body">
                                <div class="form-group">
<<<<<<< HEAD
                                    <label for="nama">Nama</label>
                                    <input type="text" name="nama" class="form-control" id="nama" value="<?= $produk['nama'] ?>" placeholder="Nama Barang" required>
                                </div>
                                <div class="form-group">
                                    <label for="harga">Harga</label>
                                    <input type="text" name="harga" class="form-control" id="harga" value="<?= $produk['harga'] ?>" placeholder="Harga Barang" required>
                                </div>
                                <div class="form-group">
                                    <label for="jumlah">Jumlah</label>
                                    <input type="text" name="jumlah" class="form-control" id="jumlah" value="<?= $produk['jumlah'] ?>" placeholder="Jumlah Barang" required>
                                </div>
                                <div class="form-group">
                                    <label for="deskripsi">Deskripsi</label> <textarea name="deskripsi" class="form-control" id="deskripsi" placeholder="Deskripsi Barang" rows="3"><?= $produk['deskripsi'] ?? '' ?></textarea>
=======
                                    <label for="name">Nama</label>
                                    <input type="text" name="nama" class="form-control" id="nama" value="<?= $produk['nama'] ?>" placeholder="Nama Barang" required>
                                </div>
                                <div class="form-group">
                                    <label for="name">Harga</label>
                                    <input type="text" name="harga" class="form-control" id="harga" value="<?= $produk['harga'] ?>" placeholder="Harga Barang" required>
                                </div>
                                <div class="form-group">
                                    <label for="name">Jumlah</label>
                                    <input type="text" name="jumlah" class="form-control" id="jumlah" value="<?= $produk['jumlah'] ?>" placeholder="Jumlah Barang" required>
                                </div>
                                <div class="form-group">
                                    <label for="deskripsi">Deskripsi</label>
                                    <textarea name="deskripsi" class="form-control" id="deskripsi" placeholder="Deskripsi Barang"><?= $produk['deskripsi'] ?? '' ?></textarea>
>>>>>>> bfdcf628f4796abd741fe54c214b1529241a8247
                                </div>
                                <img src="<?php echo base_url() . "NiceAdmin/assets/img/" . $produk['foto'] ?>" width="100px">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="check" name="check" value="1">
                                    <label class="form-check-label" for="check">
                                        Ceklis jika ingin mengganti foto
                                    </label>
                                </div>
                                <div class="form-group">
<<<<<<< HEAD
                                    <label for="foto">Foto</label>
=======
                                    <label for="name">Foto</label>
>>>>>>> bfdcf628f4796abd741fe54c214b1529241a8247
                                    <input type="file" class="form-control" id="foto" name="foto">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    </tbody>
</table>
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('produk') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
                <div class="modal-body">
                    <div class="form-group">
<<<<<<< HEAD
                        <label for="nama">Nama</label>
                        <input type="text" name="nama" class="form-control" id="nama" placeholder="Nama Barang" required>
                    </div>
                    <div class="form-group">
                        <label for="harga">Harga</label>
                        <input type="text" name="harga" class="form-control" id="harga" placeholder="Harga Barang" required>
                    </div>
                    <div class="form-group">
                        <label for="jumlah">Jumlah</label>
                        <input type="text" name="jumlah" class="form-control" id="jumlah" placeholder="Jumlah Barang" required>
                    </div>
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label> <textarea name="deskripsi" class="form-control" id="deskripsi" placeholder="Deskripsi Barang" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="foto">Foto</label>
=======
                        <label for="name">Nama</label>
                        <input type="text" name="nama" class="form-control" id="nama" placeholder="Nama Barang" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Harga</label>
                        <input type="text" name="harga" class="form-control" id="harga" placeholder="Harga Barang" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Jumlah</label>
                        <input type="text" name="jumlah" class="form-control" id="jumlah" placeholder="Jumlah Barang" required>
                    </div>
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" id="deskripsi" placeholder="Deskripsi Barang"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="name">Foto</label>
>>>>>>> bfdcf628f4796abd741fe54c214b1529241a8247
                        <input type="file" class="form-control" id="foto" name="foto">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>