<h2>Tambah Produk</h2>

<form method="post" enctype="multipart/form-data">
	<hr>
	<div class="row">
		<div class="form-group col-sm-6">
			<label>Nama</label>
			<input type="text" class="form-control" name="nama" placeholder="Masukan nama produk disini ..." required="">
		</div>
		<div class="form-group col-sm-6">
			<label>Harga (Rp)</label>
			<input type="number" min="1" class="form-control" name="harga" placeholder="Masukan angka contoh : 123000" required="">
		</div>
		<div class="form-group col-sm-6">
			<label>Berat (Gr)</label>
			<input type="number" class="form-control" name="berat" placeholder="Masukan angka contoh : 100" required="">
		</div>
		<div class="form-group col-sm-6">
			<label>Stok</label>
			<input type="number" class="form-control" name="stok" placeholder="Masukan angka contoh : 10" required="">
		</div>
		<div class="form-group col-sm-12">
			<label>Deskripsi</label>
			<textarea class="form-control" name="deskripsi" placeholder="Masukan deskripsi lengkap tentang produk anda disini ..." rows="10"></textarea>
		</div>
		<div class="form-group col-sm-12">
			<label for="">Upload foto produk</label>
			<input type="file" name="foto">
		</div>
	</div>
	<hr>
	<button class="btn btn-primary" name="save">Simpan</button>
</form>
<?php
if (isset($_POST['save']))
{
	# proses rename dan upload file
	$temp = explode(".", $_FILES["foto"]["name"]);
	$newfilename = round(microtime(true)) . '_' . strtolower( str_replace(' ','_',$_FILES["foto"]["name"]) );
	move_uploaded_file($_FILES["foto"]["tmp_name"], "../gambar/produk/" . $newfilename);

	# proses insert ke database
	$db->query = ("
		INSERT INTO produk
			(nama_produk,harga_produk,berat_produk,stok_produk,foto_produk,deskripsi_produk)
		VALUES
			('$_POST[nama]','$_POST[harga]','$_POST[berat]','$_POST[stok]','$newfilename','".str_replace("'","\'",strip_tags($_POST['deskripsi']))."')
	");
	$insert = $db->query_exec();

	# jika proses insert berhasil/tidak maka jalankan alert dan refresh halaman
	if ( $insert ) { # jika berhasil
		echo "<script>alert('Data berhasil')</script>";
		echo "<meta http-equiv='refresh' content='1;url=index.php?halaman=produk'>";

	} else { # jika gagal
		echo "<script>alert('Data gagal disimpan')</script>";

	}
}
?>
