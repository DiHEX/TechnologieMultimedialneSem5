<?php
session_start();
if (!isset($_SESSION['todo-logged-in'])) {
    header("Location: /zadanie13/auth/login-form.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalinowski</title>

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" />
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        p {
            margin: 0;
        }
    </style>
</head>
<body class="container" style="margin-top: 30px; margin-bottom: 30px;">

    <h2>Wylogowanie</h2>
    <?php include "auth/logout-form.php"; ?>

    <?php
    // If user is admin
    if ($_SESSION["todo-logged-in"] == "admin") {
        include "parts/admin_panel.php";
    } else {
    ?>

    <h2>Tworzenie zadania</h2>
    <?php include "parts/task_create_form.php"; ?>

    <h2 style="margin-top: 14px;">Twoje zadania (jako proj. manager)</h2>
    <?php include "parts/pm_tasks.php"; ?>

    <h2>Twoje zadania (jako pracownik)</h2>
    <?php include "parts/pracownik_tasks.php"; ?>

    <?php } ?>

</body>
</html>

