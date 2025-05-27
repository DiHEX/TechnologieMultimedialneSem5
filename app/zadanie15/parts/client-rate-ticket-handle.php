<?php
session_start();

$db = mysqli_connect("mysql-db", "root", "secret", "tm_mysql_zadanie15");
if ($db->connect_error) throw new InvalidArgumentException("Database error");

$ticket_id = $_POST["ticket-rate-id"];
$ticket_rating = $_POST["ticket-rate-rating"];

$update_ticket_query = $db->prepare("UPDATE tickets SET rating_stars=? WHERE id=?");
$update_ticket_query->bind_param("ii", $ticket_rating, $ticket_id);
$update_ticket_query->execute();

header("Location: /zadanie15");