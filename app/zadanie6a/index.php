<?php
session_start();
if (! isset($_SESSION["zadanie6a-logged-in"])) {
    header("Location: /zadanie6a/auth/login-form.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kalinowski</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link href="/assets/global.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1>Lab 6a</h1>
    <a href="/">Powrót do strony głównej</a>
    <hr />

    <ol class="choice-list">
        <li><a href="songs-show.php">Lista dostępnych piosenek</a></li>
    </ol>

    <?php include "auth/logout-form.php" ?>
</div>
</body>
</html>
