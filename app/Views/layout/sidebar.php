<aside id="sidebar" class="sidebar">

  <ul class="sidebar-nav" id="sidebar-nav">

    <li class="nav-item">
      <a class="nav-link <?php echo (uri_string() == '') ? "" : "collapsed" ?>" href="/">
        <i class="bi bi-house-fill"></i>
        <span>Home</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link <?php echo (uri_string() == 'keranjang') ? "" : "collapsed" ?>" href="keranjang">
        <i class="bi bi-cart-fill"></i>
        <span>Keranjang</span>
      </a>
    </li><?php
          if (session()->get('role') == 'admin') {
          ?>
      <li class="nav-item">
        <a class="nav-link <?php echo (uri_string() == 'produk') ? "" : "collapsed" ?>" href="produk">
          <i class="bi bi-handbag-fill"></i>
          <span>Produk</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?php echo (uri_string() == 'pesanan') ? "" : "collapsed" ?>" href="pesanan">
          <i class="bi bi-receipt-cutoff"></i>
          <span>Manajemen Pesanan</span>
        </a>
      </li><?php
          } else { // Jika bukan admin (asumsi pelanggan)
            ?>
      <li class="nav-item">
        <a class="nav-link <?php echo (uri_string() == 'riwayat-pesanan') ? "" : "collapsed" ?>" href="riwayat-pesanan">
          <i class="bi bi-clock-history"></i>
          <span>Riwayat Pesanan</span>
        </a>
      </li><?php
          }
            ?>

    <li class="nav-item">
      <a class="nav-link <?php echo (uri_string() == 'profile') ? "" : "collapsed" ?>" href="profile">
        <i class="bi bi-person"></i>
        <span>Profile</span>
      </a>
    </li>
    <li class="nav-item">
      <a href="filter-stok" class="nav-link <?= (uri_string() == 'filter-stok') ? 'active' : 'collapsed' ?>">
        <i class="bi bi-funnel"></i> <span>Filter Stok</span> </a>
    </li>
  </ul>

</aside>