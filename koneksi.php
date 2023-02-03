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


    // SECTION search pada peminjaman admin
    function cari( $keyword, $awalData2, $dataPerhalaman2 ){

        $query = "SELECT * FROM
                    histori h INNER JOIN
                    siswa s ON s.idSiswa = h.idSiswa INNER JOIN
                    kelas k ON s.idkelas = k.idKelas INNER JOIN
                    buku b ON h.idBuku = b.id AND s.idSiswa = h.idSiswa
                    WHERE s.namaSiswa LIKE '%$keyword%' OR 
                    k.namaKelas LIKE '%$keyword%' OR
                    b.nama LIKE '%$keyword%'
                    LIMIT $awalData2, $dataPerhalaman2";

        return query($query);
    }
    // !SECTION search pada peminjaman admin


// SECTION Sort by pada peminjaman admin

    function urutan( $waktu, $urutan, $awalData2, $dataPerhalaman2 ){

        $query = "SELECT *
                    FROM
                    histori h INNER JOIN
                    siswa s ON s.idSiswa = h.idSiswa INNER JOIN
                    kelas k ON s.idkelas = k.idKelas INNER JOIN
                    buku b ON h.idBuku = b.id AND s.idSiswa = h.idSiswa
                    ORDER BY $waktu $urutan LIMIT $awalData2, $dataPerhalaman2 ";

        return query($query) ;
    }

// !SECTION Sort by pada peminjaman admin

// SECTION tambah data feedback

if(isset($_POST['feedback'])){
    $param = true;
  
    $kataKasar = ["ke", "anjing", "titit", "bangsat", "goblok", "goblog", "memek", "kontol", "tolol", "meki", "jembut", "kirik", "tt", "oppai", "silit", "fuck", "shit", "bitch", "niga", "nigga", "ass", "peler" ,"bajingan", "jancuk", "jancok", "monyet"];
    $jumlahKata = count($kataKasar);
    $komen = strtolower($_POST['komen']);
  
    for( $i=0; $i<$jumlahKata; $i++ ){
        if( preg_match( "/$kataKasar[$i]/", $komen ) ){
            if ( $_POST['param'] == "home") {
                header("Location: index.php?feedback=eror");
                $param = false;
                exit;
            }
  
            if ( $_POST['param'] == "peminjaman") {
                header("Location: peminjam.php?feedback=eror");
                $param = false;
                exit;
  
            }
            
        }
    }
    $waktuKomen = date("Y-m-d");
  
    $qry = sprintf("INSERT INTO feedback(id, isi, tgl) VALUES (NULL, '%s', '$waktuKomen') ", $komen);
  
    if ( $_POST['param'] == "home" && $param) {
        mysqli_query($conn, $qry);
        header("Location: index.php?feedback=default");
    } 
  
    if ( $_POST['param'] == "peminjaman" && $param) {
        mysqli_query($conn, $qry);
        header("Location: peminjam.php?feedback=default");
    }
  
  
  }

// !SECTION tambah data feedback

?>

