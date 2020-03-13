<section class ="konten">
	<div class="container">
	<!-- nota disini copas saja dari nota yang ada di admin -->
	<h2>Detail Nota Pembelian</h2>
<?php
$ambil = $koneksi->query("SELECT * FROM pembelian JOIN pelanggan 
	ON pembelian.id_pelanggan=pelanggan.id_pelanggan 
	WHERE pembelian.id_pembelian='$_GET[id]'");
$detail = $ambil->fetch_assoc();
?>



<!-- jika pelanggan yang beli tidak sama dengan pelanggan yang login, maka dilarikan ke riwayat.php karena dia tidak berhak melihat nota orang lain -->
<!-- pelanggan yang beli harus pelanggan yang login -->
<?php 
// mendapatkan id_pelanggan yang beli
$idpelangganyangbeli = $detail["id_pelanggan"];

// mendapatkan id_pelanggan yang login
$idpelangganyanglogin = $_SESSION["pelanggan"]->id_pelanggan;

if ($idpelangganyangbeli!==$idpelangganyanglogin) 
{
	echo "<script>alert('jangan nakal');</script>";
	echo "<script>location='index.php';</script>";
	exit();
}
?>



	<div class="row">
		<div class="col-md-4">
			<h3>Pembelian</h3>
			<strong>No. Pembelian: <?php echo $detail['id_pembelian'] ?></strong><br>
			Tanggal : <?php echo $detail['tanggal_pembelian']; ?><br>
			Total : Rp. <?php echo number_format($detail['total_pembelian']) ?>
		</div>
		<div class="col-md-4">
			<h3>Pelanggan</h3>
			<strong><?php echo $detail['nama_pelanggan']; ?></strong> <br>
			<p>
				<?php echo $detail['telepon_pelanggan']; ?> <br>
				<?php echo $detail['email_pelanggan']; ?>
			</p>
		</div>	
		<div class="col-md-4">
			<h3>Pengiriman</h3>
			<strong><?php echo $detail['nama_kota'] ?></strong><br>
			Ongkos Kirim: Rp. <?php echo number_format($detail['tarif']); ?><br>
			Alamat : <?php echo $detail['alamat_pengiriman'] ?>
		</div>
	</div>


<table class="table table-bordered">
	<thead>
		<tr>
			<th>No</th>
			<th>Nama Produk</th>
			<th>Harga</th>
			<th>Berat</th>
			<th>Jumlah</th>
			<th>Sub Berat</th>
			<th>Sub Total</th>
		</tr>
	</thead>
	<tbody>
	<?php $nomor=1;?>
	<?php $ambil=$koneksi->query("SELECT * FROM pembelian_produk WHERE id_pembelian='$_GET[id]'"); ?>
	<?php while($pecah=$ambil->fetch_assoc()){ //echo json_encode($pecah);?>
		<tr>
			<td><?php echo $nomor; ?></td>
			<td><?php echo $pecah['nama']; ?></td>
			<td>Rp. <?php echo number_format($pecah['harga']); ?></td>
			<td><?php echo $pecah['berat']; ?></td>
			<td><?php echo $pecah['jumlah']; ?></td>
			<td><?php echo $pecah['subberat']; ?></td>
			<td>Rp. <?php echo number_format($pecah['subharga']); ?></td>
			</tr>
			<?php $nomor++; ?>
			<?php }?>
			</tbody>
			</table>
	

	<div class="row">
		<div class="col-md-7">
			<div class="alert alert-info">
				<p>
					Silahkan melakukan pembayaran Rp. <?php echo number_format($detail['total_pembelian']); ?> Ke <br>
					<strong> BANK BRI 137-001088-3276 AN. DANANG WAHYU</strong>
				</p>
			</div>
		</div>
	</div>
	</div>
</section>