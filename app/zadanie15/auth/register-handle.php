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

$user_username = $_POST["registration-form-username"];
$user_password = $_POST["registration-form-password"];
$user_password2 = $_POST["registration-form-password2"];
$user_ip = $_SERVER['REMOTE_ADDR'];
$user_registration_date = date( 'Y-m-d H:i:s');

try {
    $db = mysqli_connect("mysql-db", "root", "secret", "tm_mysql_zadanie15");

    if ($db->connect_error) throw new InvalidArgumentException("Database error");

    if ($user_password != $user_password2) {
        header("Location: /zadanie15/auth/register-form.php?status=pwd-mismatch");
        exit();
    }

    $check_query = $db->prepare("SELECT username FROM user WHERE username=?");
    $check_query->bind_param("s", $user_username);
    $check_query->execute();
    $check_query->bind_result($validated_username);
    $check_query->store_result();
    if ($check_query->num_rows != 0) {
        header("Location: /zadanie15/auth/register-form.php?status=user-exists");
        exit();
    }

    $rank = $_POST["registration-form-rank"];
    $reg_sql = "INSERT INTO user(userid, username, password, userrank) VALUES (NULL, ?, ?, ?)";
    $reg_query = $db->prepare($reg_sql);
    $reg_query->bind_param("sss", $user_username, $user_password, $rank);
    $reg_query->execute();

    $_SESSION["crm-logged-in"] = $user_username;
    $_SESSION["crm-user-rank"] = $rank;
    $_SESSION["crm-user-id"] = $reg_query->insert_id;
    header("Location: /zadanie15");
} catch (Exception $e) {
    echo $e->getMessage() . " " . $e->getTraceAsString();
} finally {
    if (isset($db)) {
        $db->close();
    }
}