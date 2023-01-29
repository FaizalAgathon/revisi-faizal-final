<?php

session_start();
$_SESSION = [];
session_unset();
session_destroy();

if ( isset($_POST['logoutUser']) ){
    header("Location: login_siswa.php");
}

if ( isset($_POST['logoutAdmin']) ){
    header("Location: login_admin.php");
}