<?php
session_start();
include 'koneksi.php';
?>
<!DOCTYPE html>
<html>
<head>
		<title>Login Pelanggan</title>
		<link rel="stylesheet" type="text/css" href="admin/assets/css/bootstrap.css">
		<link rel="stylesheet" href="admin/assets/css/font-awesome.css">
	</head>
	<?php include'header.php'; ?>
	<body>


<!-- navbar -->
<?php include 'menu.php'; ?>

	<div class="container">
		<div class="row">
			<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-tittle">Login Pelanggan</h3>
				</div>
				<div class="panel-body">
					<form method="post">
						<div class="form-group">
							<label>Email</label>
							<input type="email" class="form-control" name="email">
						</div>
						<div class="form-group">
							<label>Password</label>
							<input type="password" class="form-control" name="password">
						</div>
						<button class="btn btn-primary" name="login">Login</button> Anda Belum memiliki akun ? <br>
						<li><a href="daftar.php">Daftar Di sini !</a></li> 
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
			echo "<script>location='checkout.php';</script>";
		}
		else
		{
			echo "<script>location='riwayat.php';</script>";
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





</body>
</html>