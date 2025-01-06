<?php
session_start();

$db = mysqli_connect("mysql-db", "root", "secret", "tm_mysql_database");
if ($db->connect_error) throw new InvalidArgumentException("Database error");

$current_user_name = $_SESSION["zadanie6a-logged-in"];
$current_user_idu = null;
$idu_query = $db->prepare("SELECT id, username FROM users WHERE username=?");
$idu_query->bind_param("s", $current_user_name);
$idu_query->execute();
$idu_query->bind_result($current_user_idu, $current_user_name);
$idu_query->store_result();
$idu_query->fetch();

$song_title = $_POST["song-title"];
$song_musician = $_POST["song-musician"];
$song_file = $_FILES["song-file"];
$song_genre = $_POST["song-genre"];
$song_lyrics = $_POST["song-lyrics"] ?? "";
$song_date = date( 'Y-m-d H:i:s');

$file_name_split = explode(".", $song_file["name"]);
$file_extension = end($file_name_split);
$file_name = bin2hex(openssl_random_pseudo_bytes(10));

if (! in_array($file_extension, ["mp3", "wav", "ogg"])) {
    header("Location: /zadanie6a/songs-show.php?status=inv-ext");
    exit();
}

$path_base = "/var/www/html/songs";
$path_file = "$path_base/$file_name.$file_extension";
$path_url_file = "/songs/$file_name.$file_extension";
move_uploaded_file($song_file["tmp_name"], $path_file);

$idmt_query = $db->prepare("SELECT idmt FROM musictype WHERE name=?");
$idmt_query->bind_param("s", $song_genre);
$idmt_query->execute();
$idmt_query->bind_result($song_idmt);
$idmt_query->store_result();
$idmt_query->fetch();

$ins_query = "INSERT INTO songs(ids, title, musician, datetime, idu, filename, lyrics, idmt) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?)";
$ins_query = $db->prepare($ins_query);
$ins_query->bind_param("sssissi",$song_title, $song_musician,  $song_date, $current_user_idu, $path_url_file, $song_lyrics, $song_idmt);
$ins_query->execute();

header("Location: /zadanie6a/songs-show.php?status=add-song-success");