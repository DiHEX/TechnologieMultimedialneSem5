<?php

if (isset($_SESSION["zadanie9-logged-in"])) {
    $username = $_SESSION['zadanie9-logged-in'];
    echo "<p>Jesteś zalogowany jako $username. <a href='/zadanie9/auth/logout-handle.php'>Wyloguj</a></p>";
} else {
    echo "<p>Nie jesteś zalogowany. Zaloguj się</p>";
}
?>

