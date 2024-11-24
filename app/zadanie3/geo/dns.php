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
        <h1>Test działania DNS Lookup</h1>
        <a href="../index.php">Powrót do strony głównej laboratorium</a>
        <hr />



        <pre><?php
            $result = dns_get_record("pbs.edu.pl");
            print_r($result);
            ?>

            <?php
            $ip = gethostbyname('pbs.edu.pl');
            echo $ip . '<BR />';
            $ip = $_SERVER["REMOTE_ADDR"];
            echo $ip. '<BR />';
            $hostname = gethostbyaddr("8.8.8.8");
            echo $hostname. '<BR />';
            $hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
            echo $hostname;
        ?></pre>
    </div>
</body>
</html>