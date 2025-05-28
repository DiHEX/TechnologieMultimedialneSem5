<?php
session_start();

$db = mysqli_connect("mysql-db", "root", "secret", "tm_mysql_zadanie16");
$logo_file = $_FILES["logo-input"];

$file_name_split = explode(".", $logo_file["name"]);
$file_extension = end($file_name_split);
$file_name = bin2hex(openssl_random_pseudo_bytes(10));

$assetsDir = __DIR__ . '/../assets';
if (!is_dir($assetsDir)) {
    mkdir($assetsDir, 0777, true);
}

$filename = "$file_name.$file_extension";
$pathOnDisk = "$assetsDir/$filename";
$urlPath    = "/zadanie16/assets/$filename";

move_uploaded_file($logo_file["tmp_name"], $pathOnDisk);

$stmt = $db->prepare("UPDATE logo SET filename=?");
$stmt->bind_param("s", $urlPath);
$stmt->execute();

header("Location: /zadanie16/index.php");