<?php 

require '../../koneksi.php';

$idQuotes = $_POST['idQuotes'];
$isiQuotes = $_POST['isiQuotes'];
$kutipanQuotes = $_POST['kutipanQuotes'];

mysqli_query($conn, "UPDATE quotes SET
  isiQuotes = '$isiQuotes', kutipanQuotes = '$kutipanQuotes' WHERE idQuotes = $idQuotes");

header("Location: index.php");

