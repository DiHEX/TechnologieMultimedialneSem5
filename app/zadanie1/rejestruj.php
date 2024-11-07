<?php
    session_start();
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
        header('Location: info.php');
        exit;
    }
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    </head>
    <BODY>
        Formularz rejestracji
        <form method="post" action="add.php">
            Login: <input type="text" name="user" maxlength="20" size="20" required><br>
            Hasło: <input type="password" name="pass" maxlength="20" size="20" required><br>
            Powtórz hasło: <input type="password" name="pass_confirm" maxlength="20" size="20" required><br>
            <input type="submit" value="Rejestruj"/>
        </form>
    </BODY>
</HTML>
