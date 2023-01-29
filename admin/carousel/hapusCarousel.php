<?php 

require '../../koneksi.php';

$idCarousel = $_POST['idCarousel'];

mysqli_query($conn, "DELETE FROM carousel WHERE idCarousel = $idCarousel");

$carousel = query("SELECT namaCarousel FROM carousel WHERE idCarousel = $idCarousel")[0];
unlink("../../assets/carousel/" . $carousel['namaCarousel']);

header("Location: index.php");