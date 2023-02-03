<?php

require '../../koneksi.php';

$idBuku = $_POST['idBuku'];

$namaBuku = $_POST['judul'];
$penulisBuku = $_POST['penulis'];
$penerbitBuku = $_POST['penerbit'];
$deskripsiBuku = $_POST['deskripsi'];
$jumlahBuku = $_POST['jumlah'];
$namaFile = $_FILES['gambar']['name'];
$ukuranFile = $_FILES['gambar']['size'];

$rand = rand(1000, 9999);
$namaFile = explode('.',$namaFile);
$namaFile = array_pop($namaFile);
$gambarBuku = $rand . '.' . $namaFile;
// $gambarBukuKosong = $rand . '-' . 'ppNoImg.png';
$batasUkuranGambar = 5000000; // KB

if ($ukuranFile == NULL) {

  $editBuku = mysqli_query($conn, "UPDATE buku SET 
    nama = '$namaBuku',
    deskripsi = '$deskripsiBuku',
    penulis = '$penulisBuku',
    penerbit = '$penerbitBuku',
    gambar = 'ppNoImg.png',
    jumlah = '$jumlahBuku'
    WHERE id = $idBuku");

  header("Location: index.php");
} else if ($ukuranFile <= $batasUkuranGambar) {

  move_uploaded_file($_FILES['gambar']['tmp_name'], '../../assets/images/' . $gambarBuku);

  $editBuku = mysqli_query($conn, "UPDATE buku SET 
    nama = '$namaBuku',
    deskripsi = '$deskripsiBuku',
    penulis = '$penulisBuku',
    penerbit = '$penerbitBuku',
    gambar = '$gambarBuku'
    WHERE id = $idBuku");

  header("Location: index.php");
} else {
  header("Location: index.php");
}
