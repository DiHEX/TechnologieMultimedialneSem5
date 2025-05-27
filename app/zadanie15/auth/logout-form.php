<?php

if (isset($_SESSION["crm-logged-in"])) {
    $username = $_SESSION['crm-logged-in'];
    echo "<p>Jesteś zalogowany jako $username. <a href='/zadanie15/auth/logout-handle.php'>Wyloguj mnie!</a></p>";
} else {
    echo "<p>Nie jesteś zalogowany. Zaloguj się!</p>";
}
?>

