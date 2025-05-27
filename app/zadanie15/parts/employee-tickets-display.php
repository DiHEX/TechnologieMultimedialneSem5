<h2>Twoje tickety</h2>

<?php

$db = mysqli_connect("mysql-db", "root", "secret", "tm_mysql_zadanie15");
$employee_id = $_SESSION["crm-user-id"];
if ($db->connect_error) throw new InvalidArgumentException("Database error");

$get_tickets_query = $db->prepare("SELECT id, kind, client_id, employee_id, content, response, rating_stars FROM tickets WHERE employee_id=? AND employee_id IS NOT NULL");
$get_tickets_query->bind_param("i", $employee_id);
$get_tickets_query->execute();
$get_tickets_query->bind_result($id, $kind, $client_id, $employee_id, $content, $response, $rating_stars);
$get_tickets_query->store_result();

echo "<table class='table'>";
echo "<tr>";
echo "<th>Typ</th>";
echo "<th>Treść</th>";
echo "<th>Odpowiedź</th>";
echo "<th>Status</th>";
echo "<th>Ocena</th>";
echo "</tr>";
while($get_tickets_query->fetch()) {
    if ($rating_stars != null) {
        $ticket_status = "Zakończono.";
    } else if ($employee_id != null && $rating_stars == null) {
        $ticket_status = "Oczekiwanie na ocenę";
    } else if ($employee_id == null) {
        $ticket_status = "Oczekiwanie na odpowiedź pracownika";
    } else {
        $ticket_status = "Błąd";
    }

    echo "<tr>";
    echo "<td>$kind</td>";
    echo "<td>$content</td>";
    echo "<td>$response</td>";
    echo "<td>$ticket_status</td>";
    echo "<td>$rating_stars</td>";
    echo "</tr>";
}
echo "</table>";
