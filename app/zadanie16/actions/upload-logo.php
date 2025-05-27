<?php
session_start();

$db = mysqli_connect("mysql-db", "root", "secret", "tm_mysql_zadanie16");
$logo_file = $_FILES["logo-input"];

$file_name_split = explode(".", $logo_file["name"]);
$file_extension = end($file_name_split);
$file_name = bin2hex(openssl_random_pseudo_bytes(10));


$path_base = "/zadanie16/assets";
$path_file = "$path_base/$file_name.$file_extension";
$path_url_file = "/zadanie16/assets/$file_name.$file_extension";
move_uploaded_file($logo_file["tmp_name"], $path_file);

$idft_query = $db->prepare("UPDATE logo SET filename=?");
$idft_query->bind_param("s", $path_url_file);
$idft_query->execute();

header("Location: /zadanie16/index.php");