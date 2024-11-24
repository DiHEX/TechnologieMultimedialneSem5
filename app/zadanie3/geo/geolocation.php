<?php
    session_start();
    if (!isset($_SESSION["loggedin"])) {
        header('Location: ../zadanie.php');
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
    <h1>Geolokalizacja bieżącego użytkownika</h1>
    <a href="index.php">Wróć</a>
    <hr />


    <?php
    $ipaddress = $_SERVER["REMOTE_ADDR"];
    function ip_details($ip) {
        $json = file_get_contents ("http://ipinfo.io/{$ip}/geo?token=81c0bb66023284");
        $details = json_decode ($json);
        return $details;
    }
    $details = ip_details($ipaddress);
    echo $details -> region; echo '<BR />';
    echo $details -> country; echo '<BR />';
    echo $details -> city; echo '<BR />';
    echo $details -> loc; echo '<BR />';
    echo $details -> ip; echo '<BR />';
    ?>
</div>
</body>
</html>
