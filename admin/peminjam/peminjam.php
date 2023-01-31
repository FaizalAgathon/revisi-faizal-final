<?php

require '../../koneksi.php';

// cek apakah sudah login belom
if (!(isset($_SESSION['loginAdmin']))) {
  // redirect (memindahkan user nya ke page lain)
  header("Location: ../../login-daftar/login_admin.php");
  exit;
}

// SECTION pagination Peminjaman
$dataPerhalaman = 5;
$jumlahData =  count(query("SELECT * FROM
                            siswa s INNER JOIN
                            kelas k ON s.idKelas = k.idKelas INNER JOIN
                            peminjaman p ON s.idSiswa = p.idSiswa INNER JOIN
                            buku b ON s.idSiswa = p.idSiswa AND p.idBuku = b.id"));

$jumlahHalaman = ceil($jumlahData / $dataPerhalaman);

$halamanAktif = isset($_GET['halamanUser']) ? $_GET['halamanUser'] : 1;

$awalData = ($dataPerhalaman * $halamanAktif) - $dataPerhalaman;


// !SECTION pagination Peminjaman

// SECTION tampilkan data

if (!isset($_GET['urut'])) {
  $_GET['urut'] = "default";
}


if ($_GET['urut'] == "default") {
  $peminjaman = query("SELECT * FROM
                      siswa s INNER JOIN
                      kelas k ON s.idKelas = k.idKelas INNER JOIN
                      peminjaman p ON s.idSiswa = p.idSiswa INNER JOIN
                      buku b ON s.idSiswa = p.idSiswa AND p.idBuku = b.id
                      LIMIT $awalData, $dataPerhalaman");

  if (!isset($pencarian)) {
    $pencarian = "none";
  }

  if (!isset($keyword)) {
    $keyword = "default";
  }
}

// !SECTION tampilkan data

// SECTION cari melalui sort by

if ((isset($_GET['urut']) && $_GET['urut'] == "peminjamanASC") || $_GET['urut'] == "peminjamanASC") {
  if (!isset($keyword)) {
    $keyword = $_GET['urut'];
  }
  if (!isset($pencarian)) {
    $pencarian = "none";
  }
  $peminjaman = urutan("waktuPeminjaman", "ASC", $awalData, $dataPerhalaman, "peminjaman");
}

if ((isset($_GET['urut']) && $_GET['urut'] == "peminjamanDESC") || $_GET['urut'] == "peminjamanDESC") {
  if (!isset($keyword)) {
    $keyword = $_GET['urut'];
  }
  if (!isset($pencarian)) {
    $pencarian = "none";
  }
  $peminjaman = urutan("waktuPeminjaman", "DESC", $awalData, $dataPerhalaman, "peminjaman");
}
// !SECTION cari melalui sort by

// SECTION cari histori melalui search
if ((isset($_GET['cari']) && isset($_GET['keyword'])) || $_GET['urut'] == "cari") {

  if (!isset($keyword)) {
    $keyword = $_GET['urut'];
  }

  if (!isset($pencarian)) {
    $pencarian = $_GET['keyword'];
  }

  $jumlahData2 =  count(query("SELECT * FROM
                                    siswa s INNER JOIN
                                    kelas k ON s.idKelas = k.idKelas INNER JOIN
                                    peminjaman p ON s.idSiswa = p.idSiswa INNER JOIN
                                    buku b ON s.idSiswa = p.idSiswa AND p.idBuku = b.id
                                    WHERE s.namaSiswa LIKE '%$pencarian%' OR 
                                    k.namaKelas LIKE '%$pencarian%' OR
                                    b.nama LIKE '%$pencarian%' OR
                                    p.waktuPeminjaman LIKE '%$pencarian%'
                                    LIMIT $awalData, $dataPerhalaman"));

  $jumlahHalaman2 = ceil($jumlahData / $dataPerhalaman);

  $peminjaman = cari($pencarian, $awalData, $dataPerhalaman, "peminjaman");
}
// !SECTION cari histori melalui search

// $peminjaman = query("SELECT * FROM
//                       siswa s INNER JOIN
//                       kelas k ON s.idKelas = k.idKelas INNER JOIN
//                       peminjaman p ON s.idSiswa = p.idSiswa INNER JOIN
//                       buku b ON s.idSiswa = p.idSiswa AND p.idBuku = b.id
//                       LIMIT $awalData, $dataPerhalaman");

// if ( !isset($_GET['urut'])){
//     $_GET['urut'] = "default";
// }

$batasPengembalian = 7;


?>


<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Peminjam</title>
  <link rel="stylesheet" href="../../assets/css/BS-CSS/bootstrap.css">
  <link rel="stylesheet" href="../../assets/css/admin/stylePeminjam.css">
</head>

<body>

  <?php

  $result = mysqli_query($conn, "SELECT * FROM admin WHERE username= '{$_SESSION['username']}'");

  ?>

  <!-- HEADER -->
  <nav class="navbar bg-primary judul">
    <div class="container">
      <a class="navbar-brand fw-bold fs-4 ms-4" href="../index.php">
        <img src="../../assets/images/SMKN-1-Cirebon.png" alt="Bootstrap" width="70" height="70">
        Peminjamaan Buku
      </a>
      <div class="d-flex">
        <button class="border-0 bg-white fw-bold rounded-pill" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
          <img src="../../assets/icon/profile.png" width="40rem" alt="" class="bg-light rounded-circle p-0 py-1 pe-1">Profile
        </button>

        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
          <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasRightLabel">Admin</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
          </div>
          <div class="offcanvas-body">
            <?php foreach ($result as $dataAdmin) : ?>
              <img src="../../assets/icon/profile.png" width="100rem" alt="" class="mb-3">
              <p><?= $dataAdmin['username'] ?></p>
            <?php endforeach; ?>
            <div class="footer">
              <form action="../login-daftar/logout.php" method="post">
                <button class="border-0 bg-white fw-bold" type="submit" name="logoutAdmin">
                  <img src="../../assets/icon/logout.png" width="30rem" alt="">Logout
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </nav>
  <!-- AKHIR HEADER -->

  <?php

  $url = $_SERVER['REQUEST_URI'];

  $url = explode("/", $url);
  $url = array_pop($url);

  if (explode('?', $url)) {
    $url = explode('?', $url);
    $url = $url[0];
  }

  ?>

  <!-- MENU -->
  <div class="container">
    <ul class="nav justify-content-center mt-3 border rounded-pill bg-white" style="box-shadow: 5px 5px 5px #c5c5c5;">
      <!-- ITEM BUKU -->
      <li class="nav-item">
        <div class="dropdown me-3">
          <button class="btn btn-white dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="../../assets/icon/book1.png" width="35rem" alt="" class="me-2"><br>
            Buku
          </button>
          <ul class="dropdown-menu">
            <li>
              <a class="nav-link" aria-current="page" href="../buku/index.php">
                Daftar Buku
              </a>
            </li>
            <li>
              <a class="nav-link" href="../buku/tambahbuku.php">
                <!-- <img src="../../assets/icon/book2.png" width="35rem" alt="" class="ms-4"> -->
                Tambah Buku
              </a>
            </li>
          </ul>
        </div>
      </li>
      <!-- AKHIR ITEM BUKU -->
      <!-- ITEM PEMINJAMAN -->
      <li class="nav-item">
        <div class="dropdown">
          <button class="btn btn-white dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="../../assets/icon/lease.png" width="35rem" alt="" class="me-3"><br>
            peminjaman
          </button>
          <ul class="dropdown-menu">
            <li>
              <a class="nav-link active text-dark text-decoration-underline" href="peminjam.php">
                <!-- <img src="../../assets/icon/reader.png" width="35rem" alt="" class="ms-3"><br> -->
                Daftar Peminjam
              </a>
            </li>
            <li>
              <a class="nav-link" href="histori.php">
                <!-- <img src="../../assets/icon/book2.png" width="35rem" alt="" class="ms-4"> -->
                History
              </a>
            </li>
          </ul>
        </div>
      </li>
      <!-- AKHIR ITEM PEMINJAMAN -->
      <!-- ITEM DAFTAR QUOTES -->
      <li class="nav-item">
        <a class="nav-link" href="../quotes/">
          <img src="../../assets/icon/quote.png" width="35rem" alt="" class="ms-4"><br>
          Daftar Quotes
        </a>
      </li>
      <!-- AKHIR DAFTAR QUOTES -->
      <!-- ITEM CAROUSEL -->
      <li class="nav-item">
        <a class="nav-link" href="../carousel/index.php">
          <img src="../../assets/icon/carousel.png" width="35rem" alt="" class="ms-4"><br>
          Daftar Carousel
        </a>
      </li>
      <!-- AKHIR ITEM CAROUSEL -->
      <!-- ITEM FEEDBACK -->
      <li class="nav-item">
        <a class="nav-link" href="../feedback.php">
          <img src="../../assets/icon/chat.png" width="35rem" alt="" class="ms-3"><br>
          Feedback
        </a>
      </li>
      <!-- AKHIR ITEM FEEDBACK -->
    </ul>
  </div>
  <!-- AKHIR MENU -->
  <script src="../../assets/scripts/BS-JS/bootstrap.js"></script>
</body>

</html>

<!-- AWAL TABEL -->
<div class="container mt-4">
  <br>
  <!-- SECTION AWAL TABEL PEMINJAM -->
  <h5 class="fw-bold text-white text-center">Daftar Peminjam :</h5>

  <br>

  <!-- SECTION Cari -->
  <form action="" method="get" style="float: left; border-radius: 20px;">
    <input type="text" name="keyword" class="rounded-4">
    <button type="submit" name="urut" value="cari">Cari!</button>
  </form>
  <!-- !SECTION Cari -->


  <!-- pagination -->

  <div class="btn-group dropstart mb-2 mt-0" style="float: right;">

    <button type="button" class="dropdown-toggle border-0 bg-transparent fw-semibold" data-bs-toggle="dropdown" aria-expanded="false">
      Sort By
    </button>
    <ul class="dropdown-menu text rounded-4">
      <li>
        <form action="" method="get">
          <button class="dropdown-item" type="submit" name="urut" value="peminjamanASC">Waktu Peminjaman ASC</button>
        </form>
      </li>
      <li>
        <form action="" method="get">
          <button class="dropdown-item" type="submit" name="urut" value="peminjamanDESC">Waktu Peminjaman DESC</button>
        </form>
      </li>
    </ul>
  </div>

  <!-- SECTION Table Peminjaman -->
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

    <?php $i = $awalData + 1; ?>
    <?php foreach ($peminjaman as $data) : ?>
      <tr class="text-center">
        <td><?= $i; ?></td>
        <td><?= $data["namaSiswa"]; ?></td>
        <td><?= strtoupper($data["namaKelas"]); ?></td>
        <td><a href="https://api.whatsapp.com/<?php $data["kontakSiswa"]; ?>" class="kontak"><?= $data['kontakSiswa']; ?></td>
        <td><?= $data["nama"]; ?></td>
        <td><?= $data["waktuPeminjaman"]; ?></td>
        <td><?= bataswaktu(strtotime($data["waktuPeminjaman"]), $batasPengembalian); ?></td>
        <td>
          <a href="kembalikan_data_pengembalian.php?id=<?= $data['idPeminjaman']; ?>&waktupeminjaman=<?= $data['waktuPeminjaman']; ?>&param=admin" onclick="return confirm('Yakin ingin mengebalikan buku?')">
            <img src="../../assets/icon/left-arrow.png" width="30rem" alt="">
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
  <!-- !SECTION Table Peminjaman -->

  <!-- SECTION pagination peminjaman-->
  <div aria-label="Page navigation example">
    <ul class="pagination" style="align-items: center; justify-content: center;">
      <?php if ($halamanAktif > 1) : ?>
        <li class="page-item"><a class="page-link" href="?halamanUser=<?= $halamanAktif - 1 ?>&urut=<?= $keyword ?>&keyword=<?= $pencarian ?>">Previous</a></li>
      <?php endif; ?>

      <?php for ($i = 1; $i <= $jumlahHalaman; $i++) : ?>
        <?php if ($i == $halamanAktif) : ?>
          <li class="page-item active"><a class="page-link" href="?halamanUser=<?= $i ?>&urut=<?= $keyword ?>&keyword=<?= $pencarian ?>"><?= $i ?></a></li>
        <?php else : ?>
          <li class="page-item"><a class="page-link" href="?halamanUser=<?= $i ?>&urut=<?= $keyword ?>&keyword=<?= $pencarian ?>"><?= $i ?></a></li>
        <?php endif; ?>
      <?php endfor; ?>

      <?php if ($halamanAktif < $jumlahHalaman) : ?>
        <li class="page-item"><a class="page-link" href="?halamanUser=<?= $halamanAktif + 1 ?>&urut=<?= $keyword ?>&keyword=<?= $pencarian ?>">Next</a></li>
      <?php endif; ?>
    </ul>
  </div>
  <!-- !SECTION pagination peminjaman-->


  <!-- !SECTION AKHIR TABEL PEMINJAM -->
  <br>
</div>
<!-- AKHIR TABEL -->
<!-- AWAL FOOTER -->
<div class="bg-dark mt-3 p-1 pt-2 w-100" id="footer" style="margin-bottom: -2rem;">
  <?php include '../footerAdmin.php'; ?>
</div>
<!-- AKHIR FOOTER -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>