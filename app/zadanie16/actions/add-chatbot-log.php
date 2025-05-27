<?php
session_start();

$question = $_POST['question'];
$response = $_POST['response'];

$chatbot_date = date('Y-m-d H:i:s');
$sender_bot = "chatbot";
$sender_usr = isset($_SESSION['is-admin']) ? "admin" : "user";

session_start();
$connection = mysqli_connect("mysql-db", "root", "secret", "tm_mysql_zadanie16");

$query = $connection->prepare("INSERT INTO chatbot_logs (sender, content, date) VALUES (?, ?, ?)");
$query->bind_param("sss", $sender_usr, $question, $chatbot_date);
$query->execute();

$query = $connection->prepare("INSERT INTO chatbot_logs (sender, content, date) VALUES (?, ?, ?)");
$query->bind_param("sss", $sender_bot, $response, $chatbot_date);
$query->execute();
