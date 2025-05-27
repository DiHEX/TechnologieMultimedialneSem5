<?php
session_start();

$subpage_name = $_GET["subpage"];
$connection = mysqli_connect("mysql-db", "root", "secret", "tm_mysql_zadanie16");
$select_query = $connection->prepare("SELECT html_contents FROM contents WHERE subpage_name=?");
$select_query->bind_param("s", $subpage_name);
$select_query->bind_result($html_contents);
$select_query->execute();
$select_query->fetch();
echo $html_contents;
