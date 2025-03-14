<?php
session_start();
if (!isset($_SESSION["zadanie9-logged-in"])) {
    echo "Event: error\n";
    echo "data: Session not started\n\n";
    exit();
}

$db = mysqli_connect("mysql-db", "root", "secret", "tm_mysql_zadanie9");
if (!$db) {
    echo "Event: error\n";
    echo "data: MySQL Connection error\n";
    echo "data: Errno: " . mysqli_connect_errno() . "\n";
    echo "data: Error: " . mysqli_connect_error() . "\n\n";
    exit();
}

header("Content-Type: text/event-stream");
header("Cache-Control: no-cache");

while (!connection_aborted()) {
    $recipient = $_SESSION["zadanie9-logged-in"];
    $where = $recipient == "admin" ? "" : "WHERE recipient='$recipient'";
    $rezultat = mysqli_query($db, "SELECT idk, datetime, message, user, attachment_url FROM messages $where ORDER BY idk DESC LIMIT 1") or die ("DB error: $dbname");

    while ($row = mysqli_fetch_array($rezultat)) {
        $id = $row[0];
        $date = $row[1];
        $message = $row[2];
        $user = $row[3];
        $attachment_url = $row[4];

        echo "data: {\"id\": \"$id\", \"date\": \"$date\", \"message\": \"$message\", \"user\": \"$user\", \"attachment_url\": \"$attachment_url\"}\n\n";
    }

    // flush the output buffer and send echoed messages to the browser
    while (ob_get_level() > 0) { ob_end_flush(); }
    flush();
    sleep(1); // Sleep for 1 second
}

mysqli_close($db);
?>