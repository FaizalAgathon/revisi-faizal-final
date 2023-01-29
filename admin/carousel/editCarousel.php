<?php 

require '../../koneksi.php';

$idCarousel = $_POST['idCarousel'];
$namaCarousel = $_FILES['gambarCarousel']['name'];
$ukuranCarousel = $_FILES['gambarCarousel']['size'];
$extCarousel = explode('.', $namaCarousel);
$extCarousel = array_pop($extCarousel);

$rand = rand(1000,9999);

if ( $ukuranCarousel <= 5000000 ){

  $carousel = $rand . '.' . $extCarousel;
  move_uploaded_file( $_FILES['gambarCarousel']['tmp_name'], '../../assets/carousel/' . $carousel);
  
  mysqli_query($conn, "UPDATE carousel SET
  namaCarousel = '$carousel' WHERE idCarousel = $idCarousel");

  header("Location: index.php");

} else {
  header("Location: index.php?UCF");
}