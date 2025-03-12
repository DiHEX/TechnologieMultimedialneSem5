<?php
session_start();
if (isset($_SESSION["zadanie9-logged-in"])) {
    header("Location: /zadanie9");
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <title>Kalinowski</title>
    <link href="/assets/global.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Formularz logowania</h1>

        <form method="POST" action="/zadanie9/auth/login-handle.php">
            <div class="form-group">
                <?php
                if (isset($_GET['status']) && $_GET["status"] == "requires-login") {
                    echo "<div>Zaloguj się</div>";
                } else if (isset($_GET['status']) && $_GET["status"] == "invalid-cred") {
                    echo "<div>Podano nieprawidłowe dane logowania</div>";
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
                <div><a href="/zadanie9/auth/register-form.php">Zarejestruj się</a></div>
            </div>

            <div class="form-group">
                <input type="submit" value="Zaloguj" class="btn btn-primary" />
            </div>
        </form>
    </div>
</body>
</html>