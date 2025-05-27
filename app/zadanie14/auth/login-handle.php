<?php

session_start();
if (isset($_SESSION["zadanie14-logged-in"])) {
    header("Location: /zadanie14");
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
    $db = mysqli_connect("mysql-db", "root", "secret", "tm_mysql_zadanie14");
    if ($db->connect_error) throw new InvalidArgumentException("Database error");

    $login_query = $db->prepare("SELECT username, userrank, userid FROM user WHERE username=? AND password=?");
    $login_query->bind_param("ss", $user_login, $user_password);
    $login_query->execute();
    $login_query->bind_result($logged_user_username, $rank, $userid);
    $login_query->store_result();
    $login_query->fetch();

    if ($login_query->num_rows == 0) {
        header("Location: /zadanie14/auth/login-form.php?status=invalid-cred");
    } else {
        $_SESSION["zadanie14-logged-in"] = $user_login;
        $_SESSION["zadanie14-rank"] = $rank;
        $_SESSION["zadanie14-userid"] = $userid;
        header("Location: /zadanie14");
    }
} finally {
    if (isset($db)) {
        $db->close();
    }
}