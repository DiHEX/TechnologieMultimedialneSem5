<?php

session_start();
$username = $_POST['username'];
$password = $_POST['password'];

if (empty($username) || empty($password)) {
    header("Location: /zadanie16/index.php?error=cred-empty");
} else if ($username != "admin" || $password != "admin") {
    header("Location: /zadanie16/index.php?error=cred-invalid");
} else {
    $_SESSION['is-admin'] = true;
    header("Location: /zadanie16/index.php");
}

