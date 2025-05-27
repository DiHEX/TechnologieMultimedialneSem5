<?php
session_start();

$db = mysqli_connect("mysql-db", "root", "secret", "tm_mysql_zadanie15");
if ($db->connect_error) throw new InvalidArgumentException("Database error");

$ticket_content = $_POST["ticket-answer-content"];
$ticket_id = $_POST["ticket-answer-id"];
$ticket_employee_id = $_SESSION["crm-user-id"];

$update_ticket_query = $db->prepare("UPDATE tickets SET employee_id=?, response=? WHERE id=?");
$update_ticket_query->bind_param("isi", $ticket_employee_id, $ticket_content, $ticket_id);
$update_ticket_query->execute();

header("Location: /zadanie15");