<?php
    session_start();
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
        header('Location: /index.php');  
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
                <input type="hidden" value="" id="guest-screen-resolution" name="guest-screen-resolution" />
                <input type="hidden" value="" id="guest-browser-resolution" name="guest-browser-resolution" />
                <input type="hidden" value="" id="guest-colors" name="guest-colors" />
                <input type="hidden" value="" id="guest-cookies-enabled" name="guest-cookies-enabled" />
                <input type="hidden" value="" id="guest-java-enabled" name="guest-java-enabled" />
                <button type="submit" class="btn btn-primary">Zaloguj</button>
                <a href="rejestruj.php" class="btn btn-link">Rejestruj</a>
            </form>
            <br>
            
            <script>
                document.getElementById("guest-screen-resolution").value = `${screen.width} x ${screen.height}`;
                document.getElementById("guest-browser-resolution").value = `${screen.availWidth} x ${screen.availHeight}`;
                document.getElementById("guest-colors").value = screen.colorDepth;
                document.getElementById("guest-cookies-enabled").value = navigator.cookieEnabled ? 1 : 0;
                document.getElementById("guest-java-enabled").value = window.navigator.javaEnabled() === true ? 1 : 0;
            </script>

        </div>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    </body>
</html>