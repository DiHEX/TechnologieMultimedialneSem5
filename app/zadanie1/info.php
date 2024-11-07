<?php
    session_start();
    if (!isset($_SESSION['loggedin']))
    {
        header('Location: zadanie.php');
        exit();
    }
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    </head>
    <p>Jesteś zalogowany</p>
    <?php
        echo "User: {$_SESSION['userName']}.";
    ?>
    <br>
    <a href="logout.php">Wyloguj</a>
</HTML>