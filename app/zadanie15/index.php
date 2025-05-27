<?php
session_start();
if (!isset($_SESSION['crm-logged-in'])) {
    header("Location: /zadanie15/auth/login-form.php");
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

<?php
if (isset($_SESSION["crm-user-rank"]) && $_SESSION["crm-user-rank"] == "admins") {
    echo "<h1>Witaj, administratorze!</h1>";
    echo "<p>Witaj, " . $_SESSION["crm-logged-in"] . "!</p>";
    echo "<p>Twoja ranga: " . $_SESSION["crm-user-rank"] . "</p>";
    echo "<p>Twój identyfikator: " . $_SESSION["crm-user-id"] . "</p>";
    echo "<hr />";
    include "parts/admin-panel-display.php";
} else if (isset($_SESSION["crm-user-rank"]) && $_SESSION["crm-user-rank"] == "employees") {
    echo "<h1>Witaj, pracowniku!</h1>";
    echo "<p>Witaj, " . $_SESSION["crm-logged-in"] . "!</p>";
    echo "<p>Twoja ranga: " . $_SESSION["crm-user-rank"] . "</p>";
    echo "<p>Twój identyfikator: " . $_SESSION["crm-user-id"] . "</p>";
    echo "<hr />";
    include "parts/employee-answer-ticket-form.php";
    echo "<hr />";
    include "parts/employee-tickets-display.php";
} else if (isset($_SESSION["crm-user-rank"]) && $_SESSION["crm-user-rank"] == "clients") {
    echo "<h1>Witaj, kliencie!</h1>";
    echo "<p>Witaj, " . $_SESSION["crm-logged-in"] . "!</p>";
    echo "<p>Twoja ranga: " . $_SESSION["crm-user-rank"] . "</p>";
    echo "<p>Twój identyfikator: " . $_SESSION["crm-user-id"] . "</p>";
    echo "<hr />";
    include "parts/client-tickets-display.php";
    echo "<hr />";
    include "parts/client-create-ticket-form.php";
}
?>
<hr />

<h2>Wylogowanie</h2>
<?php include "auth/logout-form.php"; ?>

</body>
</html>
