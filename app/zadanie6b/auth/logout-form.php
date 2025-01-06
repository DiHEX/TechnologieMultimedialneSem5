<?php
if (isset($_SESSION["zadanie6b-logged-in"])) {
    $username = $_SESSION['zadanie6b-logged-in'];
    echo "<p>Jesteś zalogowany jako $username. <a href='/zadanie6b/auth/logout-handle.php'>Wyloguj</a></p>";
} else {
    echo "<p>Nie jesteś zalogowany. Zaloguj się!</p>";
}
?>

