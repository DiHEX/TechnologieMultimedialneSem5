<h2>Wydajność pracowników</h2>

<?php
$db = $db = mysqli_connect("mysql-db", "root", "secret", "tm_mysql_zadanie15");
if ($db->connect_error) throw new InvalidArgumentException("Database error");

$clients_query = $db->prepare("SELECT user.username as name, COUNT(*) as tickets_answered, AVG(tickets.rating_stars) as average_rating FROM user, tickets WHERE user.userid = tickets.employee_id GROUP BY user.username");
$clients_query->execute();
$clients_query->bind_result($employee_name, $tickets_answered, $average_rating);

echo  "<ul>";
while ($clients_query->fetch()) {
    if ($tickets_answered <= 1) {
        $animal = "ŚLIMAKA";
    } else if ($tickets_answered <= 2) {
        $animal = "ŻÓŁWIA";
    } else if ($tickets_answered <= 3) {
        $animal = "CZŁOWIEKA";
    } else {
        $animal = "PUMĘ";
    }

    echo "<li>
           Pracownik <strong>$employee_name</strong> odpowiedział na <strong>$tickets_answered</strong> zgłoszeń.
           <br>
           Zasłużył na $animal.
           <br/>
           Jego średnia ocena to $average_rating.
           </li>";
}
echo "</ul>";