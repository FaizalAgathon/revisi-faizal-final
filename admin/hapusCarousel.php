<?php 

require '../koneksi.php';

$idCarousel = $_POST['idCarousel'];

mysqli_query($conn, "DELETE FROM carousel WHERE idCarousel = $idCarousel");

header("Location: admin.php");