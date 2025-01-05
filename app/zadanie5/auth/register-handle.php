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

$user_login = $_POST["registration-form-login"];
$user_password = $_POST["registration-form-password"];
$user_password2 = $_POST["registration-form-password2"];
$user_ip = $_SERVER['REMOTE_ADDR'];
$user_registration_date = date( 'Y-m-d H:i:s');

try {
    $db = mysqli_connect("mysql-db", "root", "secret", "tm_mysql_database");;
    if ($db->connect_error) throw new InvalidArgumentException("Database error");

    if ($user_password != $user_password2) {
        header("Location: /zadanie5/auth/register-form.php?status=pwd-mismatch");
        exit();
    }

    $check_query = $db->prepare("SELECT username FROM users WHERE username=?");
    $check_query->bind_param("s", $user_login);
    $check_query->execute();
    $check_query->bind_result($validated_username);
    $check_query->store_result();
    if ($check_query->num_rows != 0) {
        header("Location: /zadanie5/auth/register-form.php?status=user-exists");
        exit();
    }

    $reg_sql = "INSERT INTO users (id, username, password) VALUES (NULL, ?, ?)";
    $reg_query = $db->prepare($reg_sql);
    $reg_query->bind_param("ss", $user_login, $user_password);
    $reg_query->execute();

    $baseDirPath = "/var/www/html/user_storage";
    $dirPath = $baseDirPath . "/" . $user_login;
    mkdir($dirPath, 0777, true);

    $clientIP = $_SERVER['REMOTE_ADDR'];
    $loc = '';
    $loc = isset($ip_info->loc) ? $ip_info->loc : '';
    $add_to_history_query = $db->prepare("INSERT INTO login_history(username, ip_address, loc, user_agent) VALUES (?, ?, ?, ?)");
    $add_to_history_query->bind_param("ssss", $user_login, $clientIP, $loc, $_SERVER['HTTP_USER_AGENT']);
    $add_to_history_query->execute();

    $inv_query = $db->prepare("INSERT INTO invalid_logins(id, username, count, last_entry_date, last_ip_address) VALUES (NULL, ?, ?, ?, ?)");
    $inv_count = 0;
    $inv_query->bind_param("siss", $user_login, $inv_count, $user_registration_date, $user_ip);
    $inv_query->execute();


    $_SESSION["zadanie5-logged-in"] = $user_login;
    header("Location: /zadanie5");
} catch (Exception $e) {
    echo $e->getMessage() . " " . $e->getTraceAsString();
} finally {
    if (isset($db)) {
        $db->close();
    }
}
?>