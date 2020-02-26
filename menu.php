<header>
	<img src="foto_produk/logo.jpg" height="120" width"100" style="float:left; margin:0 8px 4px 0;">
	<h1 class="judul"> LOCDOWN STORE</h1>
	<h3 class="deskripsi"> - Distro Baju Terlengkap Di Prambanan- </h3>
</header>

<!-- navbar -->
<nav class="navbar navbar-default">
	<div class="container">
		<ul class="nav navbar navbar-nav">
			<li><a href="index.php" class="icon fa fa-home">Home</a></li>
			<li><a href="index.php?page=cara-pembelian" class="">Cara Pembelian</a></li>
			<li><a href="index.php?page=keranjang" class="fa fa-shopping-cart" >Keranjang</a></li>
			<!-- jika sudah login(ada session pelanggan) -->
			<?php if (isset($_SESSION["pelanggan"])): ?>
				<li><a href="index.php?page=riwayat-belanja" class="fa fa-sign-in">Riwayat Belanja</a></li>
				<li><a href="logout.php" class="fa fa-sign-in">Logout</a></li>	
			<!-- selain itu(belom login||belom ada session pelanggan) -->
			<?php else: ?>
				<li><a href="index.php?page=login"class="fa fa-sign-in">Login</a></li>
				<li><a href="index.php?page=daftar" class="fa fa-list">Daftar</a></li>
			<?php endif ?>
			
			<li><a href="index.php?page=checkout"class="fa fa-sign-out">Checkout</a></li>
			<li><a href="" class="fa fa-thumb-tack">Lokasi Kami</a></li>
		</ul>

		<form action="index.php" method="get" class="navbar-form navbar-right">
			<input type="hidden" class="form-control" name="page" value="pencarian">
			<input type="text" class="form-control" name="keyword">
			<button class="btn btn-primary">Cari</button>
		</form>
	</div>
</nav>