<?php
	//mendapatkan id_produk dari url
	$id_produk=$_GET["id"];

	// query ambil data
	$ambil = $koneksi->query("SELECT * FROM produk WHERE id_produk='$id_produk'");
	$detail = $ambil->fetch_assoc();
?>

<section class="kontent wrap-content">
	<div class="container">
		<div class="col-md-6">
			<img src="gambar/produk/<?php echo $detail["foto_produk"]; ?>" alt="" class="img-responsive">
		</div>
		<div class="col-md-6">
			<h2><?php echo $detail["nama_produk"] ?></h2>
			<h4>Rp. <?php echo number_format($detail["harga_produk"]); ?></h4>

			<h5>Stok : <?= ($detail['stok_produk'] > 0 ? $detail['stok_produk'] : '<span class="text-danger">-Maaf stok habis-</span>' ) ?></h5>

			<form method="post" class="<?= ($detail['stok_produk'] > 0 ? NULL : 'hidden' ) ?>">
				<div class="form-group">
					<div class="input-group col-md-3">
						<input value="1" type="number" min="1" class="form-control" name="jumlah" max="<?php echo $detail['stok_produk'] ?>" required="">
						<div class="input-group-btn">
							<button class="btn btn-primary" name="beli">Beli</button>
						</div>
					</div>
				</div>
			</form>

			<?php
			// jika ada tombol beli
			if (isset($_POST["beli"]))
			{
				// mendapatkan jumlah yang diinputkan
				$jumlah = $_POST["jumlah"];
				// masukkan dikeranjang belanja
				$_SESSION["keranjang"][$id_produk] = $jumlah;

				echo "<script>alert('produk telah masuk ke keranjang belanja');</script>";
				echo "<script>location='index.php?page=keranjang';</script>";
			}
			?>
			<hr>
			<h4>Deskripsi</h4>
			<p class="text-justify"><?php echo $detail["deskripsi_produk"]; ?></p>
		</div>
	</div>
</section>
