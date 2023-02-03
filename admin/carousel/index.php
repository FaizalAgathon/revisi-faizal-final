<?php require '../../koneksi.php';

// cek apakah sudah login belom
if (!(isset($_SESSION['loginAdmin']))) {
  // redirect (memindahkan user nya ke page lain)
  header("Location: ../../login-daftar/login_admin.php");
  exit;
}

if (isset($_POST['tambahCarousel'])) {

  $namaCarousel = $_FILES['gambarCarousel']['name'];
  $ukuranCarousel = $_FILES['gambarCarousel']['size'];
  $rand = rand(1000, 9999);
  $extCarousel = explode('.', $namaCarousel);
  $extCarousel = array_pop($extCarousel);

  if ($ukuranCarousel <= 5000000) {

    $carousel = $rand . '.' . $extCarousel;

    move_uploaded_file($_FILES['gambarCarousel']['tmp_name'], '../../assets/carousel/' . $carousel);

    mysqli_query($conn, "INSERT INTO carousel VALUES (NULL, '$carousel')");
  }
}


?>

<?php 

$result = mysqli_query( $conn, "SELECT * FROM admin WHERE username= '{$_SESSION['username']}'" );

?>

<!DOCTYPE html>
<html>

<head>
  <title>Daftar Carosuel</title>
  <link rel="stylesheet" href="../../assets/css/BS-CSS/bootstrap.css">
  <link rel="stylesheet" href="../../assets/css/admin/styleAdmin.css">
  <style>
    .row,
    .col {
      margin: 0;
    }
  </style>
</head>

<body>

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

        <div class="offcanvas offcanvas-end h-50" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
          <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasRightLabel">Admin</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
          </div>
          <div class="offcanvas-body text-center">
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
              <a class="nav-link" aria-current="page" href="../buku/">
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
              <a class="nav-link" href="../peminjam/peminjam.php">
                <!-- <img src="../icon/reader.png" width="35rem" alt="" class="ms-3"><br> -->
                Daftar Peminjam
              </a>
            </li>
            <li>
              <a class="nav-link" href="../peminjam/histori.php">
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
        <a class="nav-link" href="../quotes/index.php">
          <img src="../../assets/icon/quote.png" width="35rem" alt="" class="ms-4"><br>
          Daftar Quotes
        </a>
      </li>
      <!-- AKHIR DAFTAR QUOTES -->
      <!-- ITEM CAROUSEL -->
      <li class="nav-item">
        <a class="nav-link active text-dark text-decoration-underline" href="index.php">
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

  
  <!-- AWAL FORM TAMBAH BUKU -->
  <div class="container mt-3 mb-3 bg-light p-3 tambah w-100 m-auto rounded-4 border border-dark border-3">
    <div class="row p-2 mb-3">
      <div class="col">
        <h1>Daftar Carousel</h1>
      </div>
      <div class="col">
        <button type="button" class="btn btn-primary mt-2 float-end rounded-pill" data-bs-toggle="modal" data-bs-target="#tambahCarousel">
          Tambah Carousel
        </button>
      </div>
    </div>
    <table class="table table-bordered table-hover text-center border-dark border-1 border">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Gambar</th>
          <th scope="col">Nama</th>
          <th scope="col">Format</th>
          <th scope="col">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $jmlDataperHal = 10;
        $jmlData = count(query("SELECT * FROM carousel"));
        $jmlHal = ceil($jmlData / $jmlDataperHal);
        $halAktif = (isset($_GET['hal'])) ? $_GET['hal'] : 1;
        $awalData = ($jmlDataperHal * $halAktif) - $jmlDataperHal; ?>
        <?php $i = $awalData + 1 ?>
        <?php foreach (query("SELECT * FROM carousel LIMIT $awalData, $jmlDataperHal") as $carousel) : ?>
          <tr>
            <th scope="row"><?= $i++ ?></th>
            <td>
              <img src="../../assets/carousel/<?= $carousel['namaCarousel'] ?>" alt="" width="100">
            </td>
            <td><?= explode('.', $carousel['namaCarousel'])[0] ?></td>
            <td>
              <?php
              $carouselNama = explode('.', $carousel['namaCarousel']);
              echo '.' . $carouselFormat = end($carouselNama);
              ?>
            </td>
            <td>
              <div class="row mb-1 mt-4">
                <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#edit<?= $carousel['idCarousel'] ?>">
                  <img src="../../assets/icon/edit2.png" width="30rem" alt="">
                </button>
              </div>
              <div class="row">
                <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#hapus<?= $carousel['idCarousel'] ?>">
                  <img src="../../assets/icon/delete2.png" width="30rem" alt="">
                </button>
              </div>
            </td>
          </tr>
          <!-- SECTION POP UP EDIT -->
          <div class="modal fade" id="edit<?= $carousel['idCarousel'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Carousel</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="editCarousel.php" method="post" enctype="multipart/form-data">
                  <div class="modal-body text-center">
                    <img src="../../assets/carousel/<?= $carousel['namaCarousel'] ?>" alt="" width="300">
                    <input type="file" class="form-control form-control-sm w-50" name="gambarCarousel" accept=".png,.jpg,.jpeg,.gif,.JPG,.PNG,.JPEG,.GIF">
                    <input type="hidden" name="idCarousel" value="<?= $carousel['idCarousel'] ?>">
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <!-- !SECTION POP UP EDIT -->
          <!-- SECTION POP UP HAPUS -->
          <div class="modal fade" id="hapus<?= $carousel['idCarousel'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="exampleModalLabel">Konfirmasi Hapus Carousel</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="hapusCarousel.php" method="post">
                  <div class="modal-body">
                    <img src="../../assets/carousel/<?= $carousel['namaCarousel'] ?>" alt="..." width="200">
                    <h6>Nama : <?= $carousel['namaCarousel'] ?></h6>
                    <input type="hidden" name="idCarousel" value="<?= $carousel['idCarousel'] ?>">
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <!-- !SECTION POP UP HAPUS -->
          <!-- SECTION POP UP TAMBAH -->
          <div class="modal fade" id="tambahCarousel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Gambar Carousel</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="index.php" method="post" enctype="multipart/form-data">
                  <div class="modal-body">
                    <input type="file" name="gambarCarousel" accept=".png,.jpg,.jpeg,.gif,.JPG,.PNG,.JPEG,.GIF">
                    <input type="hidden" name="tambahCarousel">
                  </div>
                  <div class="modal-footer">
                    <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Understood</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <!-- !SECTION POP UP TAMBAH -->
        <?php endforeach; ?>
      </tbody>
    </table>

    <?php if ($jmlHal > 1) : ?>

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
  </div>
  <!-- AKHIR FORM TAMBAH BUKU -->

  <script src="../../assets/scripts/BS-JS/bootstrap.bundle.js"></script>
</body>

</html>