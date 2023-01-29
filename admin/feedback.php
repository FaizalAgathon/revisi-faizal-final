
<?php 

require '../koneksi.php';

// SECTION cek apakah sudah login belom
if (!(isset($_SESSION['loginAdmin'])) ) {
    // redirect (memindahkan user nya ke page lain)
    header("Location: ../login-daftar/login_admin.php");
    exit;
  
  }

// !SECTION cek apakah sudah login belom

// SECTION pagination feedback
$dataPerhalaman = 5;
$jumlahData =  count(query("SELECT * FROM feedback"));

$jumlahHalaman = ceil($jumlahData / $dataPerhalaman);

$halamanAktif = isset( $_GET['halamanFeedback']) ? $_GET['halamanFeedback'] : 1;

$awalData = ($dataPerhalaman * $halamanAktif) - $dataPerhalaman;

// !SECTION pagination feedback


// SECTION Tampilkan unek unek

    $dataKomen = query("SELECT * FROM feedback LIMIT $awalData, $dataPerhalaman");

// !SECTION Tampilkan unek unek


?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Feedback</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/feedback.css">
  </head>
  <body>

    <?php include 'header-menu-admin.php'; ?>

    <!-- AWAL FEEDBACK -->
    <div class="container mt-4">
        <br>
        <h5 class="fw-bold text-white text-center">Daftar Saran & Kritik :</h5>
        <!-- SECTION pagination peminjaman-->
        <div aria-label="Page navigation example" > 
            <ul class="pagination">
                <?php if ( $halamanAktif > 1 ) : ?>
                    <li class="page-item"><a class="page-link" href="?halamanFeedback=<?=$halamanAktif - 1 ?>">Previous</a></li>
                <?php endif ; ?>

                <?php for( $i=1; $i<=$jumlahHalaman; $i++) : ?>
                    <?php if ( $i == $halamanAktif ) : ?>
                        <li class="page-item active"><a class="page-link" href="?halamanFeedback=<?= $i ?>"><?= $i ?></a></li>
                    <?php else : ?>
                        <li class="page-item"><a class="page-link" href="?halamanFeedback=<?= $i ?>"><?= $i ?></a></li>
                    <?php endif ; ?>
                <?php endfor ; ?>
                
                <?php if ( $halamanAktif < $jumlahHalaman ) : ?>
                    <li class="page-item"><a class="page-link" href="?halamanFeedback=<?=$halamanAktif + 1 ?>">Next</a></li>
                <?php endif ; ?>
            </ul>
        </div>
        <!-- !SECTION pagination peminjaman-->

        <div class="bg-light p-2 mb-3 rounded rounded-3"
        style="box-shadow: 5px 5px 5px rgb(120, 120, 120);
        height: fit-content;">
        <?php $i=1; ?>
        <?php foreach( $dataKomen as $dtKomen ) : ?>
            <p>
                <?=$i?>.<?= $dtKomen['isi']; ?> <br>
                <div> Tanggal : <?= $dtKomen['tgl']; ?> </div>
            </p>
            <hr>
        <?php $i++; ?>
        <?php endforeach ; ?>
        </div>
    </div>
    <!-- AKHIR FEEDBACK -->
    <!-- AWAL FOOTER -->
    <div class="bg-dark mt-3 p-1 pt-2 w-100" id="footer" style="margin-bottom: -2rem;">
      <?php include 'footerAdmin.php'; ?>
    </div>
    <!-- AKHIR FOOTER -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  </body>
</html>