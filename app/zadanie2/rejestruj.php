<?php
    session_start();
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
        header('Location: info.php');
        exit;
    }
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
        <title>Rejestracja</title>
    </head>
    <body>
        <div class="container">
            <h2 class="mt-5">Formularz rejestracji</h2>
            <form method="post" action="add.php" class="mt-3">
                <div class="form-group">
                    <label for="user">Login:</label>
                    <input type="text" class="form-control" id="user" name="user" maxlength="20" size="20" required>
                </div>
                <div class="form-group">
                    <label for="pass">Hasło:</label>
                    <input type="password" class="form-control" id="pass" name="pass" maxlength="20" size="20" required>
                </div>
                <div class="form-group">
                    <label for="pass_confirm">Powtórz hasło:</label>
                    <input type="password" class="form-control" id="pass_confirm" name="pass_confirm" maxlength="20" size="20" required>
                </div>
                <button type="submit" class="btn btn-primary">Rejestruj</button>
            </form>
        </div>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    </body>
</html>
</HTML>
