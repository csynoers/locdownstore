<?php
// jika tidak ada session pelanggan (belum login)
if (!isset($_SESSION["pelanggan"]) OR empty($_SESSION["pelanggan"])) 
{
	echo "<script>alert('silahkan login');</script>";
	echo "<script>location='login.php';</script>";
	exit();
}
print_r($_SESSION);
?>
<section class="riwayat wrap-content">
	<div class="container">
		<h3>Riwayat Belanja <?php echo $_SESSION["pelanggan"]->nama_pelanggan ?></h3>

		<table class="table table-bordered">
			<thead>
				<tr>
					<th>No</th>
					<th>Tanggal</th>
					<th>Status</th>
					<th>Total</th>
					<th>Opsi</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$nomor=1;
				// mendapatkan id_pelanggan yang login dari session
				$id_pelanggan = $_SESSION["pelanggan"]->id_pelanggan;

				$db->query = ("SELECT * FROM pembelian WHERE id_pelanggan='$id_pelanggan'");
				foreach ($db->query() as $key => $value) {
					// echo json_encode($value);
					$value->status_mod = strtoupper(str_replace('_',' ',$value->status_pembayaran));

					if ( $value->status_pesanan ) {
						$value->status_mod = strtoupper(str_replace('_',' ',$value->status_pesanan));
					}

					// if ( $value->metode_pembayaran ) {
					// 	$value->status_mod .= "<br><small><small>{$value->metode_pembayaran}</small></small> " ;
					// }
					?>
				<tr>
					<td><?php echo $nomor; ?></td>
					<td><?= $value->tanggal_pembelian ?></td>
					<td>
						<?= $value->status_mod ?>
							<br>
							<?php if (!empty($pecah['resi_pengiriman'])): ?>
								Resi : <?php echo $pecah['resi_pengiriman']; ?>
							<?php endif ?>
						</td>
					<td>Rp. <?php echo number_format($value->total_pembelian) ?></td>
					<td>
						<a href="index.php?page=nota&id=<?php echo $value->id_pembelian ?>" class="btn btn-info">Nota</a>
						<?php
							if ( ($value->status_pembayaran=='belum_dibayar') && empty($value->metode_pembayaran) ) {
								echo "<a href='{$value->invoice_url}' class='btn btn-success'>Bayar Sekarang</a>";
							}
						?>
					</td>
				</tr>
				<?php $nomor++; ?>
			<?php } ?>
			</tbody>
		</table>
	</div>
</section>