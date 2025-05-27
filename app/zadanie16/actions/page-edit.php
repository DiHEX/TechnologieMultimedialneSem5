<?php

session_start();

$subpage_name = $_POST["subpage-name"];
$html = $_POST["html-contents"];
$connection = mysqli_connect("mysql-db", "root", "secret", "tm_mysql_zadanie16");
$select_query = $connection->prepare("UPDATE contents SET html_contents=? WHERE subpage_name=?");
$select_query->bind_param("ss", $html, $subpage_name);
$select_query->execute();

header("Location: /zadanie16/index.php?page=$subpage_name");
