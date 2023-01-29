
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
    <title>Add book</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/styletambah.css">
  </head>
  <body>

  <?php include 'header-menu-admin.php'; ?>

    <!-- AWAL FORM TAMBAH BUKU -->
    <div class="container mt-3 mb-3">
        <form action="admin.php" class="bg-light p-3 tambah w-50 m-auto rounded-4" method="POST" enctype="multipart/form-data">
            <div class="modal-body">
              <div class="mb-3">
                <label for="judul" class="form-label">Judul :</label>
                <input type="text" class="form-control rounded-4 border-bottom border-2" id="judul" name="judul">
              </div>
              <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi :</label>
                <input type="text" class="form-control rounded-4 border-bottom border-2" id="deskripsi" name="deskripsi">
              </div>
              <div class="mb-3">
                <label for="penerbit" class="form-label">Penerbit :</label>
                <input type="text" class="form-control rounded-4 border-bottom border-2" id="penerbit" name="penerbit">
              </div>
              <div class="mb-3">
                <label for="penulis" class="form-label">Penulis :</label>
                <input type="text" class="form-control rounded-4 border-bottom border-2" id="penulis" name="penulis">
              </div>
              <div class="mb-3">
                <label for="tglTerbit" class="form-label">Tanggal Terbit :</label>
                <input type="date" class="form-control rounded-4 border-bottom border-2 w-50" id="tglTerbit" name="tglTerbit">
              </div>
              <div class="mb-3">
                <label for="gambar" class="form-label">Gambar :</label>
                <input type="file" class="form-control form-control-sm w-50" id="gambar" name="gambar" accept=".png,.jpg,.jpeg,.gif,.JPG,.PNG,.JPEG,.GIF">
              </div>
              <div class="mb-3">
                <label for="jmlBuku" class="form-label">Jumlah Buku :</label>
                <input type="text" class="form-control rounded-4 border-3 w-25 py-0" id="jmlBuku" name="jumlah">
              </div>
            </div>
            <div class="modal-footer input-group border-0">
              <button type="reset" class="btn btn-light btn-sm align-center border w-50 rounded-pill rounded-end py-0 fw-semibold">
                <img src="../icon/cross-button.png" width="18rem" alt=""><br>
                Cancel
              </button>
              <input type="hidden" name="tambahBuku" value="---">
              <button type="submit" class="btn btn-light border btn-sm align-center w-50 rounded-pill rounded-start py-0 fw-semibold">
                <img src="../icon/upload.png" width="18rem" alt=""><br>
                Submit
              </button>
            </div>
          </form>
    </div>
    <!-- AKHIR FORM TAMBAH BUKU -->
        <!-- AWAL FOOTER -->
    <div class="bg-dark mt-3 p-1 pt-2 w-100" id="footer" style="margin-bottom: -2rem;">
      <?php include 'footerAdmin.php'; ?>
    </div>
    <!-- AKHIR FOOTER -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  </body>
</html>