<?php 

require '../../koneksi.php';

$idQuotes = $_POST['idQuotes'];

mysqli_query($conn, "DELETE FROM quotes WHERE idQuotes = $idQuotes");

header("Location: index.php");