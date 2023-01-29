<?php
    require '../koneksi.php';
    
    //Menentukan baris pada table
    $idpengembali = $_GET['id'];
    $waktuPeminjaman = $_GET['waktupeminjaman'];
    $waktuPengembalian = date("Y-m-d");

// Mengambil Data
$pengembalian = query("SELECT 
                      -- s.idSiswa, s.namaSiswa, k.namaKelas, s.kontakSiswa, b.nama, p.waktuPeminjaman
                      *, b.id as idBuku
                      FROM
                      siswa s INNER JOIN
                      kelas k ON s.idKelas = k.idKelas INNER JOIN
                      peminjaman p ON s.idSiswa = p.idSiswa INNER JOIN
                      buku b ON s.idSiswa = p.idSiswa 
                      AND p.idBuku = b.id WHERE idPeminjaman = $idpengembali")[0];

    $buku = query("SELECT jumlah as jmlBuku, id as idBuku FROM buku WHERE id = $pengembalian[idBuku]")[0];

    // Menambah buku yg sdh dikembalikan
    mysqli_query($conn, "UPDATE buku 
      SET jumlah = $buku[jmlBuku] + 1
      WHERE id = $buku[idBuku]");

    mysqli_query($conn,"INSERT INTO histori VALUES ( '', '$pengembalian[idSiswa]', '$pengembalian[idBuku]', '$waktuPeminjaman', '$waktuPengembalian')" );

    mysqli_query($conn,"DELETE FROM peminjaman WHERE idPeminjaman = $idpengembali");

    if( $_GET['param'] == "user" ){
    header("Location: ../user/peminjam.php");
    }

    if( $_GET['param'] == "admin" ){
    header("Location: peminjam.php");
    }
    

?>