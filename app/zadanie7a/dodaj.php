<?php
$db = mysqli_connect("mysql-db", "root", "secret", "tm_mysql_zadanie7");
if (!$db)
{
    echo "SQL error 1." . PHP_EOL;
    echo "Errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

mysqli_query($db, "UPDATE ajax_from_db SET text1 = '$_POST[text1]'") or die ("SQL error 2: $dbname");

header("Location: /zadanie7a/formularz.php");