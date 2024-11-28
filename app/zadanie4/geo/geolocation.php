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
    <link href="../bootstrap/twoj_css.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1>Geolokalizacja bieżącego użytkownika</h1>
    <a href="index.php">Wróć</a>
    <hr />


    <?php
    $ipaddress = $_SERVER["REMOTE_ADDR"];
    function ip_details($ip) {
        $json = file_get_contents("http://ipinfo.io/{$ip}/geo");
        $details = json_decode($json);
        return $details;
    }
    $details = ip_details($ipaddress);
    echo "W zależności od adresu IP, nie wszystkie informacje mogą być dostępne.";  echo '<BR />';
    if (isset($details->region)) {
        echo $details->region; echo '<BR />';
    }
    if (isset($details->country)) {
        echo $details->country; echo '<BR />';
    }
    if (isset($details->city)) {
        echo $details->city; echo '<BR />';
    }
    if (isset($details->loc)) {
        echo $details->loc; echo '<BR />';
    }
    if (isset($details->ip)) {
        echo $details->ip; echo '<BR />';
    }
    ?>
</div>
</body>
</html>
