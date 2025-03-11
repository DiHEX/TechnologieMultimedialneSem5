<?php
$db = mysqli_connect("mysql-db", "root", "secret", "tm_mysql_zadanie7");
if (!$db)
{
    echo "SQL error 1." . PHP_EOL;
    echo "Errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}
header("Content-Type: text/event-stream");
while (!connection_aborted())
{
    $rezultat = mysqli_query($db, "SELECT * FROM pomiary ORDER by id DESC Limit 1") or die ("SQL error 2: $dbname");
    while ($wiersz = mysqli_fetch_array ($rezultat))
    {
        $id = $wiersz[0];
        $x1 = $wiersz[1];
        $x2 = $wiersz[2];
        $x3 = $wiersz[3];
        $x4 = $wiersz[4];
        $x5 = $wiersz[5];
    }
    echo "data:<?xml version=\"1.0\" encoding=\"UTF-8\"?>\\n<pomiary><x1>$x1</x1><x2>$x2</x2><x3>$x3</x3><x4>$x4</x4><x5>$x5</x5></pomiary>\n\n";

    // flush the output buffer and send echoed messages to the browser
    while (ob_get_level() > 0) { ob_end_flush(); }
    flush();
    sleep(1); // Sleep for 1 seconds
}
mysqli_close($db);
?>