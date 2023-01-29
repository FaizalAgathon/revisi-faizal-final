<?php

session_start();

    // Koneksi ke Database
    $conn = mysqli_connect("localhost", "root", "", "perpus_padudung");

    //Data Pengembalian
    function query($query){
        global $conn;
        $result = mysqli_query($conn, $query);
        $rows = [];
        while( $row = mysqli_fetch_assoc($result) ){
            $rows[] = $row;
        }
        return $rows;
    }

    //Batas Waktu Pengembalian
    function bataswaktu($ubah, $batas){
        $bataswaktu = date("Y-m-j", $ubah +60*60*24*$batas);
        return $bataswaktu;
    }

    function cari($keyword){
        
        $query = "SELECT *
                    FROM
                    histori h INNER JOIN
                    siswa s ON s.idSiswa = h.idSiswa INNER JOIN
                    kelas k ON s.idkelas = k.idKelas INNER JOIN
                    buku b ON h.idBuku = b.id AND s.idSiswa = h.idSiswa
                    WHERE s.namaSiswa LIKE '%$keyword%' OR 
                    k.namaKelas LIKE '%$keyword%' OR
                    b.nama LIKE '%$keyword%'";

        return query($query);
    }

    function urutan( $waktu, $urutan, $awalData2, $dataPerhalaman2 ){

        $query = "SELECT *
                    FROM
                    histori h INNER JOIN
                    siswa s ON s.idSiswa = h.idSiswa INNER JOIN
                    kelas k ON s.idkelas = k.idKelas INNER JOIN
                    buku b ON h.idBuku = b.id AND s.idSiswa = h.idSiswa
                    ORDER BY $waktu $urutan LIMIT $awalData2, $dataPerhalaman2 ";

        return query($query);
    }

?>