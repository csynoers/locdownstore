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
							1. Silahkan pilih produk yang akan anda beli.<br>
							2. Klik tombol beli atau klik tombol detail untuk mengetahui detail produk yang akan anda beli.<br>
							3. Silahkan klik tombol beli dan otomatis anda akan diarahkan ke karanjang belanja.