<?php
session_start();

$db = mysqli_connect("mysql-db", "root", "secret", "tm_mysql_database");
if ($db->connect_error) throw new InvalidArgumentException("Database error");

$current_user_name = $_SESSION["zadanie6b-logged-in"];
$current_user_idu = null;
$idu_query = $db->prepare("SELECT id, username FROM users WHERE username=?");
$idu_query->bind_param("s", $current_user_name);
$idu_query->execute();
$idu_query->bind_result($current_user_idu, $current_user_name);
$idu_query->store_result();
$idu_query->fetch();

$film_title = $_POST["film-title"];
$film_director = $_POST["film-director"];
$film_file = $_FILES["film-file"];
$film_genre = $_POST["film-genre"];
$film_subtitle = $_POST["film-subtitle"] ?? "";
$film_date = date( 'Y-m-d H:i:s');

$file_name_split = explode(".", $film_file["name"]);
$file_extension = end($file_name_split);
$file_name = bin2hex(openssl_random_pseudo_bytes(10));

if (! in_array($file_extension, ["mp4", "mkv", "avi"])) {
    header("Location: /zadanie6b/films-show.php?status=inv-ext");
    exit();
}

$path_base = "/var/www/html/films";
$path_file = "$path_base/$file_name.$file_extension";
$path_url_file = "/var/www/html/films/$file_name.$file_extension";
move_uploaded_file($film_file["tmp_name"], $path_file);

$idft_query = $db->prepare("SELECT idft FROM filmtype WHERE name=?");
$idft_query->bind_param("s", $film_genre);
$idft_query->execute();
$idft_query->bind_result($film_idft);
$idft_query->store_result();
$idft_query->fetch();

$ins_query = "INSERT INTO films(ids, title, director, datetime, idu, filename, subtitle, idft) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?)";
$ins_query = $db->prepare($ins_query);
$ins_query->bind_param("sssissi",$film_title, $film_director,  $film_date, $current_user_idu, $path_url_file, $film_subtitle, $film_idft);
$ins_query->execute();

header("Location: /zadanie6b/films-show.php?status=add-song-success");