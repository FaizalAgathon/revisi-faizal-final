<?php 

$result = mysqli_query( $conn, "SELECT * FROM admin WHERE username= '{$_SESSION['username']}'" );

?>
<link rel="stylesheet" href="../assets/css/BS-CSS/bootstrap.css">
<link rel="stylesheet" href="../css/styleAdmin.css">
  
  <!-- HEADER -->
  <nav class="navbar bg-primary judul">
    <div class="container">
      <a class="navbar-brand fw-bold fs-4 ms-4" href="#">
        <img src="../assets/images/..." alt="Bootstrap" width="70" height="70">
        Peminjamaan Buku
      </a>
      <div class="d-flex">
        <button class="border-0 bg-white fw-bold rounded-pill" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
          <img src="../icon/profile.png" width="40rem" alt="" class="bg-light rounded-circle p-0 py-1 pe-1">Profile
        </button>

        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
          <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasRightLabel">Admin</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
          </div>
          <div class="offcanvas-body">
            <?php foreach( $result as $dataAdmin ) : ?>
            <img src="../icon/profile.png" width="100rem" alt="" class="mb-3">
            <p><?= $dataAdmin['username'] ?></p>
            <?php endforeach ; ?>
            <div class="footer">
              <form action="../login-daftar/logout.php" method="post">
                <button class="border-0 bg-white fw-bold" type="submit" name="logoutAdmin">
                  <img src="../icon/logout.png" width="30rem" alt="">Logout
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

  if ( explode('?', $url) ){
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
          <img src="../assets/icon/book1.png" width="35rem" alt="" class="me-2"><br>
            Buku
          </button>
          <ul class="dropdown-menu">
            <li>
              <a class="nav-link <?= $url == 'admin.php' ? 'active text-dark text-decoration-underline' : '' ?>" aria-current="page" href="buku/index.php">
                Daftar Buku
              </a>
            </li>
            <li>
              <a class="nav-link <?= $url == 'tambahbuku.php' ? 'active text-dark text-decoration-underline' : '' ?>" href="tambahbuku.php">
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
          <img src="../assets/icon/lease.png" width="35rem" alt="" class="me-3"><br>
            peminjaman
          </button>
          <ul class="dropdown-menu">
            <li>
              <a class="nav-link <?= $url == 'peminjam.php' ? 'active text-dark text-decoration-underline' : '' ?>" href="peminjam.php">
                <!-- <img src="../icon/reader.png" width="35rem" alt="" class="ms-3"><br> -->
                Daftar Peminjam
              </a>
            </li>
            <li>
              <a class="nav-link <?= $url == '' ? 'active text-dark text-decoration-underline' : '' ?>" href="">
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
        <a class="nav-link <?= $url == '' ? 'active text-dark text-decoration-underline' : '' ?>" href="">
          <img src="../assets/icon/quote.png" width="35rem" alt="" class="ms-4"><br>
          Daftar Quotes
        </a>
      </li>
      <!-- AKHIR DAFTAR QUOTES -->
      <!-- ITEM CAROUSEL -->
      <li class="nav-item">
        <a class="nav-link <?= $url == '' ? 'active text-dark text-decoration-underline' : '' ?>" href="">
          <img src="../assets/icon/carousel.png" width="35rem" alt="" class="ms-4"><br>
          Daftar Carousel
        </a>
      </li>
      <!-- AKHIR ITEM CAROUSEL -->
      <!-- ITEM FEEDBACK -->
      <li class="nav-item">
        <a class="nav-link <?= $url == 'feedback.php' ? 'active text-dark text-decoration-underline' : '' ?>" href="feedback.php">
          <img src="../icon/chat.png" width="35rem" alt="" class="ms-3"><br>
          Feedback
        </a>
      </li>
      <!-- AKHIR ITEM FEEDBACK -->
    </ul>
  </div>
  <!-- AKHIR MENU -->
  <script src="../assets/scripts/BS-JS/bootstrap.js"></script>
</body>
</html>