<?php

require '../../koneksi.php';

// cek apakah sudah login belom
if (!(isset($_SESSION['loginAdmin']))) {
  // redirect (memindahkan user nya ke page lain)
  header("Location: ../../login-daftar/login_admin.php");
  exit;
}

// SECTION pagination histori
$dataPerhalaman2 = 5;
$jumlahData2 =  count(query("SELECT * FROM
                                histori h INNER JOIN
                                siswa s ON s.idSiswa = h.idSiswa INNER JOIN
                                kelas k ON s.idkelas = k.idKelas INNER JOIN
                                buku b ON h.idBuku = b.id AND s.idSiswa = h.idSiswa"));

$jumlahHalaman2 = ceil($jumlahData2 / $dataPerhalaman2);

$halamanAktif2 = isset($_GET['halamanHistori']) ? $_GET['halamanHistori'] : 1;

$awalData2 = ($dataPerhalaman2 * $halamanAktif2) - $dataPerhalaman2;

// !SECTION pagination histori

// SECTION tampilkan data

if (!isset($_GET['urut'])) {
  $_GET['urut'] = "default";
}


if ($_GET['urut'] == "default") {
  $histori = query("SELECT * FROM
                    histori h INNER JOIN
                    siswa s ON s.idSiswa = h.idSiswa INNER JOIN
                    kelas k ON s.idkelas = k.idKelas INNER JOIN
                    buku b ON h.idBuku = b.id AND s.idSiswa = h.idSiswa
                    LIMIT $awalData2, $dataPerhalaman2");

  if (!isset($pencarian)) {
    $pencarian = "none";
  }

  if (!isset($keyword)) {
    $keyword = "default";
  }
}
// !SECTION tampilkan data

// SECTION cari melalui sort by
if ((isset($_GET['urut']) && $_GET['urut'] == "pengembalianASC")  || $_GET['urut'] == "pengembalianASC") {
  if (!isset($keyword)) {
    $keyword = $_GET['urut'];
  }
  if (!isset($pencarian)) {
    $pencarian = "none";
  }

  $histori = urutan("waktuPengembalian", "ASC", $awalData2, $dataPerhalaman2, "histori");
}

if ((isset($_GET['urut']) && $_GET['urut'] == "peminjamanDESC") || $_GET['urut'] == "pengembalianDESC") {
  if (!isset($keyword)) {
    $keyword = $_GET['urut'];
  }
  if (!isset($pencarian)) {
    $pencarian = "none";
  }
  $histori = urutan("waktuPengembalian", "DESC", $awalData2, $dataPerhalaman2, "histori");
}

if ((isset($_GET['urut']) && $_GET['urut'] == "peminjamanASC") || $_GET['urut'] == "peminjamanASC") {
  if (!isset($keyword)) {
    $keyword = $_GET['urut'];
  }
  if (!isset($pencarian)) {
    $pencarian = "none";
  }
  $histori = urutan("waktuPeminjaman", "ASC", $awalData2, $dataPerhalaman2, "histori");
}

if ((isset($_GET['urut']) && $_GET['urut'] == "peminjamanDESC") || $_GET['urut'] == "peminjamanDESC") {
  if (!isset($keyword)) {
    $keyword = $_GET['urut'];
  }
  if (!isset($pencarian)) {
    $pencarian = "none";
  }
  $histori = urutan("waktuPeminjaman", "DESC", $awalData2, $dataPerhalaman2, "histori");
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
                                    histori h INNER JOIN
                                    siswa s ON s.idSiswa = h.idSiswa INNER JOIN
                                    kelas k ON s.idkelas = k.idKelas INNER JOIN
                                    buku b ON h.idBuku = b.id AND s.idSiswa = h.idSiswa
                                    WHERE s.namaSiswa LIKE '%$pencarian%' OR 
                                    k.namaKelas LIKE '%$pencarian%' OR
                                    b.nama LIKE '%$pencarian%'
                                    LIMIT $awalData2, $dataPerhalaman2"));

  $jumlahHalaman2 = ceil($jumlahData2 / $dataPerhalaman2);

  $histori = cari($pencarian, $awalData2, $dataPerhalaman2, "histori");
}
// !SECTION cari histori melalui search

// var_dump($_SESSION['urut']);

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
              <form action="../../login-daftar/logout.php" method="post">
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
                <!-- <img src="../icon/book2.png" width="35rem" alt="" class="ms-4"> -->
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
              <a class="nav-link" href="peminjam.php">
                <!-- <img src="../icon/reader.png" width="35rem" alt="" class="ms-3"><br> -->
                Daftar Peminjam
              </a>
            </li>
            <li>
              <a class="nav-link active text-dark text-decoration-underline" href="">
                <!-- <img src="../icon/book2.png" width="35rem" alt="" class="ms-4"> -->
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
        <a class="nav-link" href="../carousel/">
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

  <!-- AWAL TABEL -->
  <div class="container mt-4">
    <br>
    <!-- SECTION AWAL TABEL HISTORY -->
    <h5 class="fw-bold text-white text-center">History :</h5>

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
        <li class="">
          <form action="" method="get">
            <button class="dropdown-item" type="submit" name="urut" value="pengembalianASC">Waktu Pengembalian ASC</button>
          </form>
        </li>
        <li>
          <form action="" method="get">
            <button class="dropdown-item" type="submit" name="urut" value="pengembalianDESC">Waktu Pengembalian DESC</button>
          </form>
        </li>
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
    <table class="table table-light table-striped">
      <tr class="text-center">
        <th>No</th>
        <th>Nama</th>
        <th>Kelas</th>
        <th>Kontak</th>
        <th>Buku</th>
        <th>Waktu Peminjaman</th>
        <th>Waktu Pengembalian</th>
      </tr>

      <?php $j = $awalData2 + 1 ?>
      <?php foreach ($histori as $data2) : ?>
        <tr class="text-center">
          <td><?= $j; ?></td>
          <td><?= $data2['namaSiswa']; ?></td>
          <td><?= strtoupper($data2['namaKelas']); ?></td>
          <td><a href="https://api.whatsapp.com/<?php $data2["kontakSiswa"]; ?>" class="kontak"><?= $data2['kontakSiswa']; ?></td>
          <td><?= $data2['nama']; ?></td>
          <td><?= $data2['waktuPeminjaman']; ?></td>
          <td><?= $data2['waktuPengembalian']; ?></td>
        </tr>
        <?php $j++; ?>
      <?php endforeach; ?>

      <?php if ($j == 1) : ?>
        <tr>
          <td colspan="8" align="center"> Tidak ada Histori yang tersedia</td>
        </tr>
      <?php endif; ?>

    </table>

    <!-- SECTION pagination histori -->
    <div aria-label="Page navigation example">
      <ul class="pagination" style="align-items: center; justify-content: center;">
        <?php if ($halamanAktif2 > 1) : ?>
          <li class="page-item"><a class="page-link" href="?halamanHistori=<?= $halamanAktif2 - 1 ?>&urut=<?= $keyword ?>&keyword=<?= $pencarian ?>">Previous</a></li>
        <?php endif; ?>

        <?php for ($j = 1; $j <= $jumlahHalaman2; $j++) : ?>
          <?php if ($j == $halamanAktif2) : ?>
            <li class="page-item active"><a class="page-link" href="?halamanHistori=<?= $j ?>&urut=<?= $keyword ?>&keyword=<?= $pencarian ?>"><?= $j ?></a></li>
          <?php else : ?>
            <li class="page-item"><a class="page-link" href="?halamanHistori=<?= $j ?>&urut=<?= $keyword ?>&keyword=<?= $pencarian ?>"><?= $j ?></a></li>
          <?php endif; ?>
        <?php endfor; ?>

        <?php if ($halamanAktif2 < $jumlahHalaman2) : ?>
          <li class="page-item"><a class="page-link" href="?halamanHistori=<?= $halamanAktif2 + 1 ?>&urut=<?= $keyword ?>&keyword=<?= $pencarian ?>">Next</a></li>
        <?php endif; ?>
      </ul>
    </div>
    <!-- !SECTION pagination histori -->


    <!-- !SECTION AKHIR TABEL HISTORY -->
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