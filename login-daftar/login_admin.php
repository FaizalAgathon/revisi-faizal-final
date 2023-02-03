<?php


require '../koneksi.php';
// var_dump($_SESSION['loginAdmin']);
if (isset($_SESSION['loginAdmin'])) {
  header("Location: ../admin/");
  exit;
}

// Cek apakah sudah login atau belom

if (isset($_POST['loginAdmin']) || isset($_SESSION['username'])) {


  $_SESSION['username'] = $_POST['username'];
  $_SESSION['password'] = $_POST['password'];


  $result = mysqli_query($conn, "SELECT * FROM admin WHERE username= '{$_SESSION['username']}'");

  if (mysqli_num_rows($result) === 1) {

    foreach ($result as $row) {
      if ($row['username'] == $_SESSION['username'] && $row['password'] == $_SESSION['password']) {
        header("Location: ../admin/");
        $_SESSION['loginAdmin'] = true;
        exit;
      }
    }
  }
}

$eror = true;

if ($eror && isset($_POST['loginAdmin'])) {
?>
  <script type="text/javascript">
    alert("Username atau Password tidak valid");
  </script>
<?php
}

?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>LogIn Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link rel="stylesheet" href="../assets/css/login/login_style.css">
</head>

<body>

  <form action="" method="post" class="m-auto my-5 p-3 rounded-5">
    <div class="d-flex justify-content-center m-0">
      <img src="../assets/images/SMKN-1-Cirebon.png" alt="...">
    </div>

    <h2 class="text-center pb-3">Login Admin</h2>

    <div class="mb-3 px-3 mt-5">
      <label for="exampleInput1" class="form-label">Username :</label>
      <input type="text" name="username" class="form-control border-0 border-bottom" id="exampleInput1" aria-describedby="emailHelp">
    </div>

    <div class="mb-3 px-3">
      <label for="exampleInputPassword1" class="form-label">Password :</label>
      <input type="password" name="password" class="form-control border-0 border-bottom" id="exampleInputPassword1">
    </div>

    <br>

    <div class="d-grid gap-2">
      <input type="hidden" name="loginAdmin" value="---">
      <button type="submit" name="login" class="btn rounded-pill text-white fw-bold">Login</button>
    </div>

    <footer class="main-footer " style="padding-top: 10px;">
      <div class="text-center">
        <a href="http://smkn1-cirebon.sch.id" class="txt2 hov1 text-decoration-none text-dark nav-link disabled" target="_blank">
          © 2022 SMK Negeri 1 Cirebon
        </a>
      </div>
    </footer>

    <p class="text-center"><small>- Support By XI RPL 2 -</small></p>

  </form>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>