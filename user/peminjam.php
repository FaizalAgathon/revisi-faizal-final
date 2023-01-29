<?php 

require '../koneksi.php';

// SECTION pagination Peminjaman
$dataPerhalaman = 5;
$jumlahData =  count(query("SELECT * FROM
                            siswa s INNER JOIN
                            kelas k ON s.idKelas = k.idKelas INNER JOIN
                            peminjaman p ON s.idSiswa = p.idSiswa INNER JOIN
                            buku b ON s.idSiswa = p.idSiswa AND p.idBuku = b.id
                            WHERE s.namaSiswa = '{$_SESSION['nama']}'"));

$jumlahHalaman = ceil($jumlahData / $dataPerhalaman);

$halamanAktif = isset( $_GET['halamanUser']) ? $_GET['halamanUser'] : 1;

$awalData = ($dataPerhalaman * $halamanAktif) - $dataPerhalaman;

// !SECTION pagination Peminjaman

$peminjaman = query("SELECT * FROM
                      siswa s INNER JOIN
                      kelas k ON s.idKelas = k.idKelas INNER JOIN
                      peminjaman p ON s.idSiswa = p.idSiswa INNER JOIN
                      buku b ON s.idSiswa = p.idSiswa AND p.idBuku = b.id
                      WHERE s.namaSiswa = '{$_SESSION['nama']}'
                      LIMIT $awalData, $dataPerhalaman");

$batasPengembalian = 7;

// SECTION Insert buku
if ( isset($_POST['pinjam']) ){

  $idBuku = $_POST['idBuku'];
  
  $namaPeminjam = $_POST['nama'];
  $kelasPeminjam = $_POST['kelas'];
  $kontakPeminjam = $_POST['kontak'];
  
  $idKelas = query("SELECT idKelas FROM kelas WHERE namaKelas = '$kelasPeminjam'")[0];
  $idSiswa = query("SELECT idSiswa FROM siswa 
    WHERE idKelas = $idKelas[idKelas] AND 
    namaSiswa = '$namaPeminjam' AND 
    kontakSiswa = '$kontakPeminjam'")[0];

  $waktuRT = date('Y-m-d');
  
  $tambahPeminjaman = mysqli_query($conn,"INSERT INTO peminjaman 
    VALUES (NULL,'$idSiswa[idSiswa]','$idBuku','$waktuRT')");
  
  if ( $tambahPeminjaman ){
    $buku = query("SELECT * FROM buku WHERE id = $idBuku")[0];
    $jumlahBuku = $buku['jumlah'] - 1;
    mysqli_query($conn,"UPDATE buku SET jumlah = $jumlahBuku
      WHERE id = $idBuku");
    mysqli_query($conn,"UPDATE buku SET jumlah_dipinjam = $buku[jumlah_dipinjam] + 1
      WHERE id = $idBuku");
  }

}

// !SECTION Insert buku



?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Peminjam</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="css_user/stylePeminjam.css">
  </head>
  <body>

    <?php include 'header-menu-user.php'; ?>

    <!-- SECTION Alert Feedback -->

  <?php if( isset( $_GET['feedback'] ) && $_GET['feedback'] == "default" ) : ?>
      <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Terima Kasih!</strong> Telah Membantu Perkembangan Website Ini.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
  <?php endif ; ?>

  <?php if( isset( $_GET['feedback'] ) && $_GET['feedback'] == "eror" ) : ?>
      <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Larangan!</strong> Menggunakan kata kata kasar saat memberikan feedback.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
  <?php endif ; ?>

  <!-- !SECTION Alert Feedback -->

    <!-- AWAL TABEL -->
    <div class="container mt-4">
    
        <br>
        <h5 class="fw-bold text-white text-center">Buku yang dipinjam :</h5>
                        <!-- SECTION pagination peminjaman-->
        <div aria-label="Page navigation example" > 
            <ul class="pagination">
                <?php if ( $halamanAktif > 1 ) : ?>
                    <li class="page-item"><a class="page-link" href="?halamanUser=<?=$halamanAktif - 1 ?>">Previous</a></li>
                <?php endif ; ?>

                <?php for( $i=1; $i<=$jumlahHalaman; $i++) : ?>
                    <?php if ( $i == $halamanAktif ) : ?>
                        <li class="page-item active"><a class="page-link" href="?halamanUser=<?= $i ?>"><?= $i ?></a></li>
                    <?php else : ?>
                        <li class="page-item"><a class="page-link" href="?halamanUser=<?= $i ?>"><?= $i ?></a></li>
                    <?php endif ; ?>
                <?php endfor ; ?>
                
                <?php if ( $halamanAktif < $jumlahHalaman ) : ?>
                    <li class="page-item"><a class="page-link" href="?halamanUser=<?=$halamanAktif + 1 ?>">Next</a></li>
                <?php endif ; ?>
            </ul>
        </div>
                <!-- !SECTION pagination peminjaman-->

        <table class="table table-light table-striped">
            <tr class="text-center">
                <th>No</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Kontak</th>
                <th>Buku</th>
                <th>Waktu</th>
                <th>Batas Waktu</th>
                <th>Aksi</th>
            </tr>
            <?php $i = 1; ?>
            <?php foreach ($peminjaman as $data) : ?>
            <tr class="text-center">
                <td><?= $i; ?></td>
                <td><?= $data["namaSiswa"]; ?></td>
                <td><?= strtoupper($data["namaKelas"]); ?></td>
                <td>
                    <a href="" class="kontak">
                      <?= $data['kontakSiswa'] ?>
                    </a>
                </td>
                <td><?= $data["nama"]; ?></td>
                <td><?= $data["waktuPeminjaman"]; ?></td>
                <td><?= bataswaktu(strtotime($data["waktuPeminjaman"]), $batasPengembalian); ?></td>
                <td>
                    <a href="../admin/kembalikan_data_pengembalian.php?id=<?= $data['idPeminjaman']; ?>&waktupeminjaman=<?= $data['waktuPeminjaman']; ?>&param=user" onclick="return confirm('Yakin ingin mengebalikan buku?')">
                        <img src="../icon/left-arrow.png" width="30rem" alt="">
                    </a>
                </td>
            </tr>
            <?php $i++; ?>
            <?php endforeach; ?>

        <?php if ($i == 1) : ?>
          <tr>
            <td colspan="8" align="center"> Tidak ada Yang Meminjam buku</td>
          </tr>
        <?php endif; ?>
        </table>
    </div>
      <!-- AKHIR TABEL -->
      <!-- AWAL FOOTER -->
    <div class="bg-dark mt-3 p-1 pt-2 w-100" id="footer" style="margin-bottom: -2rem;">
    <div class="row w-100">
  <div class="col ms-2 mt-3">
    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d15849.134770711997!2d108.5367314!3d-6.735204!3m2!
                1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x51cf481547b4b319!2sSMK%20Negeri%201%20Cirebon!5e0!3m2!1sid!2sid!4v1674230224751!5m2!1sid!2sid" width="400" height="350" style="border: 0;" allowfullscreen="" class="rounded-4" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
  </div>
  <div class="col mt-3 border rounded-4" style="box-shadow: 3px 3px 5px rgb(201, 201, 201);">
    <form action="" method="post">
      <div class="p-2">
        <p class="text-white mb-0">Kritik Dan Saran :</p><br>
        <input type="text" name="param" value="peminjaman" hidden>
        <textarea name="komen" class="form-control w-75 bg-light" aria-label="With textarea"></textarea>
        <button name="feedback" type="submit" class="mt-2 btn btn-light py-0">
          <img src="../icon/send.png" width="20rem" alt="">
          Kirim
        </button>
      </div>
    </form>

  </div>
</div>
<footer class="main-footer mt-5" style="padding-top: 10px;">
  <div class="text-center">
    <a href="http://smkn1-cirebon.sch.id" class="txt2 hov1 text-decoration-none text-white" target="_blank">
      © <?= date('Y') ?> SMK Negeri 1 Cirebon
    </a>
  </div>
</footer>

<p class="text-center text-white"><small>- Support By XI RPL 2 -</small></p>
    </div>
    <!-- AKHIR FOOTER -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  </body>
</html>