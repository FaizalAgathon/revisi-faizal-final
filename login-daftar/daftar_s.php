<?php require '../koneksi.php'; ?> 

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Daftar Siswa</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link rel="stylesheet" href="css/login_s.css">
</head>

<body>
  <form action="login_siswa.php" method="post" class="m-auto mb-1 mt-3 p-3 rounded-5">
    <div class="d-flex justify-content-center m-0">
      <img src="../../peminjaman_buku/assets/images/SMKN 1 Cirebon.png" alt="">
    </div>
    <h2 class="text-center pb-3 mb-0">Daftar Siswa</h2>
    <div class="mb-3 px-3 mt-3">
      <label for="nama" class="form-label">Nama :</label>
      <input type="text" name="nama" class="form-control border-0 border-bottom" id="nama" aria-describedby="emailHelp" value="">
    </div>
    <div class="mb-3 px-3">
      <label for="kelas" class="form-label">Kelas :</label>
      <select class="form-select w-50" aria-label="Default select example" name="kelas">
        <option selected value="---">Kelas</option>
        <?php foreach (query("SELECT * FROM kelas") as $kelas) : ?>
          <option value="<?= $kelas['namaKelas'] ?>"><?= $kelas['namaKelas'] ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="mb-3 px-3">
      <label for="kontak" class="form-label">Kontak :</label>
      <input type="number" name="kontak" class="form-control border-0 border-bottom" id="kontak" value="">
    </div>
    <br>
    <div class="d-grid gap-2">
      <input type="hidden" name="daftar" value="---">
      <button type="submit" name="login" class="btn rounded-pill text-white fw-bold login">Daftar</button>
    </div>
    <footer class="main-footer " style="padding-top: 10px;">
      <div class="text-center">
        <small>Sudah Punya Akun?
          <a href="login_siswa.html" class="fs-6 text-decoration-none">Login!!!</a>
        </small>
        <br>
        <a href="http://smkn1-cirebon.sch.id" class="text-decoration-none text-dark" target="_blank">
          © 2022 SMK Negeri 1 Cirebon
        </a>
      </div>
    </footer>
    <p class="text-center"><small>- Support By XI RPL 2 -</small></p>
  </form>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>