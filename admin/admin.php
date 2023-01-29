<?php
require '../koneksi.php';

// cek apakah sudah login belom
if (!(isset($_SESSION['loginAdmin']))) {
  // redirect (memindahkan user nya ke page lain)
  header("Location: ../login-daftar/login_admin.php");
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

    move_uploaded_file($_FILES['gambar']['tmp_name'], '../assets/images/' . $gambar);

    mysqli_query($conn, "INSERT INTO buku VALUES
      (NULL, '$judul', '$deskripsi', '$tglTerbit', 
      '$penerbit', '$penulis', '$gambar', '$jumlah', '0')");

    // var_dump($deskripsi);

  }
}

if (isset($_POST['tambahCarousel'])) {

  $namaCarousel = $_FILES['gambarCarousel']['name'];
  $ukuranCarousel = $_FILES['gambarCarousel']['size'];
  $rand = rand(1000, 9999);
  $extCarousel = explode('.', $namaCarousel);
  $extCarousel = array_pop($extCarousel);

  if ($ukuranCarousel <= 5000000) {

    $carousel = $rand . '.' . $extCarousel;

    move_uploaded_file($_FILES['gambarCarousel']['tmp_name'], '../assets/carousel/' . $carousel);

    mysqli_query($conn, "INSERT INTO carousel VALUES (NULL, '$carousel')");
  }
}

?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Home</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/styleAdmin.css">
</head>

<body>

  <?php include 'header-menu-admin.php'; ?>

  <!-- BAGIAN KIRI & DAFTAR BUKU -->
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

            <li class="list-buku-item list-group-item bg-white rounded rounded-4 border" style="box-shadow: 5px 5px 5px rgb(120, 120, 120);">
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
                        <button class="col btn btn-warning btn-sm rounded-pill text-white p-0" type="button" data-bs-toggle="modal" data-bs-target="#edit<?= $buku['id'] ?>">
                          <img src="../icon/edit1.png" width="20px" alt="">
                        </button>
                        <a href="hapusBuku.php?id=<?= $buku['id'] ?>" class="col btn btn-danger btn-sm rounded-pill">
                          <img src="../icon/bin.png" width="20px" alt="">
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
                                <img src="../assets/images/<?= $buku['gambar'] ?>" class="w-25 mb-2" alt="..." width="100%">
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
                                  <img src="../icon/multiply.png" width="20rem" alt="">
                                  Cancel
                                </button>
                                <button type="submit" class="btn btn-outline-primary py-1 px-4 pt-0 w-50">
                                  <img src="../icon/bookmark.png" width="20rem" alt="">
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
                  <img src="../assets/images/<?= $cariBuku['gambar'] ?>" class="img-fluid border rounded rounded-3" width="140rem" alt="...">
                </div>
                <div class="col-md-6 w-75">
                  <div class="card-body p-1">
                    <h5 class="card-title "><?= $cariBuku['nama'] ?></h5>
                    <p class="fw-light fs-6 mb-0"><?= $cariBuku['deskripsi'] ?></p>
                    <div class="d-grid gap-2 px-2 pt-2">
                      <div class="row gap-2">
                        <button class="col btn btn-warning btn-sm rounded-pill text-white p-0" type="button" data-bs-toggle="modal" data-bs-target="#edit<?= $cariBuku['id'] ?>">
                          <img src="../icon/edit1.png" width="20px" alt="">
                        </button>
                        <a href="hapusBuku.php?id=<?= $cariBuku['id'] ?>" class="col btn btn-danger btn-sm rounded-pill">
                          <img src="../icon/bin.png" width="20px" alt="">
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
                                <img src="../assets/images/<?= $cariBuku['gambar'] ?>" class="w-25 mb-2" alt="..." width="100%">
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
                                  <img src="../icon/multiply.png" width="20rem" alt="">
                                  Cancel
                                </button>
                                <button type="submit" class="btn btn-outline-primary py-1 px-4 pt-0 w-50">
                                  <img src="../icon/bookmark.png" width="20rem" alt="">
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
    <!-- BAGIAN KANAN -->
    <div class="col-12 col-md-4 mt-4">

      <form action="" method="GET" class="input-group mb-2" role="search">
        <input class="form-control border-primary mt-2 rounded-pill" type="search" placeholder="Search" aria-label="Search" name="halCari">

        <!-- <button class="btn btn-primary mt-2 rounded-start rounded-pill">Cari</button> -->
      </form>
      <div class="mt-0 mb-3 bg-white rounded-3 px-2">
        <div id="quotes" class="carousel slide" data-bs-ride="carousel">
          <div class="carousel-inner">
            <?php $i = 1; ?>
            <?php foreach ( query("SELECT * FROM quotes") as $quotes ) : ?>
              <?php $active = ( $i == 1 ) ? 'active' : '' ?>
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
      <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#tambahCarousel">
        Tambah Gambar
      </button>
      <!-- SLIDE GAMBAR -->
      <div id="carouselExampleControls" class="carousel slide mt-2" data-bs-ride="carousel">
        <div class="carousel-inner rounded rounded-4 border border-2">
          <?php
          $i = 1;
          foreach (query("SELECT * FROM carousel") as $carousel) : ?>
            <?php $active = ( $i == 1 ) ? 'active' : '' ?>
            <div class="carousel-item <?= $active ?> ">
              <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#editCarousel<?= $carousel['idCarousel'] ?>">
                Edit
              </button>
              <img src="../assets/carousel/<?= $carousel['namaCarousel'] ?>" class="d-block w-100" alt="...">
              <button type="button" class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#hapusCarousel<?= $carousel['idCarousel'] ?>">
                Hapus
              </button>
            </div>
            <!-- POP UP EDIT CAROUSEL -->
            <div class="modal fade" id="editCarousel<?= $carousel['idCarousel'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">EDIT</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <form action="editCarousel.php" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                      <img src="../assets/carousel/<?= $carousel['namaCarousel'] ?>" alt="..." class="w-100">
                      <input type="file" name="gambarCarousel">
                      <input type="hidden" name="idCarousel" value="<?= $carousel['idCarousel'] ?>">
                    </div>
                    <div class="modal-footer">
                      <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary">Understood</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <!-- POP UP HAPUS CAROUSEL -->
            <div class="modal fade" id="hapusCarousel<?= $carousel['idCarousel'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Konfirmasi Hapus</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <form action="hapusCarousel.php" method="post">
                    <div class="modal-body">
                      <img src="../assets/carousel/<?= $carousel['namaCarousel'] ?>" alt="..." class="w-100">
                      <input type="hidden" name="idCarousel" value="<?= $carousel['idCarousel'] ?>">
                    </div>
                    <div class="modal-footer">
                      <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary">Understood</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <?php $i++; ?>
          <?php endforeach; ?>
          <!-- POP UP TAMBAH CAROUSEL -->
          <div class="modal fade" id="tambahCarousel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Gambar Carousel</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="admin.php" method="post" enctype="multipart/form-data">
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


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>