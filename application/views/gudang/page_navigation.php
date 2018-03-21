<header>
  <div class="container">
    <div class="row">
      <div class="col-md-2"><img class="img img-responsive" width="150" height="100" src="<?= base_url('images/ahass-suarakarta.png')?>" alt="Logo Perusahaan"></div>
      <div class="col-md-8">
      <h1>RODA MAS AUTO LESTARI</h1>
      <p style="color:#fff"><i class="fa fa-warning fa-fw"></i> Jl. Raya Sukabumi No.81 Ds.Sukamaju, Kec.Cianjur, Cianjur Telp. 0263-270788</p>
      <p></p>
      </div>
      <div class="col-md-2">

      </div>
    </div>
  </div>
  <nav class="navbar navbar-default navbar-static-top" role="navigation">

      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#"><i class="fa fa-user-secret fa-fw"></i> Halaman Gudang</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="navbar">
          <ul class="nav navbar-nav">
            <?php $uri = strtolower($this->uri->segment('2'))?>
            <li class="<?= $uri == "dashboard" ? "active":""; ?>"><a href="<?= base_url('gudang/dashboard')?>"><i class="fa fa-home fa-fw"></i> Home</a></li>
            <li class="<?= $uri == "barang" ? "active":""; ?>"><a href="<?= base_url('gudang/barang')?>"><i class="fa fa-asterisk fa-fw"></i> Barang</a></li>
            <li class=" <?= $uri == "pemesanan" || $uri=="masuk_barang" ? "active" : ""?>"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-inbox fa-fw"></i> Pengadaan Barang</a>
              <ul class="dropdown-menu">
                <li><a href="<?= base_url('gudang/pemesanan')?>"> Pemesanan</a></li>
                <li><a href="<?= base_url('gudang/Masuk_Barang')?>">Masuk Barang</a></li>
              </ul>
            </li>
            <li class="<?= $uri == "keluar_barang" ? 'active' : ''; ?>"><a href="<?= base_url('gudang/Keluar_Barang')?>"><i class="fa fa-sign-out fa-fw"></i> Keluar Barang</a></li>
            <li class=" <?= $uri == "retur_barang" || $uri=="retur_keluar" ? "active" : ""?>"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-repeat fa-fw"></i> Retur Barang</a>
              <ul class="dropdown-menu">
                <li><a href="<?= base_url('gudang/Retur_Barang')?>">Retur Barang Masuk</a></li>
                <li><a href="<?= base_url('gudang/Retur_Keluar')?>">Retur Barang Keluar</a></li>
              </ul>
            </li>
            <li class="<?= $uri == 'opname' ? 'active':'';?>"><a href="<?= base_url('gudang/Opname') ?>">Stock Opname</a></li>
            <li class="dropdown">
              <li class=" <?= $uri == "laporan_bulanan" || $uri=="laporan_harian" ? "active" : ""?>"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-book fa-fw"></i> Laporan <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="<?= base_url('gudang/Laporan_Analisis')?>"><i class="fa fa-calendar fa-fw"></i> Laporan Analisis</a></li>
                <li><a href="<?= base_url('gudang/Laporan_Pemenuhan'); ?>"><i class="fa fa-calendar fa-fw"></i> Laporan Pemenuhan Pesanan</a></li>
                <li><a href="<?= base_url('gudang/Laporan_Pembelian'); ?>"><i class="fa fa-calendar fa-fw"></i> Laporan Pembelian</a></li>
                <li><a href="<?= base_url('gudang/Laporan_Rutin'); ?>"><i class="fa fa-calendar fa-fw"></i> Laporan Harian</a></li>
                <li><a href="<?= base_url('gudang/Laporan_Stok'); ?>"><i class="fa fa-calendar fa-fw"></i> Laporan Stock Bulanan</a></li>
                <li><a href="<?= base_url('gudang/Laporan_Mutasi')?>"><i class="fa fa-calendar-o fa-fw"></i> Laporan Mutasi Stok</a></li>
              </ul>
            </li>
          </ul>

          <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user fa-fw"></i> <?= $this->session->userdata('nama')?> <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="<?= base_url('gudang/Setting') ?>"><i class="fa fa-wrench fa-fw"></i> Setting</a></li>
                <li class="divider"></li>
                <li><a href="<?= base_url('user/logout')?>"><i class="fa fa-sign-out fa-fw"></i>Logout</a></li>
              </ul>
            </li>

          </ul>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
  </nav>

</header>
