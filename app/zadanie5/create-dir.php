<?php
session_start();
if (! isset($_SESSION["zadanie5-logged-in"])) {
    header("Location: /zadanie5");
    exit();
}

$currentSubDir = $_GET["subdir"] ?? "";
$baseDirPath = "/var/www/html/user_storage/{$_SESSION["zadanie5-logged-in"]}";
$dirPath = $baseDirPath . $currentSubDir . "/" . $_POST["newdir"];

mkdir($dirPath, 0777, true);
header("Location: browse-files.php?subdir=$currentSubDir");
?>