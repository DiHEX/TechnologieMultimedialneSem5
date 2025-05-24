<?php

if (isset($_SESSION["todo-logged-in"])) {
    $username = $_SESSION['todo-logged-in'];
    echo "<p>Jesteś zalogowany jako $username. <a href='/zadanie13/auth/logout-handle.php'>Wyloguj mnie!</a></p>";
} else {
    echo "<p>Nie jesteś zalogowany. Zaloguj się!</p>";
}
?>

