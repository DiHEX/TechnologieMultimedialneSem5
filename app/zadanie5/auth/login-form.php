<?php
//session_start();
if (isset($_SESSION["zadanie5-logged-in"])) {
    header("Location: /zadanie5");
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <title>Kalinowski</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1>Formularz logowania</h1>

        <form method="POST" action="/zadanie5/auth/login-handle.php">
            <div class="form-group">
                <?php
                if (isset($_GET['status']) && $_GET["status"] == "requires-login") {
                    echo "<div>Dostęp do tej strony wymaga zalogowania!</div>";
                } else if (isset($_GET['status']) && $_GET["status"] == "invalid-cred") {
                    echo "<div>Podano nieprawidłowe dane logowania!</div>";
                }
                ?>
            </div>

            <div class="form-group">
                <label for="login-form-login">Login</label>
                <input type="text" id="login-form-login" name="login-form-login" class="form-control" />
            </div>

            <div class="form-group">
                <label for="login-form-password">Hasło</label>
                <input type="password" id="login-form-password" name="login-form-password" class="form-control" />
            </div>

            <div class="form-group">
                <div>Chcesz się zarejestrować?</div>
                <div><a href="/zadanie5/auth/register-form.php">Zarejestruj się teraz!</a></div>
            </div>

            <div class="form-group">
                <input type="submit" value="Zaloguj" class="btn btn-primary" />
            </div>
        </form>
    </div>
</body>
</html>