<?php

session_start();
if (isset($_SESSION["zadanie9-logged-in"])) {
    header("Location: /zadanie9");
    exit();
}

$user_login = $_POST["registration-form-login"];
$user_password = $_POST["registration-form-password"];
$user_password2 = $_POST["registration-form-password2"];
$user_ip = $_SERVER['REMOTE_ADDR'];
$user_registration_date = date( 'Y-m-d H:i:s');

try {
    $db = mysqli_connect("mysql-db", "root", "secret", "tm_mysql_zadanie9");
    if ($db->connect_error) throw new InvalidArgumentException("Database error");

    if ($user_password != $user_password2) {
        header("Location: /zadanie9/auth/register-form.php?status=pwd-mismatch");
        exit();
    }

    $check_query = $db->prepare("SELECT username FROM users WHERE username=?");
    $check_query->bind_param("s", $user_login);
    $check_query->execute();
    $check_query->bind_result($validated_username);
    $check_query->store_result();
    if ($check_query->num_rows != 0) {
        header("Location: /zadanie9/auth/register-form.php?status=user-exists");
        exit();
    }

    $reg_sql = "INSERT INTO users (id, username, password, ip, registration_date) VALUES (NULL, ?, ?, ?, ?)";
    $reg_query = $db->prepare($reg_sql);
    $reg_query->bind_param("ssss", $user_login, $user_password, $user_ip, $user_registration_date);
    $reg_query->execute();

    $inv_sql = "INSERT INTO invalid_logins (id, username, count, last_entry_date) VALUES (NULL, ?, ?, ?)";
    $inv_query = $db->prepare($inv_sql);
    $inv_count = 0;
    $inv_query->bind_param("sis", $user_login, $inv_count, $user_registration_date);
    $inv_query->execute();

    $_SESSION["zadanie9-logged-in"] = $user_login;
    header("Location: /zadanie9");
} catch (Exception $e) {
    echo $e->getMessage() . " " . $e->getTraceAsString();
} finally {
    if (isset($db)) {
        $db->close();
    }
}