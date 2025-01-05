<?php
if (isset($_SESSION["zadanie5-logged-in"])) {
    $username = $_SESSION['zadanie5-logged-in'];
    echo "<p>Jesteś zalogowany jako $username. <a href='/zadanie5/auth/logout-handle.php'>Wyloguj</a></p>";
} else {
    echo "<p>Nie jesteś zalogowany. Zaloguj się!</p>";
}
?>

