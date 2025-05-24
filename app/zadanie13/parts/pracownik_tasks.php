<?php
$db = mysqli_connect("mysql-db", "root", "secret", "tm_mysql_zadanie13");

function get_task_name_by_task_id($task_id) {
    global $db;
    $task_sql = "SELECT nazwa_zadania FROM zadanie WHERE id_zadania=?";
    $task_query = $db->prepare($task_sql);
    $task_query->bind_param("i", $task_id);
    $task_query->bind_result($task_name);
    $task_query->execute();
    $task_query->store_result();
    $task_query->fetch();
    return $task_name;
}

$task_sql = "SELECT id_podzadania, id_zadania, nazwa_podzadania, stan FROM podzadanie WHERE id_pracownika=?";
$task_query = $db->prepare($task_sql);
$task_query->bind_param("i", $_SESSION["todo-userid"]);
$task_query->bind_result($subtask_id, $task_id, $subtask_name, $task_state);
$task_query->execute();
$task_query->store_result();

echo "<ul>";
while ($task_query->fetch()) {
    $task_name = get_task_name_by_task_id($task_id);
    if ($task_state == 100) {
        echo "<li style='color: green'>"; 
    }
    else if ($subtask_state >= 0 && $subtask_state < 100) {
            echo "<li style='color: black'>";
    } 
    else {
        echo "<li style='color: red'>";
    }
    echo "$task_name -> $subtask_name ($task_state%)";
    echo "</li>";
}
echo "</ul>";
