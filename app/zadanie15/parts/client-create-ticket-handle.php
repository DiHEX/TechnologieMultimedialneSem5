<?php
session_start();

$db = mysqli_connect("mysql-db", "root", "secret", "tm_mysql_zadanie15");
if ($db->connect_error) throw new InvalidArgumentException("Database error");

$ticket_kind = $_POST["ticket-create-kind"];
$ticket_content = $_POST["ticket-create-content"];
$ticket_client_id = $_SESSION["crm-user-id"];

$get_tickets_query = $db->prepare("INSERT INTO tickets (kind, client_id, content) VALUES (?, ?, ?)");
$get_tickets_query->bind_param("sis", $ticket_kind, $ticket_client_id, $ticket_content);
$get_tickets_query->execute();

header("Location: /zadanie15");