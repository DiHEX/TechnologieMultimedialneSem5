<?php
    session_start();
    if (!isset($_SESSION["loggedin"])) {
        header('Location: ../zadanie.php');
        exit();
    }
    echo "<a href=\"index.php\">Wróć</a>\n";
    echo phpinfo();
?>