<?php
session_start();
if (! isset($_SESSION["zadanie5-logged-in"])) {
    header("Location: /zadanie5");
    exit();
}

$currentSubDir = $_GET["subdir"] ?? "";
$filename = $_GET["filename"];
$basePath = "/var/www/html/user_storage/{$_SESSION["zadanie5-logged-in"]}";
$fullPath = $basePath . $currentSubDir . "/" . $filename;


unlink($fullPath);
header("Location: /zadanie5/browse-files.php?subdir=$currentSubDir");
?>