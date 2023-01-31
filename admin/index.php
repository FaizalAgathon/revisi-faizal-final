<?php
require '../koneksi.php';

// cek apakah sudah login belom
if (!(isset($_SESSION['loginAdmin']))) {
  // redirect (memindahkan user nya ke page lain)
  header("Location: ../login-daftar/login_admin.php");
  exit;
}

?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Home</title>
  <link href="../assets/css/BS-CSS/bootstrap.css">
  <link rel="stylesheet" href="../assets/css/admin/styleAdmin.css">
</head>

<body>

  <?php include 'header-menu-admin.php'; ?>

  <div class="row m-auto">
    <div class="col-12 col-md-8 mb-3 mt-4">
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
                  <img src="../assets/images/<?= $buku['gambar'] ?>" class="img-fluid border rounded rounded-3" width="140rem" alt="...">
                </div>
                <div class="col-md-6 w-75">
                  <div class="card-body p-1">
                    <h5 class="card-title "><?= $buku['nama'] ?></h5>
                    <p class="fw-light fs-6 mb-0"><?= $buku['deskripsi'] ?></p>
                    <div class="d-grid gap-2 px-2 pt-2">
                      <div class="row gap-2">
                        <button class="col btn btn-white border btn-sm rounded-pill text-dark fw-semibold p-0" type="button" data-bs-toggle="modal" data-bs-target="#detail<?= $buku['id'] ?>" style="box-shadow: 5px 5px 5px rgb(201, 201, 201)">
                          <img src="../assets/icon/information2.png" width="20rem" alt=""><br>
                          Detail
                        </button>
                      </div>
                    </div>
                    <!-- AWAL POP UP DETAIL -->
                    <div class="modal fade" id="detail<?= $buku['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header border-0 text-white" style="background: linear-gradient(120deg,#4433ff,#00ffff);">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Detail</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <div class="row g-2">
                              <div class="col-md-4">
                                <img src="../assets/images/<?= $buku['gambar'] ?>" class="img-fluid rounded-start" alt="...">
                              </div>
                              <div class="col-md-8">
                                <div class="card-body">
                                  <h5>Judul : <?= $buku['nama'] ?></h5>

                                  <h6>Penulis : <?= $buku['penulis'] ?></h6>
                                  <h6>Penerbit : <?= $buku['penerbit'] ?></h6>
                                  <h6>Tanggal terbit : <?= $buku['tglTerbit'] ?></h6>
                                  <h6>Tersedia : <?= $buku['jumlah'] ?> Buku</h6>
                                </div>
                              </div>
                              <hr>
                              <h6 class="fw-bold">Deskripsi : </h6>
                              <p class="" style="max-height: 200px; overflow: auto;"><?= $buku['deskripsi'] ?></p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
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
            <li class="list-buku-item list-group-item bg-white rounded rounded-4 border mb-3" style="box-shadow: 5px 5px 5px rgb(120, 120, 120);">
              <div class="row g-1">
                <div class="col-md-3">
                  <img src="../assets/images/<?= $cariBuku['gambar'] ?>" class="img-fluid border rounded rounded-3" width="140rem" alt="...">
                </div>
                <div class="col-md-6 w-75">
                  <div class="card-body p-1">
                    <h5 class="card-title "><?= $cariBuku['nama'] ?></h5>
                    <p class="fw-light fs-6 mb-0"><?= $cariBuku['deskripsi'] ?></p>
                    <div class="d-grid gap-2 px-2 pt-2">
                      <div class="row gap-2">
                        <button class="col btn btn-white border btn-sm rounded-pill text-dark fw-semibold p-0" type="button" data-bs-toggle="modal" data-bs-target="#detail<?= $cariBuku['id'] ?>" style="box-shadow: 5px 5px 5px rgb(201, 201, 201)">
                          <img src="../assets/icon/information2.png" width="20rem" alt=""><br>
                          Detail
                        </button>
                      </div>
                    </div>
                    <!-- AWAL POP UP DETAIL -->
                    <div class="modal fade" id="detail<?= $cariBuku['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header border-0 text-white" style="background: linear-gradient(120deg,#4433ff,#00ffff);">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Detail</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <div class="row g-2">
                              <div class="col-md-4">
                                <img src="../assets/images/<?= $cariBuku['gambar'] ?>" class="img-fluid rounded-start" alt="...">
                              </div>
                              <div class="col-md-8">
                                <div class="card-body">
                                  <h5>Judul : <?= $cariBuku['nama'] ?></h5>

                                  <h6>Penulis : <?= $cariBuku['penulis'] ?></h6>
                                  <h6>Penerbit : <?= $cariBuku['penerbit'] ?></h6>
                                  <h6>Tanggal terbit : <?= $cariBuku['tglTerbit'] ?></h6>
                                  <h6>Tersedia : <?= $cariBuku['jumlah'] ?> Buku</h6>
                                </div>
                              </div>
                              <hr>
                              <h6 class="fw-bold">Deskripsi : </h6>
                              <p class="" style="max-height: 200px; overflow: auto;"><?= $cariBuku['deskripsi'] ?></p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </li>
          </ul>
        <?php endforeach; ?>

        <?php if ($jmlDataCari == 0) : ?>
          <ul class="list-buku list-group" id="list">
            <li class="list-buku-item list-group-item bg-white rounded rounded-4 border mb-3" style="box-shadow: 5px 5px 5px rgb(120, 120, 120);">
              <div class="p-2">
                <h4 class="fst-italic text-center">Buku tidak ditemukan</h4>
              </div>
            </li>
          </ul>
        <?php endif; ?>

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
    <!-- BAGIAN KANAN -->
    <div class="col-12 col-md-4 mt-4">

      <form action="" method="GET" class="input-group mb-2" role="search">
        <input class="form-control border-primary mt-2 rounded-pill" type="search" placeholder="Search" aria-label="Search" name="halCari">
      </form>
      <div class="mt-0 mb-3 bg-white rounded-3 px-2">
        <div id="quotes" class="carousel slide" data-bs-ride="carousel">
          <div class="carousel-inner">
            <?php $i = 1; ?>
            <?php foreach (query("SELECT * FROM quotes") as $quotes) : ?>
              <?php $active = ($i == 1) ? 'active' : '' ?>
              <div class="carousel-item <?= $active ?>">
                <blockquote class="blockquote text-center">
                  <p class="" style="font-size: 1rem;"><?= $quotes['isiQuotes'] ?></p>
                  <footer class="blockquote-footer fs-6">
                    <cite title="Source Title"><?= $quotes['kutipanQuotes'] ?></cite>
                  </footer>
                </blockquote>
              </div>
              <?php $i++; ?>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
      <ol class="list-group list-group-numbered">
        <li class="d-flex justify-content-center p-1 bg-white align-items-start rounded-top" style="background: linear-gradient(120deg,#d760ff,#4976ff);">
          <h2 class="text-white fs-5">Top Buku</h2>
        </li>
        <?php

        $bukuTop = query("SELECT * FROM buku ORDER BY jumlah_dipinjam DESC LIMIT 5");

        foreach ($bukuTop as $bT) :
        ?>
          <li class="list-group-item d-flex justify-content-center align-items-start gap-2">
            <div class="me-auto d-flex">
              <img src="../assets/images/<?= $bT['gambar'] ?>" alt="..." width="60rem" height="80rem" class="float-start">
              <div class="fw-semibold ms-2">
                <p class="mb-0" style="font-size: 1rem;"><?= $bT['nama'] ?></p>
                <span class="" style="font-size: small;">#Action #Fantasy</span>
              </div>
            </div>
          </li>
        <?php endforeach; ?>
      </ol>
      <!-- SLIDE GAMBAR -->
      <div id="carouselExampleControls" class="carousel slide mt-2" data-bs-ride="carousel">
        <div class="carousel-inner rounded rounded-4 border border-2">
          <?php
          $i = 1;
          foreach (query("SELECT * FROM carousel") as $carousel) : ?>
            <?php $active = ($i == 1) ? 'active' : '' ?>
            <div class="carousel-item <?= $active ?> ">

              <img src="../assets/carousel/<?= $carousel['namaCarousel'] ?>" class="d-block w-100" alt="...">

            </div>
            <?php $i++; ?>
          <?php endforeach; ?>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>
      <!-- AKHIR SLIDE GAMBAR -->
    </div>
    <!-- AKHIR BAGIAN KANAN -->
  </div>

  <!-- AWAL FOOTER -->
  <div class="bg-dark mt-3 p-1 pt-2 w-100" id="footer" style="margin-bottom: -2rem;">
    <?php include 'footerAdmin.php'; ?>
  </div>
  <!-- AKHIR FOOTER -->


  <script src="../assets/scripts/BS-JS/bootstrap.bundle.js"></script>

</body>

</html>