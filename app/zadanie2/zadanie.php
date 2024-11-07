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
        <title>Kalinowski</title>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <h2 class="mt-5">Formularz logowania</h2>
            <form method="post" action="weryfikacja.php" class="mt-3">
                <div class="form-group">
                    <label for="user">Login:</label>
                    <input type="text" class="form-control" id="user" name="user" maxlength="20" size="20">
                </div>
                <div class="form-group">
                    <label for="pass">Hasło:</label>
                    <input type="password" class="form-control" id="pass" name="pass" maxlength="20" size="20">
                </div>
                <button type="submit" class="btn btn-primary">Zaloguj</button>
            </form>
            <br>
            <a href="rejestruj.php" class="btn btn-link">Rejestruj</a>
        </div>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    </body>
</html>