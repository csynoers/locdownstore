<h2>Data Produk</h2>
<hr>
<a href ="index.php?halaman=tambahproduk" class="btn btn-primary">Tambah Produk</a>
<hr>
<table id="myTable" class='table'>
	<thead>
		<tr>
			<th>No</th>
			<th>Foto</th>
			<th>Nama</th>
			<th>Harga</th>
			<th>Stok</th>
			<th>Aksi</th>
		</tr>
	</thead>
	<tbody>
	<?php $nomor=1; ?>
	<?php $ambil=$koneksi->query("SELECT * FROM produk ORDER BY id_produk DESC"); ?>
	<?php while($pecah = $ambil->fetch_assoc()){?>
		<tr>
			<td><?php echo $nomor; ?></td>
			<td>
				<img src="../gambar/produk/<?php echo $pecah['foto_produk']; ?>" height="50px">
			</td>
			<td><?php echo $pecah['nama_produk'];?></td>
			<td><?php echo $pecah['harga_produk'];?></td>
			<td><?php echo $pecah['stok_produk'];?></td>
			<td>
				<a href="index.php?halaman=ubahproduk&id=<?php echo $pecah['id_produk']; ?>" class="btn btn-warning">Ubah</a>
				<a href="index.php?halaman=hapusproduk&id=<?php echo $pecah['id_produk']; ?>" class="btn-danger btn">Hapus</a>
			</td>
		</tr>
		<?php $nomor++; ?>
		<?php } ?>
	</tbody>
	<tfoot>
		<tr>
			<th>No</th>
			<th>Foto</th>
			<th>Nama</th>
			<th>Harga</th>
			<th>Stok</th>
			<th>Aksi</th>
		</tr>
	</tfoot>
</table>