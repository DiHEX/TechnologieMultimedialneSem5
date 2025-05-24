<?php
$db = mysqli_connect("mysql-db", "root", "secret", "tm_mysql_zadanie13");

session_start();

$task_name = $_POST["task_name"];
$subtask_count = $_POST["subtask_count"];
$subtask_names = $_POST["subtask_names"];
$subtask_assignees = $_POST["subtask_assignees"];

$task_sql = "INSERT INTO zadanie(id_zadania, id_pracownika, nazwa_zadania) VALUES (NULL, ?, ?)";
$task_query = $db->prepare($task_sql);
$task_query->bind_param("is", $_SESSION["todo-userid"], $task_name);
$task_query->execute();
$task_id = $task_query->insert_id;

for ($i = 0; $i < intval($subtask_count); $i++) {
    $subtask_sql = "INSERT INTO podzadanie(id_podzadania, id_zadania, id_pracownika, nazwa_podzadania, stan) VALUES (NULL, ?, ?, ?, 0)";
    $subtask_query = $db->prepare($subtask_sql);
    $subtask_query->bind_param("iis", $task_id, $subtask_assignees[$i], $subtask_names[$i]);
    $subtask_query->execute();
}

header("Location: /zadanie13");