<?php

session_start();
if (isset($_SESSION["zadanie9-logged-in"])) {
    header("Location: /zadanie9");
    exit();
}

function ip_details($ip) {
    if (empty($ip)) {
        return;
    }
    
    $json = file_get_contents ("http://ipinfo.io/{$ip}/geo?token=81c0bb66023284");
    $details = json_decode($json);
    return $details;
}

$user_login = $_POST["login-form-login"];
$user_password = $_POST["login-form-password"];

try {
    $db = mysqli_connect("mysql-db", "root", "secret", "tm_mysql_zadanie9");
    if ($db->connect_error) throw new InvalidArgumentException("Database error");

    $login_query = $db->prepare("SELECT username FROM users WHERE username=? AND password=?");
    $login_query->bind_param("ss", $user_login, $user_password);
    $login_query->execute();
    $login_query->bind_result($logged_user_username);
    $login_query->store_result();

    if ($login_query->num_rows == 0) {
        header("Location: /zadanie9/auth/login-form.php?status=invalid-cred");
    } else {
        $_SESSION["zadanie9-logged-in"] = $user_login;
        $clientIP = $_SERVER['REMOTE_ADDR'];

        $loc = '';
        if (isset($ip_info->loc)){
            $loc = ip_details($clientIP)->loc;
        }
        
        $add_to_history_query = $db->prepare("INSERT INTO login_history(username, ip_address, loc, user_agent) VALUES (?, ?, ?, ?)");
        $add_to_history_query->bind_param("ssss", $user_login, $clientIP, $loc, $_SERVER['HTTP_USER_AGENT']);
        $add_to_history_query->execute();
        header("Location: /zadanie9");
    }
} finally {
    if (isset($db)) {
        $db->close();
    }
}