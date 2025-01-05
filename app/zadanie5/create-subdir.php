<?php
$currentSubDir = $_GET["subdir"] ?? "";
$baseDirPath = "/var/www/html/user_storage";
$dirPath = $baseDirPath . $currentSubDir . $_POST["newdir"];

mkdir($dirPath, 0777, true);

header("Location: browse-files.php?subdir=$currentSubDir");
?>