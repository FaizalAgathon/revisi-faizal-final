<?php
require '../../koneksi.php';

// cek apakah sudah login belom
if (!(isset($_SESSION['loginAdmin']))) {
  // redirect (memindahkan user nya ke page lain)
  header("Location: ../../login-daftar/login_admin.php");
  exit;
}

if (isset($_POST['tambahBuku'])) {

  $judul = $_POST['judul'];
  $penerbit = $_POST['penerbit'];
  $penulis = $_POST['penulis'];
  $deskripsi = $_POST['deskripsi'];
  $tglTerbit = $_POST['tglTerbit'];
  $jumlah = $_POST['jumlah'];

  $namaGambar = $_FILES['gambar']['name'];
  $ukuranGambar = $_FILES['gambar']['size'];

  $rand = rand(1000, 9999);

  // var_dump($deskripsi);

  if ($ukuranGambar == 0) {

    mysqli_query($conn, "INSERT INTO buku VALUES
      (NULL, '$judul', '$deskripsi', '$tglTerbit', 
      '$penerbit', '$penulis', 'ppNoImg.png', '$jumlah', '0')");

    // var_dump($judul);

  } elseif ($ukuranGambar <= 5000000) {

    $gambar = $rand . '-' . $namaGambar;

    move_uploaded_file($_FILES['gambar']['tmp_name'], '../../assets/images/' . $gambar);

    mysqli_query($conn, "INSERT INTO buku VALUES
      (NULL, '$judul', '$deskripsi', '$tglTerbit', 
      '$penerbit', '$penulis', '$gambar', '$jumlah', '0')");

    // var_dump($deskripsi);

  }
}

$result = mysqli_query($conn, "SELECT * FROM admin WHERE username= '{$_SESSION['username']}'");

?>

<!DOCTYPE html>
<html>

<head>
  <title>Daftar Buku</title>
  <link rel="stylesheet" href="../../assets/css/BS-CSS/bootstrap.css">
  <link rel="stylesheet" href="../../assets/css/admin/styleAdmin.css">
</head>

<body>

  <!-- HEADER -->
  <nav class="navbar bg-primary judul">
    <div class="container">
      <a class="navbar-brand fw-bold fs-4 ms-4" href="#">
        <img src="../../assets/images/..." alt="Bootstrap" width="70" height="70">
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
              <a class="nav-link active text-dark text-decoration-underline" aria-current="page" href="index.php">
                Daftar Buku
              </a>
            </li>
            <li>
              <a class="nav-link" href="tambahbuku.php">
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
              <a class="nav-link" href="">
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
        <a class="nav-link" href="">
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
        <a class="nav-link <?= $url == 'feedback.php' ? 'active' : '' ?>" href="feedback.php">
          <img src="../../assets/icon/" width="35rem" alt="" class="ms-3"><br>
          Feedback
        </a>
      </li>
      <!-- AKHIR ITEM FEEDBACK -->
    </ul>
  </div>
  <!-- AKHIR MENU -->

  <!-- BAGIAN KIRI & DAFTAR BUKU -->
  <div class="row m-auto">
    <div class="col-12 mb-3 mt-4">
      <div class="row">
        <div class="col">
          <h1>Daftar Buku</h1>
        </div>
        <div class="col">
          <form action="" method="GET" class="input-group mb-2" role="search">
            <input class="form-control border-primary mt-2 rounded-pill" type="search" placeholder="Search" aria-label="Search" name="halCari">
          </form>
        </div>
      </div>
      <?php

      $jmlDataperHal = 6;
      $jmlData = count(query("SELECT * FROM buku"));
      $jmlHal = ceil($jmlData / $jmlDataperHal);
      $halAktif = (isset($_GET['hal'])) ? $_GET['hal'] : 1;
      $awalData = ($jmlDataperHal * $halAktif) - $jmlDataperHal;

      ?>
      <?php if (!isset($_POST['inputCari']) and !isset($_GET['halCari'])) : ?>
        <?php foreach (query("SELECT * FROM buku LIMIT $awalData, $jmlDataperHal") as $buku) : ?>
          <ul class="list-buku list-group" id="list">

            <li class="list-buku-item list-group-item bg-white rounded rounded-4 border mb-3" style="box-shadow: 5px 5px 5px rgb(120, 120, 120);">
              <div class="row g-1">
                <div class="col-md-3">
                  <img src="../../assets/images/<?= $buku['gambar'] ?>" class="img-fluid border rounded rounded-3" width="140rem" alt="...">
                </div>
                <div class="col-md-6 w-75">
                  <div class="card-body p-1">
                    <h5 class="card-title "><?= $buku['nama'] ?></h5>
                    <p class="fw-light fs-6 mb-0"><?= $buku['deskripsi'] ?></p>
                    <div class="d-grid gap-2 px-2 pt-2">
                      <div class="row gap-2">
                        <button class="col btn btn-warning btn-sm rounded-pill text-white p-0" type="button" data-bs-toggle="modal" data-bs-target="#edit<?= $buku['id'] ?>">
                          <img src="../../assets/icon/edit1.png" width="20px" alt="">
                        </button>
                        <a href="hapusBuku.php?id=<?= $buku['id'] ?>" class="col btn btn-danger btn-sm rounded-pill">
                          <img src="../../assets/icon/delete1.png" width="20px" alt="">
                        </a>
                      </div>
                    </div>
                    <!-- SECTION AWAL POP UP EDIT -->
                    <div class="modal fade" data-bs-backdrop="static" tabindex="-1" id="edit<?= $buku['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-scrollable">
                        <div class="modal-content">
                          <div class="modal-header border-0 text-white" style="background: linear-gradient(120deg,#4433ff,#00ffff);">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Buku</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <form action="editBuku.php" method="POST" enctype="multipart/form-data">
                              <div class="mb-3">
                                <label for="gambar" class="form-label">Gambar :</label><br>
                                <img src="../../assets/images/<?= $buku['gambar'] ?>" class="w-25 mb-2" alt="..." width="100%">
                                <input type="file" class="form-control form-control-sm w-50" id="gambar" name="gambar" accept=".png,.jpg,.jpeg,.gif,.JPG,.PNG,.JPEG,.GIF">
                              </div>
                              <div class="mb-3">
                                <label for="Judul" class="form-label">Judul :</label>
                                <input type="text" class="form-control border-bottom border-0 rounded-0" id="Judul" name="judul" value="<?= $buku['nama'] ?>">
                              </div>
                              <div class="mb-3">
                                <label for="penulis" class="form-label">Penulis :</label>
                                <input type="text" class="form-control border-bottom border-0 rounded-0" id="penulis" name="penulis" value="<?= $buku['penulis'] ?>">
                              </div>
                              <div class="mb-3">
                                <label for="penerbit" class="form-label">Penerbit :</label>
                                <input type="text" class="form-control border-bottom border-0 rounded-0" id="penerbit" name="penerbit" value="<?= $buku['penerbit'] ?>">
                              </div>
                              <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi :</label>
                                <textarea type="text" class="form-control border-bottom border-0 rounded-0" id="deskripsi" name="deskripsi" rows="6"><?= $buku['deskripsi'] ?></textarea>
                              </div>
                              <div class="mb-3">
                                <label for="jumlah" class="form-label">Jumlah Buku :</label>
                                <input type="text" class="form-control border-1 rounded-3 w-25" id="jumlah" name="jumlah" value="<?= $buku['jumlah'] ?>">
                              </div>
                              <input type="hidden" name="idBuku" value="<?= $buku['id'] ?>">
                              <div class="input-group">
                                <button type="reset" class="btn btn-outline-danger py-1 px-4 pt-0 w-50">
                                  <img src="../../assets/icon/multiply.png" width="20rem" alt="">
                                  Cancel
                                </button>
                                <button type="submit" class="btn btn-outline-primary py-1 px-4 pt-0 w-50">
                                  <img src="../../assets/icon/bookmark.png" width="20rem" alt="">
                                  save
                                </button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- !SECTION AKHIR POP UP EDIT -->
                  </div>
                </div>
              </div>
            </li>

          </ul>
        <?php endforeach; ?>
        <nav aria-label="Page navigation example">
          <ul class="pagination">

            <?php if ($halAktif > 1) : ?>
              <li class="page-item">
                <a class="page-link" href="?hal=<?= $halAktif - 1 ?>" aria-label="Previous">
                  <span aria-hidden="true">&laquo;</span>
                </a>
              </li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $jmlHal; $i++) : ?>
              <li class="page-item <?= $i == $halAktif ? 'active' : '' ?>">
                <a class="page-link" href="?hal=<?= $i ?>">
                  <?= $i ?>
                </a>
              </li>
            <?php endfor; ?>

            <?php if ($halAktif < $jmlHal) : ?>
              <li class="page-item">
                <a class="page-link" href="?hal=<?= $halAktif + 1 ?>" aria-label="Next">
                  <span aria-hidden="true">&raquo;</span>
                </a>
              </li>
            <?php endif; ?>

          </ul>
        </nav>
      <?php endif; ?>
      <?php if (isset($_GET['halCari'])) : ?>
        <?php
        $keyword = $_GET['halCari'];
        $jmlDataCari = count(query("SELECT * FROM buku WHERE nama LIKE '%$keyword%'"));
        $jmlHalCari = ceil($jmlDataCari / $jmlDataperHal);

        foreach (query("SELECT * FROM buku WHERE nama LIKE '%$keyword%' LIMIT $awalData, $jmlDataperHal") as $cariBuku) : ?>
          <ul class="list-buku list-group" id="list">
            <li class="list-buku-item list-group-item bg-white rounded rounded-4 border" style="box-shadow: 5px 5px 5px rgb(120, 120, 120);">
              <div class="row g-1">
                <div class="col-md-3">
                  <img src="../../assets/images/<?= $cariBuku['gambar'] ?>" class="img-fluid border rounded rounded-3" width="140rem" alt="...">
                </div>
                <div class="col-md-6 w-75">
                  <div class="card-body p-1">
                    <h5 class="card-title "><?= $cariBuku['nama'] ?></h5>
                    <p class="fw-light fs-6 mb-0"><?= $cariBuku['deskripsi'] ?></p>
                    <div class="d-grid gap-2 px-2 pt-2">
                      <div class="row gap-2">
                        <button class="col btn btn-warning btn-sm rounded-pill text-white p-0" type="button" data-bs-toggle="modal" data-bs-target="#edit<?= $cariBuku['id'] ?>">
                          <img src="../../assets/icon/edit1.png" width="20px" alt="">
                        </button>
                        <a href="hapusBuku.php?id=<?= $cariBuku['id'] ?>" class="col btn btn-danger btn-sm rounded-pill">
                          <img src="../../assets/icon/bin.png" width="20px" alt="">
                        </a>
                      </div>
                    </div>
                    <!-- SECTION AWAL POP UP EDIT -->
                    <div class="modal fade" data-bs-backdrop="static" tabindex="-1" id="edit<?= $cariBuku['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-scrollable">
                        <div class="modal-content">
                          <div class="modal-header border-0 text-white" style="background: linear-gradient(120deg,#4433ff,#00ffff);">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Buku</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <form action="editBuku.php" method="POST" enctype="multipart/form-data">
                              <div class="mb-3">
                                <label for="gambar" class="form-label">Gambar :</label><br>
                                <img src="../../assets/images/<?= $cariBuku['gambar'] ?>" class="w-25 mb-2" alt="..." width="100%">
                                <input type="file" class="form-control form-control-sm w-50" id="gambar" name="gambar" accept=".png,.jpg,.jpeg,.gif,.JPG,.PNG,.JPEG,.GIF">
                              </div>
                              <div class="mb-3">
                                <label for="Judul" class="form-label">Judul :</label>
                                <input type="text" class="form-control border-bottom border-0 rounded-0" id="Judul" name="judul" value="<?= $cariBuku['nama'] ?>">
                              </div>
                              <div class="mb-3">
                                <label for="penulis" class="form-label">Penulis :</label>
                                <input type="text" class="form-control border-bottom border-0 rounded-0" id="penulis" name="penulis" value="<?= $cariBuku['penulis'] ?>">
                              </div>
                              <div class="mb-3">
                                <label for="penerbit" class="form-label">Penerbit :</label>
                                <input type="text" class="form-control border-bottom border-0 rounded-0" id="penerbit" name="penerbit" value="<?= $cariBuku['penerbit'] ?>">
                              </div>
                              <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi :</label>
                                <input type="text" class="form-control border-bottom border-0 rounded-0" id="deskripsi" name="deskripsi" value="<?= $cariBuku['deskripsi'] ?>">
                              </div>
                              <div class="mb-3">
                                <label for="jumlah" class="form-label">Jumlah Buku :</label>
                                <input type="text" class="form-control border-1 rounded-3 w-25" id="jumlah" name="jumlah" value="<?= $cariBuku['jumlah'] ?>">
                              </div>
                              <input type="hidden" name="idBuku" value="<?= $cariBuku['id'] ?>">
                              <div class="input-group">
                                <button type="reset" class="btn btn-outline-danger py-1 px-4 pt-0 w-50">
                                  <img src="../../assets/icon/multiply.png" width="20rem" alt="">
                                  Cancel
                                </button>
                                <button type="submit" class="btn btn-outline-primary py-1 px-4 pt-0 w-50">
                                  <img src="../../assets/icon/bookmark.png" width="20rem" alt="">
                                  save
                                </button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- !SECTION AKHIR POP UP EDIT -->
                  </div>
                </div>
              </div>
            </li>
          </ul>
        <?php endforeach; ?>
        <?php if ($jmlHalCari != 1 && $_GET['halCari'] > 1) : ?>
          <nav aria-label="Page navigation example">
            <ul class="pagination">
              <?php if ($halAktif > 1) : ?>
                <li class="page-item">
                  <a class="page-link" href="?halCari=<?= $keyword ?>&hal=<?= $halAktif - 1 ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                  </a>
                </li>
              <?php endif; ?>
              <?php for ($i = 1; $i <= $jmlHalCari; $i++) : ?>
                <li class="page-item <?= $i == $halAktif ? 'active' : '' ?>">
                  <a class="page-link" href="?halCari=<?= $keyword ?>&hal=<?= $i ?>">
                    <?= $i ?>
                  </a>
                </li>
              <?php endfor; ?>
              <?php if ($halAktif < $jmlHalCari) : ?>
                <li class="page-item">
                  <a class="page-link" href="?halCari=<?= $keyword ?>&hal=<?= $halAktif + 1 ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                  </a>
                </li>
              <?php endif; ?>
            </ul>
          </nav>
        <?php endif; ?>
      <?php endif; ?>
    </div>
    <!-- AKHIR BAGIAN KIRI & DAFTAR BUKU -->
  </div>

  <!-- AWAL FOOTER -->
  <div class="bg-dark mt-3 p-1 pt-2 w-100" id="footer" style="margin-bottom: -2rem;">
    <?php include '../footerAdmin.php'; ?>
  </div>
  <!-- AKHIR FOOTER -->

  <script src="../../assets/scripts/BS-JS/bootstrap.bundle.js"></script>
</body>

</html>