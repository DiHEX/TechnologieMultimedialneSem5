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
<form method="POST" action="/zadanie9/auth/register-handle.php">
    <div class="container">
        <h1>Formularz rejestracji</h1>

        <div class="form-group">
            <?php
            if (isset($_GET['status']) && $_GET["status"] == "user-exists") {
                echo "<p>Użytkownik już istnieje.</p>";
            } else if (isset($_GET['status']) && $_GET["status"] == "pwd-mismatch") {
                echo "<p>Podano dwa różne hasła.</p>";
            }
            ?>
        </div>

        <div class="form-group">
            <label for="registration-form-login">Login</label>
            <input type="text" id="registration-form-login" name="registration-form-login" class="form-control" />
        </div>

        <div class="form-group">
            <label for="registration-form-password">Hasło</label>
            <input type="password" id="registration-form-password" name="registration-form-password" class="form-control" />
        </div>

        <div class="form-group">
            <label for="registration-form-password2">Powtórz hasło</label>
            <input type="password" id="registration-form-password2" name="registration-form-password2" class="form-control" />
        </div>

        <div class="form-group">
            <p><a href="/zadanie9/auth/login-form.php">Zaloguj się</a></p>
        </div>

        <div>
            <input type="submit" value="Rejestruj" class="btn btn-primary" />
        </div>
    </div>
</form>
</body>
</html>