<?php
session_start();
if (isset($_SESSION["todo-logged-in"])) {
    header("Location: /zadanie13/index.php");
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
    $db = mysqli_connect("mysql-db", "root", "secret", "tm_mysql_zadanie13");

    if ($db->connect_error) throw new InvalidArgumentException("Database error");

    $login_query = $db->prepare("SELECT id_pracownika, login FROM pracownicy WHERE login=? AND password=?");
    $login_query->bind_param("ss", $user_login, $user_password);
    $login_query->execute();
    $login_query->bind_result($userid, $logged_user_username);
    $login_query->store_result();
    $login_query->fetch();

    if ($login_query->num_rows == 0) {
        $insert_query = $db->prepare("INSERT INTO logowanie(id_logowania, id_pracownika, datetime, state) VALUES (NULL, ?, ?, ?)");
        $date = date('Y-m-d H:i:s');
        $str = "failed";
        if ($userid === null) {
            $userid = 0; // Use 0 for failed login attempts
        }
        $insert_query->bind_param("iss", $userid, $date, $str);
        $insert_query->execute();

        header("Location: /zadanie13/auth/login-form.php?status=invalid-cred");
        exit();
    } else {
        $insert_query = $db->prepare("INSERT INTO logowanie(id_logowania, id_pracownika, datetime, state) VALUES (NULL, ?, ?, ?)");
        $date = date('Y-m-d H:i:s');
        $str = "succeeded";
        $insert_query->bind_param("iss", $userid, $date, $str);
        $insert_query->execute();
        
        $_SESSION["todo-logged-in"] = $user_login;
        $_SESSION["todo-userid"] = $userid;
        header("Location: /zadanie13/index.php");
        exit();
    }
} finally {
    if (isset($db)) {
        $db->close();
    }
}