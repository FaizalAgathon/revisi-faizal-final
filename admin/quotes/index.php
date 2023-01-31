<?php require '../../koneksi.php';

// cek apakah sudah login belom
if (!(isset($_SESSION['loginAdmin']))) {
  // redirect (memindahkan user nya ke page lain)
  header("Location: ../../login-daftar/login_admin.php");
  exit;
}

if (isset($_POST['tambahQuotes'])) {
  $isiQuotes = $_POST['isiQuotes'];
  $kutipanQuotes = $_POST['kutipanQuotes'];

  mysqli_query($conn, "INSERT INTO quotes VALUES (NULL, '$isiQuotes', '$kutipanQuotes')");
}

?>

<?php 

$result = mysqli_query( $conn, "SELECT * FROM admin WHERE username= '{$_SESSION['username']}'" );

?>

<!DOCTYPE html>
<html>

<head>
  <title>Daftar Quotes</title>
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
        <a class="nav-link active text-dark text-decoration-underline" href="index.php">
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

  <div class="row">
    <div class="col">
      <h1>Daftar Quotes</h1>
    </div>
    <div class="col">
      <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#tambahQuotes">
        Tambah Quotes
      </button>
    </div>
  </div>

  <!-- AWAL FORM TAMBAH BUKU -->
  <div class="container mt-3 mb-3 bg-light p-3 tambah w-100 m-auto rounded-4">
    <table class="table table-bordered table-hover text-center">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Isi</th>
          <th scope="col">Kutipan</th>
          <th scope="col">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $jmlDataperHal = 10;
        $jmlData = count(query("SELECT * FROM quotes"));
        $jmlHal = ceil($jmlData / $jmlDataperHal);
        $halAktif = (isset($_GET['hal'])) ? $_GET['hal'] : 1;
        $awalData = ($jmlDataperHal * $halAktif) - $jmlDataperHal; ?>
        <?php $i = $awalData + 1 ?>
        <?php foreach (query("SELECT * FROM quotes LIMIT $awalData, $jmlDataperHal") as $quotes) : ?>
          <tr>
            <th scope="row"><?= $i++ ?></th>
            <td><?= $quotes['isiQuotes'] ?></td>
            <td><?= $quotes['kutipanQuotes'] ?></td>
            <td>
              <div class="row">
                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#edit<?= $quotes['idQuotes'] ?>">
                  Edit
                </button>
              </div>
              <div class="row">
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#hapus<?= $quotes['idQuotes'] ?>">
                  Hapus
                </button>
              </div>
            </td>
          </tr>
          <!-- SECTION POP UP EDIT -->
          <div class="modal fade" id="edit<?= $quotes['idQuotes'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Quotes</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="editQuotes.php" method="post">
                  <div class="modal-body text-center">
                    <input type="hidden" name="idQuotes" value="<?= $quotes['idQuotes'] ?>">
                    <textarea name="isiQuotes" cols="30" rows="10"><?= $quotes['isiQuotes'] ?></textarea>
                    <input type="text" value="<?= $quotes['kutipanQuotes'] ?>" name="kutipanQuotes">
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
          <div class="modal fade" id="hapus<?= $quotes['idQuotes'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="exampleModalLabel">Konfirmasi Hapus Quotes</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="hapusQuotes.php" method="post">
                  <div class="modal-body">
                    <input type="hidden" name="idQuotes" value="<?= $quotes['idQuotes'] ?>">
                    <h6>Isi : <?= $quotes['isiQuotes'] ?></h6>
                    <h6>Kutipan : <?= $quotes['kutipanQuotes'] ?></h6>
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
          <div class="modal fade" id="tambahQuotes" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Quotes</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="index.php" method="post">
                  <div class="modal-body">
                    <input type="hidden" name="tambahQuotes">
                    <textarea name="isiQuotes" cols="30" rows="10"></textarea>
                    <input type="text" name="kutipanQuotes">
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