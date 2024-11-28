<?php
session_start();
if (! isset($_SESSION["zscan-logged-in"])) {
    header("Location: /zadanie4/auth/login-form.php");
    exit();
}

$id = $_GET['id'];
$polaczenie = mysqli_connect("mysql-db", "root", "secret", "tm_mysql_database");
if (!$polaczenie) {
    echo "Błąd połączenia z MySQL." . PHP_EOL;
    echo "Errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}
$rezultat = mysqli_query($polaczenie, "DELETE FROM hosts WHERE id=$id") or die ("Błąd zapytania do bazy: $dbname");

header("Location: /zadanie4/index1.php");