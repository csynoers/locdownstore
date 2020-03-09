<h2>Ubah Produk</h2>
<?php
$ambil=$koneksi->query("SELECT * FROM produk WHERE id_produk='$_GET[id]'");
$pecah=$ambil->fetch_assoc();

?>

<form method="POST" enctype="multipart/form-data">
	<hr>
	<div class="row">
		<div class="form-group col-sm-6">
			<label>Nama Produk</label>
			<input type="text" name="nama" class="form-control" value="<?php echo $pecah['nama_produk'];?>" placeholder="Masukan nama produk disini ..." required="">
		</div>
		<div class="form-group col-sm-6">
			<label>Harga Rp</label>
			<input type="number" class="form-control" name="harga" value="<?php echo $pecah['harga_produk']; ?>" placeholder="Masukan angka contoh : 123000" required="">
		</div>
		<div class="form-group col-sm-6">
			<label>Berat (Gr)</label>
			<input type="number" class="form-control" name="berat" value="<?php echo $pecah['berat_produk']; ?>" placeholder="Masukan angka contoh : 100" required="">
		</div>
		<div class="form-group col-sm-6">
			<label>Stok</label>
			<input type="number" class="form-control" name="stok" value="<?php echo $pecah['stok_produk']; ?>" placeholder="Masukan angka contoh : 10" required="">
		</div>
		<div class="form-group col-sm-12">
			<label for="">Deskripsi</label>
			<textarea name="deskripsi" class="form-control" placeholder="Masukan deskripsi lengkap tentang produk anda disini ..." rows="10"><?php echo $pecah['deskripsi_produk']; ?></textarea>
		</div>
		<div class="form-group col-sm-12">
			<label for="">Foto produk</label>
			<img class="img-responsive" src="../gambar/produk/<?php echo $pecah['foto_produk'] ?>">
		</div>
		<div class="form-group col-sm-6">
			<label>Ganti foto produk</label>
			<input type="file" name="foto" class="form-control">
		</div>
	</div>
	<hr>
	<button class="btn btn-primary" name="ubah">Ubah</button>
</form>

<?php
if (isset($_POST['ubah']))
{
	$namafoto=$_FILES['foto']['name'];
	$lokasifoto=$_FILES['foto']['tmp_name'];

	# cek apakah foto diubah
	if (!empty($lokasifoto))
	{ # jika ada foto

		# sebelum upload foto baru unlink foto lama terlebih dahulu
		unlink("../gambar/produk/{$pecah['foto_produk']}"); 

		# upload foto baru : proses rename dan upload file
		$temp = explode(".", $_FILES["foto"]["name"]);
		$newfilename = round(microtime(true)) . '_' . strtolower( str_replace(' ','_',$_FILES["foto"]["name"]) );
		move_uploaded_file($_FILES["foto"]["tmp_name"], "../gambar/produk/" . $newfilename);

		# query update tabel produk
		$db->query = ("
			UPDATE produk
				SET
					nama_produk='$_POST[nama]',
					harga_produk='$_POST[harga]',
					berat_produk='$_POST[berat]',
					stok_produk='$_POST[stok]',
					foto_produk='$newfilename',
					deskripsi_produk='".str_replace("'","\'",strip_tags($_POST['deskripsi']))."'
			WHERE
				id_produk='$_GET[id]'
		");
	}
	else { # jika tidak ada foto
		# query update tabel produk
		$db->query = ("
			UPDATE produk
				SET
					nama_produk='$_POST[nama]',
					harga_produk='$_POST[harga]',
					berat_produk='$_POST[berat]',
					stok_produk='$_POST[stok]',
					deskripsi_produk='".str_replace("'","\'",strip_tags($_POST['deskripsi']))."'
			WHERE id_produk='$_GET[id]'
		");
	}

	# eksekusi query update
	$insert = $db->query_exec();
	
	# jika proses update berhasil/tidak maka jalankan alert berikut
	if ( $insert ) { # jika berhasil
		echo "<script>alert('Data berhasil diubah')</script>";
		echo "<script>location='index.php?halaman=produk';</script>";

	} else { # jika gagal
		echo "<script>alert('Data gagal diubah')</script>";
		
	}
}
?>