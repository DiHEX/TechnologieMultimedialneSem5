<?php

session_start();
if (isset($_SESSION["crm-logged-in"])) {
    header("Location: /zadanie15");
    exit();
}

function ip_details($ip) {
    $json = file_get_contents ("http://ipinfo.io/{$ip}/geo?token=81c0bb66023284");
    $details = json_decode($json);
    return $details;
}

$user_username = $_POST["username-form-username"];
$user_password = $_POST["username-form-password"];

try {
    $db = $db = mysqli_connect("mysql-db", "root", "secret", "tm_mysql_zadanie15");
    if ($db->connect_error) throw new InvalidArgumentException("Database error");

    $username_query = $db->prepare("SELECT username, userrank, userid FROM user WHERE username=? AND password=?");
    $username_query->bind_param("ss", $user_username, $user_password);
    $username_query->execute();
    $username_query->bind_result($logged_user_username, $rank, $userid);
    $username_query->store_result();
    $username_query->fetch();

    if ($username_query->num_rows == 0) {
        header("Location: /zadanie15/auth/login-form.php?status=invalid-cred");
    } else {
        $_SESSION["crm-logged-in"] = $user_username;
        $_SESSION["crm-user-rank"] = $rank;
        $_SESSION["crm-user-id"] = $userid;
        header("Location: /zadanie15");
    }
} finally {
    if (isset($db)) {
        $db->close();
    }
}