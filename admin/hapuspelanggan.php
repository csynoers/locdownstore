<?php
include 'koneksi.php'
$ambil = $koneksi->query("SELECT * FROM pelanggan WHERE id_pelanggan='$_GET[id]'");
$pecah = $ambil->fetch_assoc()
$pelanggan = $pecah['pelanggan'];

$koneksi->query("DELETE FROM pelanggan WHERE id_pelanggan='$_GET[id]'");

echo "<script>alert('pelanggan terhapus');</script>";
echo "<script>location='index.php?halaman=pelanggan';</script>";

?>