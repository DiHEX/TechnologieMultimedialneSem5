<?php
if (isset($_SESSION["zadanie14-logged-in"])) {
    $username = $_SESSION['zadanie14-logged-in'];
    echo "<p>Jesteś zalogowany jako $username. <a href='/zadanie14/auth/logout-handle.php'>Wyloguj mnie!</a></p>";
} else {
    echo "<p>Nie jesteś zalogowany. Zaloguj się!</p>";
}
?>

