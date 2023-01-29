<?php 

require '../koneksi.php';

$idBuku = $_GET['id'];

$hapusBuku = mysqli_query($conn,"DELETE FROM buku WHERE id = $idBuku");

header("Location: admin.php");

?>