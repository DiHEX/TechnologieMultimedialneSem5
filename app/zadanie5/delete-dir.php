<?php
session_start();
if (! isset($_SESSION["zadanie5-logged-in"])) {
    header("Location: /zadanie5");
    exit();
}

function recurseRmdir($dir) {
    $files = array_diff(scandir($dir), array('.','..'));
    foreach ($files as $file) {
        (is_dir("$dir/$file") && !is_link("$dir/$file")) ? recurseRmdir("$dir/$file") : unlink("$dir/$file");
    }
    return rmdir($dir);
}

$currentSubDir = $_GET["subdir"] ?? "";
$subdirToDelete = $_GET["subdirToDelete"];
$baseDirPath = "/var/www/html/user_storage/user_storage/{$_SESSION["zadanie5-logged-in"]}";
$dirPath = $baseDirPath . $subdirToDelete;
recurseRmdir($dirPath);

header("Location: /zadanie5/browse-files.php?subdir=$currentSubDir");
?>