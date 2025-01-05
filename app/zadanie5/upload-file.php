<?php
session_start();
if (! isset($_SESSION["zadanie5-logged-in"])) {
    header("Location: /zadanie5");
    exit();
}

$baseDirPath = "/var/www/html/user_storage/{$_SESSION["zadanie5-logged-in"]}";
$dirPath = $baseDirPath . $_GET["subdir"];

$basename = basename($_FILES["newfile"]["name"]);

$fullPath = $dirPath . "/" . $basename;

move_uploaded_file($_FILES["newfile"]["tmp_name"], $fullPath);
header("Location: browse-files.php?subdir={$_GET["subdir"]}");
?>