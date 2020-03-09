<?php
session_start();

// menghancurkan $_SESSION["pelanggan"]
session_destroy();

die();
echo "<script>alert('anda telah logout');</script>";
echo "<script>location='index.php';</script>";

?>