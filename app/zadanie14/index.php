<?php
session_start();
if (! isset($_SESSION["zadanie14-logged-in"])) {
    header("Location: /zadanie14/auth/login-form.php");
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link href="/assets/global.css" rel="stylesheet">
    <style>p{margin: 0; padding: 0;}</style>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>
</head>
<body>
<div class="container">
    <h1>Zadanie 14</h1>
    <a href="/">Powrót do strony głównej</a>
    <hr />

    <div style="padding: 0; margin: 0;">
        <?php
        include "auth/logout-form.php";
        $db = mysqli_connect("mysql-db", "root", "secret", "tm_mysql_zadanie14");
        ?>
    </div>

    <div style="padding: 0; margin: 0;">
        Twoja ranga: <b><?php echo $_SESSION["zadanie14-rank"]; ?></b><br/>
        Twoje ID użytkownika: <b><?php echo $_SESSION["zadanie14-userid"]; ?></b>
    </div>

    <?php
    if ($_SESSION["zadanie14-rank"] == "coach") {
        include "coach_view.php";
    } else if ($_SESSION["zadanie14-rank"] == "admin") {
        include "admin_view.php";
    } else {
        include "pracownik_view.php";
    }
    ?>
</body>
</html>
