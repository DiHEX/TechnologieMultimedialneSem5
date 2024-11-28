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
        <h1>Lab 3 - geolokalizacja</h1>
        <a href="../index.php">Powrót do strony głównej</a>
        <hr />

        <ol class="choice-list">
            <li><a href="./netstat.php">Netstat</a></li>
            <li><a href="./phpinfo.php">PHP info</a></li>
            <li><a href="./exec.php">Polecenia exec</a></li>
            <li><a href="./dns.php">DNS Lookup</a></li>
            <li><a href="./geolocation.php">Geolokacja </a></li>
            <li><a href="./guests.php">Lista gości</a></li>
        </ol>
    </div>
</body>
</html>
