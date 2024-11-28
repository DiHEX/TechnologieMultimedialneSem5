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

$user_login = $_POST["registration-form-login"];
$user_password = $_POST["registration-form-password"];
$user_password2 = $_POST["registration-form-password2"];

try {
    $db = mysqli_connect("mysql-db", "root", "secret", "tm_mysql_database");
    if ($db->connect_error) throw new InvalidArgumentException("Database error");

    if ($user_password != $user_password2) {
        header("Location: /zadanie4/auth/register-form.php?status=pwd-mismatch");
        exit();
    }

    $check_query = $db->prepare("SELECT username FROM users WHERE username=?");
    $check_query->bind_param("s", $user_login);
    $check_query->execute();
    $check_query->bind_result($validated_username);
    $check_query->store_result();
    if ($check_query->num_rows != 0) {
        header("Location: /zadanie4/auth/register-form.php?status=user-exists");
        exit();
    }

    $reg_sql = "INSERT INTO users (username, password) VALUES (?, ?)";
    $reg_query = $db->prepare($reg_sql);
    $reg_query->bind_param("ss", $user_login, $user_password);
    $reg_query->execute();

    $new_user_id = $db->insert_id;
    $_SESSION["zscan-logged-in"] = $user_login;
    $_SESSION["zscan-user-id"] = $new_user_id;


    header("Location: /zadanie4");
} catch (Exception $e) {
    echo $e->getMessage() . " " . $e->getTraceAsString();
} finally {
    if (isset($db)) {
        $db->close();
    }
}