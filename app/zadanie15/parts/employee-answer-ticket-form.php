<h2>Tickety bez odpowiedzi</h2>

<?php

$db = mysqli_connect("mysql-db", "root", "secret", "tm_mysql_zadanie15");
if ($db->connect_error) throw new InvalidArgumentException("Database error");

$get_tickets_query = $db->prepare("SELECT id, kind, content FROM tickets WHERE employee_id IS NULL");
$get_tickets_query->execute();
$get_tickets_query->bind_result($id, $kind, $content);
$get_tickets_query->store_result();

echo "<table class='table'>";
echo "<tr>";
echo "<th>Typ</th>";
echo "<th>Treść</th>";
echo "<th>Twoja odpowiedź</th>";
echo "</tr>";
while($get_tickets_query->fetch()) {
    echo "<tr>";
    echo "<td>$kind</td>";
    echo "<td>$content</td>";
    echo "<td>
        <form action='/zadanie15/parts/employee-answer-ticket-handle.php' method='POST'>
            <input type='hidden' name='ticket-answer-id' value='$id'>
            <textarea type='text' name='ticket-answer-content' class='form-control'></textarea>
            <button type='submit' class='btn btn-success btn-sm'>Odpowiedz</button>
        </form>
    </td>";
    echo "</tr>";
}
echo "</table>";

$db->close();