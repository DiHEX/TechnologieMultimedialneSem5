<?php
session_start();
if (isset($_SESSION["zadanie6b-logged-in"])) {
    header("Location: /zadanie6b");
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
    $db = mysqli_connect("mysql-db", "root", "secret", "tm_mysql_database");
    if ($db->connect_error) throw new InvalidArgumentException("Database error");

    if ($user_password != $user_password2) {
        header("Location: /zadanie6b/auth/register-form.php?status=pwd-mismatch");
        exit();
    }

    $check_query = $db->prepare("SELECT username FROM users WHERE username=?");
    $check_query->bind_param("s", $user_login);
    $check_query->execute();
    $check_query->bind_result($validated_username);
    $check_query->store_result();
    if ($check_query->num_rows != 0) {
        header("Location: /zadanie6b/auth/register-form.php?status=user-exists");
        exit();
    }

    $reg_sql = "INSERT INTO users (id, username, password) VALUES (NULL, ?, ?)";
    $reg_query = $db->prepare($reg_sql);
    $reg_query->bind_param("ss", $user_login, $user_password);
    $reg_query->execute();

    $_SESSION["zadanie6b-logged-in"] = $user_login;
    header("Location: /zadanie6b");
} catch (Exception $e) {
    echo $e->getMessage() . " " . $e->getTraceAsString();
} finally {
    if (isset($db)) {
        $db->close();
    }
}