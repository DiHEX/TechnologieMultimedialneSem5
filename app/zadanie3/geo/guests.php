<?php

    session_start();
    if (!isset($_SESSION["loggedin"])) {
        header('Location: ../zadanie.php');
        exit();
    }
    

function ip_details($ip) {
    $json = file_get_contents ("http://ipinfo.io/{$ip}/geo");
    $details = json_decode ($json);
    return $details;
}
$details = ip_details($_SERVER["REMOTE_ADDR"]);

?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link href="../bootstrap/twoj_css.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Lista gości</h1>
        <a href="index.php">Wróć</a>
        <hr />

        <table>
            <tr>
                <th>Id</th>
                <th>Ip</th>
                <th>Region</th>
                <th>Country</th>
                <th>City</th>
                <th>Location</th>
                <th>Date/time</th>
                <th>Browsername</th>
                <th>Screen resolution</th>
                <th>Browser resolution</th>
                <th>Colors</th>
                <th>Cookies enabled</th>
                <th>Java enabled</th>
                <th>Language</th>
                <th>Google Maps</th>
                <th>Ilosc odwiedzeń</th>
            </tr>

            <?php
            $link = mysqli_connect("mysql-db", "root", "secret", "tm_mysql_database");
            $rs = mysqli_query($link, "SELECT * FROM goscieportalu order by ilosc desc");

            while($row = mysqli_fetch_array($rs)) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['ipaddress'] . "</td>";
                echo "<td>" . $row['region'] . "</td>";
                echo "<td>" . $row['country'] . "</td>";
                echo "<td>" . $row['city'] . "</td>";
                echo "<td>" . $row['location'] . "</td>";
                echo "<td>" . $row['datetime'] . "</td>";
                echo "<td>" . $row['browsername'] . "</td>";
                echo "<td>" . $row['screenresolution'] . "</td>";
                echo "<td>" . $row['browserresolution'] . "</td>";
                echo "<td>" . $row['colors'] . "</td>";
                echo "<td>" . $row['cookiesenabled'] . "</td>";
                echo "<td>" . $row['java_enabled'] . "</td>";
                echo "<td>" . $row['language'] . "</td>";
                echo "<td><a href='https://www.google.pl/maps/place/{$row['location']}' target='_blank'>(link)</a></td>";
                echo "<td>" . $row['ilosc'] . "</td>";
                echo "</tr>";
            }

            mysqli_close($link);
            ?>
        </table>
    </div>
</body>
</html>