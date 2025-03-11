<?php
$db = mysqli_connect("mysql-db", "root", "secret", "tm_mysql_zadanie7");
if (!$db)
{
    echo "SQL error 1." . PHP_EOL;
    echo "Errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

$x1 = $_POST["x1"];
$x2 = $_POST["x2"];
$x3 = $_POST["x3"];
$x4 = $_POST["x4"];
$x5 = $_POST["x5"];
mysqli_query($db, "UPDATE pomiary SET x1=$x1, x2=$x2, x3=$x3, x4=$x4, x5=$x5") or die ("SQL error 2: $dbname");

header("Location: /zadanie7b/formularz.php");