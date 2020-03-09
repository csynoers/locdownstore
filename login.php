	<div class="container">
		<div class="rowXXX">
			<div class="col-md-6 col-md-offset-3">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-tittle">Login Pelanggan</h3>
				</div>
				<div class="panel-body">
					<form method="post">
						<div class="form-group">
							<label>Email</label>
							<input type="email" class="form-control" name="email" placeholder="email@gmail.com" required="" autocomplete="off">
						</div>
						<div class="form-group">
							<label>Password</label>
							<input type="password" class="form-control" name="password" placeholder="********" required="" autocomplete="off">
						</div>
						<button class="btn btn-block btn-primary" name="login">Login</button>
						<hr>
						<p class="text-center">
							Anda Belum memiliki akun ? 
							<a href="index.php?page=daftar">Daftar Di sini !</a></li> 
						</p>
				</div>
			</div>	

		</div>
	</div>	
		</div>

<?php
// jika ada tombol login(tombol login ditekan)
if (isset($_POST["login"]))
{

	$email = $_POST["email"];
	$password = $_POST["password"];
	//lakukan kuery ngecek akun ditabel pelanggan di database
	$ambil = $koneksi->query("SELECT * FROM pelanggan 
		WHERE email_pelanggan='$email' AND password_pelanggan='$password'");

	//ngitung akun yang terambil
	$akunyangcocok = $ambil->num_rows;

	//jika 1 akun yang cocok, maka diloginkan
	if ($akunyangcocok==1) 
	{
		//anda sukses login
		//mendapatkan akun dalam bentuk array
		$akun = $ambil->fetch_assoc();
		//simpan di session pelanggan
		$_SESSION["pelanggan"] = $akun;
		echo "<script>alert('anda sukses login');</script>";

		// jika sudah belanja
		if (isset($_SESSION["keranjang"]) OR !empty($_SESSION["keranjang"])) 
		{
			echo "<script>location='index.php?page=checkout';</script>";
		}
		else
		{
			echo "<script>location='index.php?page=riwayat-belanja';</script>";
		}	
	}
	else
	{
		//anda gagal login
		echo "<script>alert('anda gagal login, periksa akun anda');</script>";
		echo "<script>location='login.php';</script>";
	}
}

?>