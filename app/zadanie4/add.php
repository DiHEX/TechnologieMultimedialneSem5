<?php
session_start();
if (! isset($_SESSION["zscan-logged-in"])) {
    header("Location: /zadanie4/auth/login-form.php");
    exit();
}


$polaczenie = mysqli_connect("mysql-db", "root", "secret", "tm_mysql_database");
if (!$polaczenie)
{
    echo "SQL error 1." . PHP_EOL;
    echo "Errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

$host = $_POST["host"];
$port = $_POST["port"];
$userID = $_SESSION["zscan-user-id"];

mysqli_query($polaczenie, "INSERT INTO hosts (host, port, userId) VALUES ('$host', $port, $userID)") or die ("SQL error 2: " . mysqli_error($polaczenie));

header("Location: /zadanie4/index1.php");