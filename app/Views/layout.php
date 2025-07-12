<?php
$hlm = "Home";
if (uri_string() != "") {
  $hlm = ucwords(uri_string());
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title> 'Toko Arunika- ' <?php echo $hlm ?></title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="<?= base_url() ?>NiceAd<?= base_url() ?>NiceAdmin/assets//img/favicon.png" rel="icon">
  <link href="<?= base_url() ?>NiceAd<?= base_url() ?>NiceAdmin/assets//img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- Select2 -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  <!-- Vendor CSS Files -->
  <link href="<?= base_url() ?>NiceAd<?= base_url() ?>NiceAdmin/assets//vendor/bootstrap/css/bootstrap.<?= base_url() ?>NiceAdmin/assets.css" rel="stylesheet">
  <link href="<?= base_url() ?>NiceAd<?= base_url() ?>NiceAdmin/assets//vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="<?= base_url() ?>NiceAd<?= base_url() ?>NiceAdmin/assets//vendor/boxicons/css/boxicons.<?= base_url() ?>NiceAdmin/assets.css" rel="stylesheet">
  <link href="<?= base_url() ?>NiceAd<?= base_url() ?>NiceAdmin/assets//vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="<?= base_url() ?>NiceAd<?= base_url() ?>NiceAdmin/assets//vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="<?= base_url() ?>NiceAd<?= base_url() ?>NiceAdmin/assets//vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="<?= base_url() ?>NiceAd<?= base_url() ?>NiceAdmin/assets//vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="<?= base_url() ?>NiceAd<?= base_url() ?>NiceAdmin/assets//css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: NiceAd<?= base_url() ?>NiceAdmin/assets
  * Updated: Mar 09 2023 with Bootstrap v5.2.3
  * Template URL: https://bootstrapmade.com/nice-ad<?= base_url() ?>NiceAdmin/assets-bootstrap-ad<?= base_url() ?>NiceAdmin/assets-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
  <?= $this->renderSection('script') ?>
</head>

<body>

  <?= $this->include('layout/header') ?>


  <?= $this->include('layout/sidebar') ?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1><?= $hlm ?></h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/">Home</a></li>
          <?php if ($hlm != 'Home'): ?>
            <li class="breadcrumb-item active"><?= $hlm ?></li>
          <?php endif; ?>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <?= $this->renderSection('content') ?>
    </section>

  </main>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="<?= base_url() ?>NiceAdmin/assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="<?= base_url() ?>NiceAdmin/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?= base_url() ?>NiceAdmin/assets/vendor/chart.js/chart.umd.js"></script>
  <script src="<?= base_url() ?>NiceAdmin/assets/vendor/echarts/echarts.min.js"></script>
  <script src="<?= base_url() ?>NiceAdmin/assets/vendor/quill/quill.min.js"></script>
  <script src="<?= base_url() ?>NiceAdmin/assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="<?= base_url() ?>NiceAdmin/assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="<?= base_url() ?>NiceAdmin/assets/vendor/php-email-form/validate.js"></script>

  <!-- Vendor JS Files -->
  <script src="/NiceAdmin/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Template Main JS File -->
  <script src="/NiceAdmin/assets/js/main.js"></script>

</html>