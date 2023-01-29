<?php

require '../koneksi.php';

if (isset($_POST['daftar'])) {
  $namaSiswa = $_POST['nama'];
  $kelasSiswa = $_POST['kelas'];
  $kontakSiswa = $_POST['kontak'];

  $idKelas = query("SELECT idKelas FROM kelas WHERE namaKelas = '$kelasSiswa'")[0];
  $daftarSiswa = mysqli_query($conn, "INSERT INTO siswa VALUES (NULL,$idKelas[idKelas],'$namaSiswa','$kontakSiswa')");
}

// Cek apakah sudah login atau belom

if( isset( $_SESSION['loginUser'] ) ){
  header("Location: ../user/home.php");
  exit;
}

if ( isset($_POST['login']) || isset($_SESSION['nama']) ) {

  if( !isset($_SESSION['nama']) ){
    $_SESSION['nama'] = $_POST['nama'];
    $_SESSION['kelas'] = $_POST['kelas'];
    $_SESSION['kontak'] = $_POST['kontak'];
  }
  

  $result = mysqli_query( $conn, "SELECT * FROM
                                  siswa s INNER JOIN
                                  kelas k ON s.idKelas = k.idKelas
                                  WHERE s.namaSiswa = '{$_SESSION['nama']}'" );

  if( mysqli_num_rows($result) === 1 ){

      foreach ( $result as $row ){
        if ( $row['namaSiswa'] == $_SESSION['nama'] && $row['namaKelas'] == $_SESSION['kelas']&& $row['kontakSiswa'] == $_SESSION['kontak'] ){
        header("Location: ../user/home.php");
        $_SESSION['loginUser'] = true;
        exit;
      }
    }
  }
  
}

$eror = true;

if ( $eror && isset($_POST['login']) ) {
  ?>
  <script type="text/javascript">alert("Username atau Password tidak valid");
  </script>
  <?php
}

?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login Siswa</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link rel="stylesheet" href="css/login_s.css">
</head>

<body>

  <form action="" method="post" class="m-auto mb-1 mt-3 p-3 rounded-5">
    
    <div class="d-flex justify-content-center m-0">
      <img src="../../peminjaman_buku/assets/images/SMKN 1 Cirebon.png" alt="">
    </div>

    <h2 class="text-center pb-3 mb-0">Login Siswa</h2>

    <div class="mb-3 px-3 mt-3">
      <label for="nama" class="form-label">Nama :</label>
      <input type="text" name="nama" class="form-control border-0 border-bottom" id="nama" aria-describedby="emailHelp" value="">
    </div>

    <div class="mb-3 px-3">
      <label for="kelas" class="form-label">Kelas :</label>
      <select class="form-select w-50" aria-label="Default select example" name="kelas">
        <option selected>Kelas</option>
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
      <input type="hidden" name="login" value="---">
      <button type="submit" name="login" class="btn rounded-pill text-white fw-bold login">Login</button>
    </div>

    <footer class="main-footer " style="padding-top: 10px;">
      <div class="text-center">
        <small>Belum Punya Akun?
          <a href="daftar_s.html" class="fs-6 text-decoration-none">Daftar disini</a>
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