<?php
session_start();
if (isset($_SESSION["zadanie5-logged-in"])) {
    header("Location: /zadanie5");
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

    $login_query = $db->prepare("SELECT username FROM users WHERE username=? AND password=?");
    $login_query->bind_param("ss", $user_login, $user_password);
    $login_query->execute();
    $login_query->bind_result($logged_user_username);
    $login_query->store_result();

    if ($login_query->num_rows == 0) {
        $inv_query = $db->prepare("UPDATE invalid_logins SET last_entry_date=?, last_ip_address=?, count=count+1 WHERE username=?");
        $inv_date = date( 'Y-m-d H:i:s');
        $inv_addr = $_SERVER['REMOTE_ADDR'];
        $inv_query->bind_param("sss", $inv_date, $inv_addr, $user_login);
        $inv_query->execute();

        $inv_get_query = $db->prepare("SELECT count, last_entry_date FROM invalid_logins WHERE username=?");
        $inv_get_query->bind_param("s", $user_login);
        $inv_get_query->bind_result($login_attempt_count, $login_attempt_date);
        $inv_get_query->execute();
        $inv_get_query->store_result();

        $now = new DateTime();
        $then = $login_attempt_date ? new DateTime($login_attempt_date) : new DateTime();
        $diff = $now->diff($then);
        $minutes = ($diff->format('%a') * 1440) +
            ($diff->format('%h') * 60) +
            $diff->format('%i');

        if ($login_attempt_count > 3 && $minutes < 2) {
            header("Location: /zadanie5/auth/login-form.php?status=login-threshold");
        } else {
            header("Location: /zadanie5/auth/login-form.php?status=invalid-cred");
        }
    } else {
        $_SESSION["zadanie5-logged-in"] = $user_login;
        $clientIP = $_SERVER['REMOTE_ADDR'];
        $ip_info = ip_details($clientIP);
        $loc = '';
        $loc = isset($ip_info->loc) ? $ip_info->loc : '';
        $add_to_history_query = $db->prepare("INSERT INTO login_history(username, ip_address, loc, user_agent) VALUES (?, ?, ?, ?)");
        $add_to_history_query->bind_param("ssss", $user_login, $clientIP, $loc, $_SERVER['HTTP_USER_AGENT']);
        $add_to_history_query->execute();

        $inv_query = $db->prepare("UPDATE invalid_logins SET last_entry_date=?, last_ip_address=?, count=0 WHERE username=?");
        $inv_date = date( 'Y-m-d H:i:s');
        $inv_addr = $_SERVER['REMOTE_ADDR'];
        $inv_query->bind_param("sss", $inv_date, $inv_addr, $user_login);
        $inv_query->execute();

        header("Location: /zadanie5");
    }
} finally {
    if (isset($db)) {
        $db->close();
    }
}

?>