<?php
if (isset($_SESSION["zadanie6a-logged-in"])) {
    $username = $_SESSION['zadanie6a-logged-in'];
    echo "<p>Jesteś zalogowany jako $username. <a href='/zadanie6a/auth/logout-handle.php'>Wyloguj</a></p>";
} else {
    echo "<p>Nie jesteś zalogowany. Zaloguj się!</p>";
}
?>

