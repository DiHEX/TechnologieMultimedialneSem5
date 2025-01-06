<?php
session_start();

$db = mysqli_connect("mysql-db", "root", "secret", "tm_mysql_database");
if ($db->connect_error) throw new InvalidArgumentException("Database error");

$is_public = isset($_POST["playlist-public"]);
$playlist_name = $_POST["playlist-name"] ?? "";
$playlist_date = date( 'Y-m-d H:i:s');

if (!isset($_POST["playlist-film"])) {
    header("Location: /zadanie6b/films-show.php?status=no-films");
    exit;
}

$current_user_name = $_SESSION["zadanie6b-logged-in"];
$current_user_idu = null;
$idu_query = $db->prepare("SELECT id, username FROM users WHERE username=?");
$idu_query->bind_param("s", $current_user_name);
$idu_query->execute();
$idu_query->bind_result($current_user_idu, $current_user_name);
$idu_query->store_result();
$idu_query->fetch();

$name_query = $db->prepare("INSERT INTO playlistnameFilms(idpl, idu, name, public, datetime) VALUES (NULL, ?, ?, ?, ?)");
$name_query->bind_param("isis", $current_user_idu, $playlist_name, $is_public, $playlist_date);
$name_query->execute();
$playlist_id = $name_query->insert_id;

foreach ($_POST["playlist-film"] as $film_number) {
    $film_query = $db->prepare("INSERT INTO playlistdatabaseFilms(idpldb, idpl, ids) VALUES (NULL, ?, ?)");
    $film_query->bind_param("ii", $playlist_id, $film_number);
    $film_query->execute();
}

header("Location: /zadanie6b/films-show.php#playlist-show");