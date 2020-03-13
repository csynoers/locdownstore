<?php
session_start();
//koneksi ke database
	include 'koneksi.php';

	/* start :: konfirmasi email */
	if ( ! empty($_GET['konfirmasi_email']) ) 
	{
		$email = base64_decode($_GET['konfirmasi_email']);
		/* query cek data pelanggan */
		$db->query = "SELECT * FROM pelanggan WHERE email_pelanggan='{$email}'";

		/* cek terlebih dahulu apakah pelanggan dengan email ini tersedia jika tersedia lakukan update jika tidak kosongkan aksi */
		if ( count($db->query()) > 0 ) {
			/* query update data pelanggan */
			$db->query = "
				UPDATE
					`pelanggan`
				SET 
					`block`='tidak',
					`konfirmasi_email`='ya'
				WHERE email_pelanggan='{$email}'
			";
			/* eksekusi query */
			$db->query_exec();
	
			echo "<script>alert('Selamat akun anda telah aktif, Silahkan login terlebih dahulu untuk melakukan pembelian produk di locdownstore.com');</script>";
			echo "<script>location='index.php?page=login'</script>";
		}
	}
	/* end :: konfirmasi email */
?>
<!DOCTYPE html>
<html>
<head>
	<title>Locdown Store</title>
	<link rel="stylesheet" href="admin/assets/css/bootstrap.css">
	<link rel="stylesheet" href="admin/assets/css/font-awesome.css">
	<link rel="stylesheet" href="assets/css/scm-custom.css?v=0.1">
	<script src="admin/assets/js/jquery-1.10.2.js"></script>
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

			case 'riwayat-belanja':
				# code...
				include_once('riwayat.php');
				break;

			case 'nota':
				# code...
				include_once('nota.php');
				break;

			case 'lihat_pembayaran':
				# code...
				include_once('lihat_pembayaran.php');
				break;

			case 'checkout':
				# code...
				include_once('checkout.php');
				break;

			case 'pencarian':
				# code...
				include_once('pencarian.php');
				break;

			case 'login':
				# code...
				include_once('login.php');
				break;

			case 'daftar':
				# code...
				include_once('daftar.php');
				break;
			
			default:
				# default page
				?>
					<section class="konten wrap-content">
						<div class="container">
							<h1>Produk Terbaru</h1>
							<div class="row">
								<?php
									$db->query = "SELECT * FROM produk ORDER BY id_produk DESC";
									foreach ($db->query() as $key => $value) {
										$value->harga_produk_idr= number_format($value->harga_produk);
										$value->hrefDetail		= "index.php?page=detail-produk&id={$value->id_produk}";
										echo "
											<div class='col-md-3'>
												<div class='thumbnail'>
													<a href='{$value->hrefDetail}'>
														<div class='thumbnail-product' data-src='gambar/produk/{$value->foto_produk}'></div>
													</a>
													<div class='caption'>
														<h4><a href='{$value->hrefDetail}'>{$value->nama_produk}</a></h4>
														<h5>Rp. {$value->harga_produk_idr}</h5>
														<a href='beli.php?id={$value->id_produk}' class='btn btn-primary'>Beli</a>
														<a href='{$value->hrefDetail}' class='btn btn-default'>Detail</a>
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
	<script>
		(function( j ){
			let thumbnail_product = j( '.thumbnail-product' );
			j.each( thumbnail_product, function(){
				let thumbnail_product_src = j( this ).data( 'src' );
				
				/* create image background */
				j( this ).css( 'background-image' , `url('${thumbnail_product_src}')` )
				console.log( thumbnail_product_src )
			} )

			/* ketika provinsi dipilih */
			j( 'select[name=provinsi]' ).on( 'change',function(){
				/* set default input kode_pos */
				j( 'input[name=kode_pos]' ).val( '' );

				let province_id = j( this ).val();

				/* ambil data kota berdasarkan provinsi yang dipilih */
				j.get( 'get_kota.php',{ "province_id" : province_id }, function( html ){
					/* replace html option kota */
					j( 'select[name=kota]' ).html( html );
					
					/* ketika kota dipilih ambil data-postal-code */
					j( 'select[name=kota]' ).on( 'change',function(){
						let postal_code = j( this ).find( ':selected' ).data( 'postal-code' );
						console.log( postal_code );

						/* replace value input kota dengan postal_code */
						j( 'input[name=kode_pos]' ).val( postal_code );
					} );
				},'html')
				console.log( province_id );
			})
		})( jQuery )
	</script>
	</body>
</html>