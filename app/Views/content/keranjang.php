<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="card">
  <div class="card-body">
    <h5 class="card-title">Data Kategori</h5>
    <ul>
      <?php foreach ($kat as $key => $value) {
      ?>
        <li><?php echo $value ?></li>
      <?php
      }
      ?>
    </ul>
  </div>
</div>

<?= $this->endSection() ?>
<!-- Vendor JS Files -->
<script src="/NiceAdmin/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Template Main JS File -->
<script src="/NiceAdmin/assets/js/main.js"></script>