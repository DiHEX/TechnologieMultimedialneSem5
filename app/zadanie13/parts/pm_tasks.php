<?php
$db = mysqli_connect("mysql-db", "root", "secret", "tm_mysql_zadanie13");

function get_pracownik_name_by_id($pracownik_id) {
    global $db;
    $pracownik_sql = "SELECT login FROM pracownicy WHERE id_pracownika=?";
    $pracownik_query = $db->prepare($pracownik_sql);
    $pracownik_query->bind_param("i", $pracownik_id);
    $pracownik_query->bind_result($login);
    $pracownik_query->execute();
    $pracownik_query->store_result();
    $pracownik_query->fetch();
    return $login;
}

$task_sql = "SELECT id_zadania, nazwa_zadania FROM zadanie WHERE id_pracownika=?";
$task_query = $db->prepare($task_sql);
$task_query->bind_param("i", $_SESSION["todo-userid"]);
$task_query->bind_result($task_id, $task_name);
$task_query->execute();
$task_query->store_result();
while ($task_query->fetch()) {
    echo "<div>";
    echo "<strong>$task_name</strong>";
    echo "<ul>";
    $subtask_sql = "SELECT id_podzadania, id_pracownika, nazwa_podzadania, stan FROM podzadanie WHERE id_zadania=?";
    $subtask_query = $db->prepare($subtask_sql);
    $subtask_query->bind_param("i", $task_id);
    $subtask_query->bind_result($subtask_id, $pracownik_id, $subtask_name, $subtask_state);
    $subtask_query->execute();
    $subtask_query->store_result();
    while ($subtask_query->fetch()) {
        $pracownik_name = get_pracownik_name_by_id($pracownik_id);
        if ($subtask_state == 100) {
            echo "<li style='color: green'>";
        } 
        else if ($subtask_state >= 0 && $subtask_state < 100) {
            echo "<li style='color: black'>";
        } 
        else {
            echo "<li style='color: red'>";
        }

        echo "$subtask_name ($subtask_state%) -> $pracownik_name
            
            <form action='/zadanie13/parts/pm_update_percentage.php' method='post'>
                <input type='hidden' name='subtask_id' value='$subtask_id' />
                <input type='range' name='subtask_new_state' min='0' max='100' value='$subtask_state' step='1' />
                <input type='submit' value='Aktualizuj' class='btn btn-primary btn-sm' />
            </form>
        </li>";
    }
    echo "</ul>";
    echo "</div>";
}