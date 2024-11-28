<?php

session_start();
if (isset($_SESSION["zscan-logged-in"])) {
    header("Location: /zadanie4");
    exit();
}

function ip_details($ip) {
    $json = file_get_contents ("http://ipinfo.io/{$ip}/geo?token=81c0bb66023284");
    $details = json_decode($json);
    return $details;
}

$user_login = $_POST["login-form-login"];
$user_password = $_POST["login-form-password"];

try {
    $db = mysqli_connect("mysql-db", "root", "secret", "tm_mysql_database");
    if ($db->connect_error) throw new InvalidArgumentException("Database error");

    $login_query = $db->prepare("SELECT id, username FROM users WHERE username=? AND password=?");
    $login_query->bind_param("ss", $user_login, $user_password);
    $login_query->execute();
    $login_query->bind_result($logged_user_id, $logged_user_username);
    $login_query->store_result();

    if ($login_query->num_rows == 0) {
        header("Location: /zadanie4/auth/login-form.php?status=invalid-cred");
    } else {
        $login_query->fetch();
        $_SESSION["zscan-logged-in"] = $logged_user_username;
        $_SESSION["zscan-user-id"] = $logged_user_id;
        
        header("Location: /zadanie4");
    }
} finally {
    if (isset($db)) {
        $db->close();
    }
}