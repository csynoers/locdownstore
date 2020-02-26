<?php
$id_pembelian = $_GET["id"];

$ambil = $koneksi->query("SELECT * FROM Pembayaran
	LEFT JOIN pembelian ON pembayaran.id_pembelian=pembelian.id_pembelian
	WHERE pembelian.id_pembelian='$id_pembelian'");
$detbay = $ambil->fetch_assoc();

// echo "<pre>";
// print_r ($detbay);
// echo "</pre>";

// jika belum ada data pembayaran
if (empty($detbay)) 
{
	echo "<script>alert('belum ada data pembayaran')</script>";
	echo "<script>location='riwayat.php';</script>";
	exit();
}

// jika data pelanggan yang bayar tidak sesuai dengan yang login
// echo "<pre>";
// print_r($_SESSION);
// echo "</pre>";
if ($_SESSION["pelanggan"]['id_pelanggan']!==$detbay["id_pelanggan"]) 
{
	echo "<script>alert('anda tidak berhak melihat pembayaran orang lain')</script>";
	echo "<script>location='riwayat.php';</script>";
	exit();
}
?>
	<div class="container">
		<h3>Lihat Pembayaran</h3>
		<div class="row">
			<div class="col-md-6">
				<table class="table">
					<tr>
						<th>Nama</th>
						<th><?php echo $detbay["nama"]?></th>
					</tr>
					<tr>
						<th>Bank</th>
						<th><?php echo $detbay["bank"]?></th>
					</tr>
					<tr>
						<th>Tanggal</th>
						<th><?php echo $detbay["tanggal"]?></th>
					</tr>
					<tr>
						<th>Jumlah</th>
						<th>Rp. <?php echo number_format($detbay["jumlah"])?></th>
					</tr>
				</table>
			</div>
			<div class="col-md-6">
				<img src="bukti_pembayaran/<?php echo $detbay["bukti"] ?>" alt="" class="img-respponsive">
			</div>
		</div>
	</div>