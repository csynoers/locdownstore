<?php
session_start();
//koneksi ke database
include 'koneksi.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>Locdown Store</title>
	<link rel="stylesheet" href="admin/assets/css/bootstrap.css">
	<link rel="stylesheet" href="admin/assets/css/font-awesome.css">
	<link rel="stylesheet" href="assets/css/scm-custom.css">
</head>
<body>
	<?php
		include 'menu.php';

		switch (empty($_GET['page']) ? NULL : $_GET['page'] ) {
			case 'cara-pembelian':
				# code...
				include_once('cara_pembelian.php');
				break;

			case 'detail-produk':
				# code...
				include_once('detail.php');
				break;

			case 'keranjang':
				# code...
				include_once('keranjang.php');
				break;
			
			default:
				# default page
				?>
					<section class="konten wrap-content">
						<div class="container">
							<h1>Produk Terbaru</h1>
							<div class="row">
								<?php
									$db->query = "SELECT * FROM produk";
									foreach ($db->query() as $key => $value) {
										$value->harga_produk_idr = number_format($value->harga_produk);
										echo "
											<div class='col-md-3'>
												<div class='thumbnail'>
													<img src='foto_produk/{$value->foto_produk}' alt=''>
													<div class='caption'>
														<h3>{$value->nama_produk}</h3>
														<h5>Rp. {$value->harga_produk_idr}</h5>
														<a href='beli.php?id={$value->id_produk}' class='btn btn-primary'>Beli</a>
														<a href='index.php?page=detail-produk&id={$value->id_produk}' class='btn btn-default'>Detail</a>
													</div>
												</div>
											</div>
										";
									}
								?>
							</div>
						</div>
					</section>
				<?php
				break;
		}

		include 'footer.php';
	?>
	</body>
</html>