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
<div class="row">
  <?php foreach ($product as $key => $item) : ?>
    <div class="col-lg-4">
      <?= form_open('keranjang') ?>
      <?php
      echo form_hidden('id', $item['id']);
      echo form_hidden('nama', $item['nama']);
      echo form_hidden('harga', $item['harga']);
      echo form_hidden('foto', $item['foto']);
      ?>
      <div class="card">
        <div class="card-body">
          <img src="<?php echo base_url() . "NiceAdmin/assets/img/" . $item['foto'] ?>" 
               alt="..." 
               style="width: 100%; height: 350px; object-fit: contain;"> 
          <h5 class="card-title"><?php echo $item['nama'] ?><br><?php echo number_to_currency($item['harga'], 'IDR') ?></h5>
          <a href="<?= base_url('produk_detail/' . $item['id']) ?>" class="btn btn-info rounded-pill">Detail</a>
          <button type="submit" class="btn btn-primary rounded-pill">Beli</button>
        </div>
      </div>
      <?= form_close() ?>
    </div>
  <?php endforeach ?>
</div>
<?= $this->endSection() ?>