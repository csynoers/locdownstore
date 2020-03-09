	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Daftar Pelanggan</h3>
					</div>
					<div class="panel-body">
						<form method="post">
							<hr>
							<div class="row">
								<div class="form-group col-md-6">
									<label >Nama</label>
									<input type="text" class="form-control" name="nama" placeholder="John Dhoe" required="">
								</div>
								<div class="form-group col-md-6">
									<label >Email</label>
									<input type="email" class="form-control" name="email" placeholder="john@gmail.com" required="">
								</div>
								<div class="form-group col-md-6">
									<label >Password</label>
									<input type="text" class="form-control" name="password" placeholder="********" required="">
								</div>
								<div class="form-group col-md-6">
									<label >Telp/HP</label>
									<input type="telp" class="form-control" name="telepon" placeholder="081234567890" required="">
								</div>
								<div class="form-group col-md-5">
									<label >Provinsi</label>
									<select class="form-control" name="provinsi" id="" required="">
										<option value="" selected disabled> -- Pilih Provinsi --</option>
									</select>
								</div>
								<div class="form-group col-md-5">
									<label >Kota/Kabupaten</label>
									<select class="form-control" name="kota" id="">
										<option value="" selected disabled> -- Pilih provinsi terlebih dahulu -- </option>
									</select>
								</div>
								<div class="form-group col-md-2">
									<label >Kode POS</label>
									<input type="text" class="form-control" name="kode_pos" placeholder="Kode pos" required="">
								</div>
								<div class="form-group col-md-12">
									<label >Alamat</label>
									<textarea class="form-control" name="alamat" placeholder="Nama gedung, jalan dan lainnya ..." required=""></textarea>
								</div>
							</div>
							<hr>
							<button class="btn btn-block btn-primary" name="daftar">Daftar</button>
						</form>
						<?php
						// jika ada tombol daftar(ditekan tombol daftar)
						if (isset($_POST["nama"]))
						{
							// mengambil isian nama,email,password,alamat,telepon
							$nama = $_POST["nama"];
							$email = $_POST["email"];
							$alamat = $_POST["alamat"];
							$password = $_POST["password"];
							$telepon = $_POST["telepon"];

							// cek apakah email sudah digunakan
							$ambil = $koneksi->query("SELECT * FROM pelanggan
								WHERE email_pelanggan='$email'");
							$yangcocok = $ambil->num_rows;
							if ($yangcocok==1) 
							{
								echo "<script>alert('pendaftaran gagal, email sudah digunakan');</script>";
								echo "<script>location='daftar.php';</script>";
							}
							else
							{
								// query insert ke tabel pelanggan
								$koneksi->query("INSERT INTO pelanggan
									(email_pelanggan,password_pelanggan,nama_pelanggan,
									telepon_pelanggan,alamat_pelanggan)
									VALUES('$email','$password','$nama','$telepon','$alamat')");

								echo "<script>alert('pendaftaran sukses, silahkan login');</script>";
								echo "<script>location='login.php';</script>";
							}
						}
						?>
					</div>
				</div>
			</div>
		</div>
	</div>