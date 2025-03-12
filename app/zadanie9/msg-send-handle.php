<?php
session_start();
if (! isset($_SESSION["zadanie9-logged-in"])) {
    header("Location: /zadanie9");
    exit();
}

$time = date('H:i:s', time());
$user = $_SESSION["zadanie9-logged-in"];
$post = $_POST['post'];
$recipient = $_POST['recipient'];
if (IsSet($_POST['post']))
{
    $db = mysqli_connect("mysql-db", "root", "secret", "tm_mysql_zadanie9");

    if(isset($_FILES["fileToUpload"]) && $_FILES['fileToUpload']['size'] > 1) {
        $username = $_SESSION["zadanie9-logged-in"];
        if (!is_dir("/var/www/html/zadanie9/files/$username")) {
            mkdir("/var/www/html/zadanie9/files/$username", 0777, true);
        }
        $basename = basename($_FILES["fileToUpload"]["name"]);
        if (!file_exists("/var/www/html/zadanie9/files/$username/$basename")) {
            move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], "/var/www/html/zadanie9/files/$username/$basename");
        }
        $attachment = "/zadanie9/files/$username/$basename";
    } else {
        $attachment = "";
    }

    if (!$db)
    {
        echo " MySQL Connection error." . PHP_EOL;
        echo "Errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Error: " . mysqli_connect_error() . PHP_EOL;
        exit;
    }
    $result = mysqli_query($db, "INSERT INTO messages (message, user, recipient, attachment_url) VALUES ('$post', '$user', '$recipient', '$attachment');") or die ("DB error: $dbname");

    mysqli_close($db);
}
header ('Location: /zadanie9/msg-send-form.php');
?>