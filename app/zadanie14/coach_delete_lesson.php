<?php

// Run SQL delete query on lessons
$db = mysqli_connect("mysql-db", "root", "secret", "tm_mysql_zadanie14");
if ($db->connect_error) throw new InvalidArgumentException("Database error");
$sql = $db->prepare("DELETE FROM lekcje WHERE idl=?");
$sql->bind_param("i", $_GET["idl"]);
$sql->execute();
header("Location: /zadanie14");