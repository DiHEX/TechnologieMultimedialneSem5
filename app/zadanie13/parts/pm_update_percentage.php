<?php

$db = mysqli_connect("mysql-db", "root", "secret", "tm_mysql_zadanie13");

session_start();

$subtask_id = $_POST["subtask_id"];
$subtask_new_state = $_POST["subtask_new_state"];

$update_sql = "UPDATE podzadanie SET stan=? WHERE id_podzadania=?";
$update_query = $db->prepare($update_sql);
$update_query->bind_param("ii", $subtask_new_state, $subtask_id);
$update_query->execute();

header("Location: /zadanie13");

