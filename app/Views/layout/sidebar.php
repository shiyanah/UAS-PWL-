<<<<<<< HEAD
=======
<!-- ======= Sidebar ======= -->
>>>>>>> b975839726026fcc5ed5e2156954efa0aaa1b1b7
<aside id="sidebar" class="sidebar">

  <ul class="sidebar-nav" id="sidebar-nav">

    <li class="nav-item">
      <a class="nav-link <?php echo (uri_string() == '') ? "" : "collapsed" ?>" href="/">
        <i class="bi bi-house-fill"></i>
        <span>Home</span>
      </a>
<<<<<<< HEAD
    </li><li class="nav-item">
=======
    </li><!-- End Home Nav -->

    <li class="nav-item">
>>>>>>> b975839726026fcc5ed5e2156954efa0aaa1b1b7
      <a class="nav-link <?php echo (uri_string() == 'keranjang') ? "" : "collapsed" ?>" href="keranjang">
        <i class="bi bi-cart-fill"></i>
        <span>Keranjang</span>
      </a>
<<<<<<< HEAD
    </li><?php
=======

    </li><!-- Kategori Nav -->
    <?php
>>>>>>> b975839726026fcc5ed5e2156954efa0aaa1b1b7
    if (session()->get('role') == 'admin') {
    ?>

      <li class="nav-item">
        <a class="nav-link <?php echo (uri_string() == 'produk') ? "" : "collapsed" ?>" href="produk">
          <i class="bi bi-handbag-fill"></i>
          <span>Produk</span>
        </a>
<<<<<<< HEAD
      
      <li class="nav-item">
        <a href="filter-stok" class="nav-link <?= (uri_string() == 'filter-stok') ? '' : 'collapsed' ?>">
          <i class="bi bi-funnel"></i> 
          <span>Filter Stok</span> 
        </a>
      </li>
      
    <?php
    }
    ?>

=======
      </li><!-- End Produk Nav -->
    <?php
    }
    ?>
>>>>>>> b975839726026fcc5ed5e2156954efa0aaa1b1b7
    <li class="nav-item">
      <a class="nav-link <?php echo (uri_string() == 'profile') ? "" : "collapsed" ?>" href="profile">
        <i class="bi bi-person"></i>
        <span>Profile</span>
      </a>
    </li>
<<<<<<< HEAD
  </ul>

</aside>
=======
    <li class="nav-item">
      <a href="filter-stok" class="nav-link <?= (uri_string() == 'filter-stok') ? 'active' : 'collapsed' ?>">
        <i class="bi bi-funnel"></i> <span>Filter Stok</span> </a>
    </li>
  </ul>

</aside>
<!-- End Sidebar-->
>>>>>>> b975839726026fcc5ed5e2156954efa0aaa1b1b7
