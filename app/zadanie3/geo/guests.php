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

if ($details->country != "PL") {
    echo "<p>Ta strona jest dostepna wylacznie dla uzytkownikow z Polski!</p>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link href="/assets/global.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Lista gości</h1>
        <a href="index.php">Wróć</a>
        <hr />

        <p style="font-weight: bold;">
            Ta strona jest zabezpieczona i jest dostępna wyłącznie z terytorium Polski.
        </p>

        <hr />

        <form method="POST" action="/z2/guests-add.php">
            <input type="submit" value="Dodaj wpis" class="btn btn-success" style="margin-bottom: 16px;" />
            <input type="hidden" value="" id="guest-screen-resolution" name="guest-screen-resolution" />
            <input type="hidden" value="" id="guest-browser-resolution" name="guest-browser-resolution" />
            <input type="hidden" value="" id="guest-colors" name="guest-colors" />
            <input type="hidden" value="" id="guest-cookies-enabled" name="guest-cookies-enabled" />
            <input type="hidden" value="" id="guest-java-enabled" name="guest-java-enabled" />
        </form>

        <script>
            document.getElementById("guest-screen-resolution").value = `${screen.width} x ${screen.height}`;
            document.getElementById("guest-browser-resolution").value = `${screen.availWidth} x ${screen.availHeight}`;
            document.getElementById("guest-colors").value = screen.colorDepth;
            document.getElementById("guest-cookies-enabled").value = navigator.cookieEnabled ? 1 : 0;
            document.getElementById("guest-java-enabled").value = window.navigator.javaEnabled() === true ? 1 : 0;
        </script>

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
            </tr>

            <?php
            $link = mysqli_connect("mysql-db", "root", "secret", "tm_mysql_database");
            $rs = mysqli_query($link, "SELECT * FROM goscieportalu");

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
                echo "</tr>";
            }

            mysqli_close($link);
            ?>
        </table>
    </div>
</body>
</html>