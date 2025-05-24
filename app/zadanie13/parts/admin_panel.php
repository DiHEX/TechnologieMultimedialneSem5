<h2 style="margin-top: 14px;">Wszystkie zadania</h2>

<?php
$db = mysqli_connect("mysql-db", "root", "secret", "tm_mysql_zadanie13");

$task_sql = "SELECT id_zadania, id_pracownika, nazwa_zadania FROM zadanie";
$task_query = $db->prepare($task_sql);
$task_query->bind_result($task_id, $pracownik_id, $task_name);
$task_query->execute();
$task_query->store_result();

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
        } else if ($subtask_state >= 0 && $subtask_state < 100) {
            echo "<li style='color: black'>";
        } else {
            echo "<li style='color: red'>";
        }

        echo "$subtask_name ($subtask_state%) -> $pracownik_name
        </li>";
    }
    echo "</ul>";
    echo "</div>";
}

?>

<h2 style="margin-top: 14px;">Historia logowania</h2>
<?php
$login_sql = "SELECT id_pracownika, datetime, state FROM logowanie";
$login_query = $db->prepare($login_sql);
$login_query->bind_result($pracownik_id, $datetime, $state);
$login_query->execute();
$login_query->store_result();
while ($login_query->fetch()) {
    if ($pracownik_id == null) {
        $pracownik_name = "nierozpoznana próba logowania";
    } else {
        $pracownik_name = get_pracownik_name_by_id($pracownik_id);
    }

    if ($state == "succeeded") {
        echo "<li style='color: green'>";
    } else {
        echo "<li style='color: red'>";
    }
    echo "$pracownik_name -> $datetime";
    echo "</li>";
}