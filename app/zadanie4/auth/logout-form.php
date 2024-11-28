<?php
if (isset($_SESSION["zscan-logged-in"])) {
    $username = $_SESSION['zscan-logged-in'];
    echo "<p>Jesteś zalogowany jako $username. <a href='/zadanie4/auth/logout-handle.php'><br>Wyloguj</a></p>";
} else {
    echo "<p>Nie jesteś zalogowany. Zaloguj się.</p>";
}


