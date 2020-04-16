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
									<input type="password" class="form-control" name="password" placeholder="********" required="">
								</div>
								<div class="form-group col-md-6">
									<label >Telp/HP</label>
									<input type="telp" class="form-control" name="telepon" placeholder="081234567890" required="">
								</div>
								<div class="form-group col-md-5">
									<label >Provinsi</label>
									<select class="form-control" name="provinsi" id="" required="">
										<option value="" selected disabled> -- Pilih Provinsi --</option>
										<?php
											foreach (json_decode($rajaongkir->province())->rajaongkir->results as $key => $value) {
												echo "<option value='{$value->province_id}'>{$value->province}</option>";
											}
										?>
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
									<textarea class="form-control" name="alamat" placeholder="Nama gedung, jalan, desa, kecamatan dan lainnya ..." required=""></textarea>
								</div>
							</div>
							<hr>
							<button class="btn btn-block btn-primary" name="daftar">Daftar</button>
							<hr>
							<p class="text-center">
								Sudah memiliki akun ? 
								<a href="index.php?page=login">Login disini !</a></li> 
							</p>
						</form>
						<?php
						// jika ada tombol daftar(ditekan tombol daftar)
						if (isset($_POST["nama"]))
						{
							// mengambil isian nama,email,password,alamat,telepon,provinsi,kota dan kode_pos
							$nama 		= str_replace("'","\'",strip_tags($_POST["nama"]));
							$email 		= $_POST["email"];
							$password 	= $_POST["password"];
							$telepon 	= $_POST["telepon"];
							$provinsi 	= $_POST["provinsi"];
							$kota 		= $_POST["kota"];
							$kode_pos 	= $_POST["kode_pos"];
							$alamat 	= str_replace("'","\'",strip_tags($_POST["alamat"]));

							// cek apakah email sudah digunakan
							$db->query 	= ("SELECT * FROM pelanggan WHERE email_pelanggan='$email'");
							$cek_rows	= count($db->query());

							if ( $cek_rows > 0) 
							{
								# jika sudah digunakan jalankan skrip ini
								echo "<script>alert('pendaftaran gagal, email sudah digunakan')</script>";
							}
							else
							{
								# jika email belum digunakan jalankan skrip dibawah ini
								$db->query = ("
									INSERT INTO pelanggan
										(email_pelanggan,password_pelanggan,nama_pelanggan,telepon_pelanggan,block,konfirmasi_email)
									VALUES
										('$email','$password','$nama','$telepon','ya','tidak')
								");

								# proses store insert data pada tabel pelanggan
								$insert = $db->query_exec();
								
								# get last insert id
								$id_pelanggan = $db->lastInsertId();
								
								# query store insert data pada tabel alamat
								$db->query = "
									INSERT INTO alamat
										(id_pelanggan,provinsi,kota,kode_pos,alamat_lengkap,status_alamat)
									VALUES
										('{$id_pelanggan}','{$provinsi}','{$kota}','{$kode_pos}','$alamat','aktif')
								";
								$insert = $db->query_exec();

								/* ==================== START :: SEND EMAIL ==================== */
								$data = [];
								$data['mail']['email'] = $email;
								$data['mail']['link_konfirmasi'] = 'https://locdownstore.com/index.php?konfirmasi_email=' . base64_encode($email);
								$data['mail']['subjek'] = "Konfirmasi Email";
								$data['mail']['pesan'] = "
									<html>
										<head>
											<title>TOKO LOCDOWN STORE</title>
										</head>
										<body style='background: #eee;'>
											<div style='padding: 50px;'>
												<div style='background:#007bff;padding: 1px 0px;text-align: center;color: white;border-radius: 15px 15px 0px 0px;'>
													<h1>TOKO LOCDOWN STORE</h1>
												</div>
												<div style='background: #fff;padding: 30px 30px;'>
													<h2 style='margin-top: 0px'>Hi {$nama},</h2>
													<p>Selamat pendaftaran anda telah berhasil</p>
													<p>Username kamu adalah : <a href='mailto:{$email}' target='_blank'>{$email}</a></p>
													<a href='{$data['mail']['link_konfirmasi']}' target='_blank' style='background-color: #39a300;color: #fff;padding: 10px 12px;text-decoration: none;'>Klik disini untuk melakukan konfirmasi email</a>
												</div>
												<div style='background:#007bff;padding: 1px 0px;text-align: center;color: white;border-radius: 0px 0px 15px 15px;'>
													<p><a href='https://locdownstore.com' target='_blank' style='color: wheat;font-weight: bold;'>TOKO LOCDOWN STORE © ".date('Y')."</a><br> - Distro Baju Terlengkap Di Prambanan -</p>
												</div>
											</div>
										</body>
									</html>	
								";
						
								// Always set content-type when sending HTML email
								$data['mail']['dari'] = "MIME-Version: 1.0" . "\r\n";
								$data['mail']['dari'] .= "Content-type:text/html;charset=UTF-8" . "\r\n";
						
								// More headers
								$data['mail']['dari'] .= 'From: <support@locdownstore.com>' . "\r\n";
								mail($data['mail']['email'],$data['mail']['subjek'],$data['mail']['pesan'],$data['mail']['dari']);
								/* ==================== END :: SEND EMAIL ==================== */


								echo "<script>alert('pendaftaran sukses, silahkan konfirmasi email terlebih dahulu untuk mengaktifkan akun anda, jika tidak ada di menu kotak masuk silahkan cek di menu spam ');</script>";
								echo "<script>location='index.php'</script>";
							}
						}
						?>
					</div>
				</div>
			</div>
		</div>
	</div>