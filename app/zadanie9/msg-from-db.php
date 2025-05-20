<?php
session_start();
if (!isset($_SESSION["zadanie9-logged-in"])) {
    http_response_code(401);
    exit();
}

// ZWALNIAMY BLOKADĘ SESJI
session_write_close();

// połączenie
$db = mysqli_connect("mysql-db", "root", "secret", "tm_mysql_zadanie9");
if (!$db) {
    http_response_code(500);
    exit("DB error: ".mysqli_connect_error());
}

// nagłówki SSE
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
header('Connection: keep-alive');

// wyłącz buforowanie PHP i kompresję
ini_set('output_buffering',  'off');
ini_set('zlib.output_compression', false);
while (ob_get_level() > 0) { ob_end_flush(); }
ob_implicit_flush(true);
ignore_user_abort(true);

// przygotuj filtr
$user      = mysqli_real_escape_string($db, $_SESSION["zadanie9-logged-in"]);
$where     = $user === 'admin' ? '' : "WHERE recipient='$user'";
$lastId    = 0;

// pętla SSE
while (!connection_aborted()) {
    $q = "SELECT idk, datetime, message, user, attachment_url 
          FROM messages 
          $where AND idk > $lastId 
          ORDER BY idk ASC";
    $res = mysqli_query($db, $q);
    while ($row = mysqli_fetch_assoc($res)) {
        $lastId = (int)$row['idk'];
        $json   = json_encode([
            'id'             => $lastId,
            'date'           => $row['datetime'],
            'message'        => $row['message'],
            'user'           => $row['user'],
            'attachment_url' => $row['attachment_url']
        ]);
        echo "data: {$json}\n\n";
    }
    flush();
    sleep(1);
}

mysqli_close($db);