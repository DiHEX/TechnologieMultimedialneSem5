<?php
    session_start();
    if (!isset($_SESSION["zadanie9-logged-in"])) {
        header("Location: /zadanie9/auth/login-form.php?status=requires-login");
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
    <link href="/assets/global.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1>Zadanie 9</h1>
    <a href="/">Powrót do strony głównej</a>
    <hr />
    <ol class="choice-list">
        <li><a href="/zadanie9/msg-send-form.php">Komunikator</a></li>
        <li><a href="/zadanie9/msg-display-stats.php">Historia logowań</a></li>
    </ol>

    <?php include "auth/logout-form.php" ?>
</div>
</body>
</html>
