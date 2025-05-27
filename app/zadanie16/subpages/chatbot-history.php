<h2>Historia Chatbota</h2>

<?php

session_start();

$connection = mysqli_connect("mysql-db", "root", "secret", "tm_mysql_zadanie16");
$select_query = $connection->prepare("SELECT sender, content, date FROM chatbot_logs ORDER BY id DESC");
$select_query->bind_result($sender, $content, $date);
$select_query->execute();

while ($select_query->fetch()) {
    echo "<div style='margin-bottom: 10px;'><p><strong>$sender</strong> ($date):<br/>$content</p></div>";
}
