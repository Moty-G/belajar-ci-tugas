  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link <?php echo (uri_string() == '') ? "" : "collapsed" ?>" href="/">
          <i class="bi bi-grid"></i>
          <span>Home</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-item">
        <a class="nav-link <?php echo (uri_string() == 'keranjang') ? "" : "collapsed" ?>" href="keranjang">
          <i class="bi bi-cart4"></i>
          <span>Keranjang</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <?php
      if (session()->get('role') == 'admin') {
      ?>

      <li class="nav-item">
        <a class="nav-link <?php echo (uri_string() == 'produk') ? "" : "collapsed" ?>" href="produk">
          <i class="bi bi-card-list"></i>
          <span>Product</span>
        </a>
      </li><!-- End Produk Nav -->

      <li class="nav-item">
        <a class="nav-link <?php echo (strpos(uri_string(), 'diskon') === 0) ? "" : "collapsed" ?>" href="diskon">
          <i class="bi bi-tag-fill"></i>
          <span>Diskon</span>
        </a>
      </li><!-- End Diskon Nav -->

      <li class="nav-item">
        <a class="nav-link <?php echo (strpos(uri_string(), 'pembelian') === 0) ? "" : "collapsed" ?>" href="pembelian">
          <i class="bi bi-bag-check-fill"></i>
          <span>Pembelian</span>
        </a>
      </li><!-- End Pembelian Nav -->
      
      <?php
      }
      ?>


      <li class="nav-item">
          <a class="nav-link <?php echo (uri_string() == 'history') ? "" : "collapsed" ?>" href="history">
              <i class="bi bi-person"></i>
              <span>History</span>
          </a>
      </li><!-- End History Nav -->

      <li class="nav-item">
        <a class="nav-link <?php echo (uri_string() == 'profile') ? "" : "collapsed" ?>" href="profile">
          <i class="bi bi-person-fill"></i>
          <span>Profile</span>
        </a>
      </li><!-- End Profile Nav -->

    </ul>

  </aside><!-- End Sidebar-->
