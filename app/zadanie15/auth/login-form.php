<?php
session_start();
if (isset($_SESSION["crm-logged-in"])) {
    header("Location: /zadanie15");
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <title>Kalinowski</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link href="/assets/global.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Formularz logowania</h1>

        <form method="POST" action="/zadanie15/auth/login-handle.php">
            <div class="form-group">
                <?php
                if (isset($_GET['status']) && $_GET["status"] == "requires-username") {
                    echo "<div>Dostęp do tej strony wymaga zalogowania!</div>";
                } else if (isset($_GET['status']) && $_GET["status"] == "invalid-cred") {
                    echo "<div>Podano nieprawidłowe dane logowania!</div>";
                }
                ?>
            </div>

            <div class="form-group">
                <label for="username-form-username">username</label>
                <input type="text" id="username-form-username" name="username-form-username" class="form-control" />
            </div>

            <div class="form-group">
                <label for="username-form-password">Hasło</label>
                <input type="password" id="username-form-password" name="username-form-password" class="form-control" />
            </div>

            <div class="form-group">
                <div>Chcesz się zarejestrować?</div>
                <div><a href="/zadanie15/auth/register-form.php">Zarejestruj się teraz!</a></div>
            </div>

            <div class="form-group">
                <input type="submit" value="Zaloguj" class="btn btn-primary" />
            </div>
        </form>
    </div>
</body>
</html>