<?php
session_start();
if (isset($_SESSION["zadanie14-logged-in"])) {
    header("Location: /zadanie14");
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <title>Kalinowski</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link href="/assets/global.css" rel="stylesheet">
</head>
<body>
<form method="POST" action="/zadanie14/auth/register-handle.php">
    <div class="container">
        <h1>Formularz rejestracji</h1>

        <div class="form-group">
            <?php
            if (isset($_GET['status']) && $_GET["status"] == "user-exists") {
                echo "<p>Użytkownik już istnieje...</p>";
            } else if (isset($_GET['status']) && $_GET["status"] == "pwd-mismatch") {
                echo "<p>Podano dwa różne hasła...</p>";
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
            <label for="registration-form-rank">Ranga</label>
            <select id="registration-form-rank" name="registration-form-rank" class="form-control">
                <option selected value="pracownik">Pracownik (Kursant)</option>
                <option value="coach">Coach (Szkoleniowiec)</option>
                <option value="admin">Administrator</option>
            </select>
        </div>

        <div class="form-group">
            <p>Chcesz się zalogować?</p>
            <p><a href="/zadanie14/auth/login-form.php">Zaloguj się teraz!</a></p>
        </div>

        <div>
            <input type="submit" value="Rejestruj" class="btn btn-primary" />
        </div>
    </div>
</form>
</body>
</html>