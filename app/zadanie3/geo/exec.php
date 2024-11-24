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
    <h1>Test działania funkcji exec</h1>
    <a href="index.php">Wróć</a>
    <hr />

    <?php
    echo exec ('whoami');
    ?>

    <?php
    exec ('TERM=xterm /usr/bin/top n 1 b i', $top, $error );
    echo nl2br(implode("\n",$top));
    if ($error){
        exec ('TERM=xterm /usr/bin/top n 1 b 2>&1', $error );
        echo "Error: ";
        exit ($error[0]);
    }
    ?>

    <?php
    $output = shell_exec ('ls -al');
    echo "<pre>$output</pre>";
    ?>
</div>
</body>
</html>