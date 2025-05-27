<?php
session_start();
$db = mysqli_connect("mysql-db", "root", "secret", "tm_mysql_zadanie14");
if ($db->connect_error) throw new InvalidArgumentException("Database error");

$lesson_name    = $_POST["lesson_name"];
$lesson_content = $_POST["lesson_content"];
$lesson_author  = $_SESSION["zadanie14-userid"];
$path_url_file  = ""; // opcjonalnie obsłuż upload pliku

$sql = $db->prepare(
    "INSERT INTO lekcje(idl, idc, nazwa, tresc, plik_multimedialny)
     VALUES (NULL, ?, ?, ?, ?)"
);
$sql->bind_param("isss",
    $lesson_author,
    $lesson_name,
    $lesson_content,
    $path_url_file
);
$sql->execute();

header("Location: index.php");