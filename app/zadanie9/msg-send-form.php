<?php
    session_start();
    if (! isset($_SESSION["zadanie9-logged-in"])) {
        header("Location: /zadanie9");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kalinowski</title>
    <link href="/assets/global.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1>Zadanie 9</h1>
    <a href="/zadanie9">Powrót do strony laboratorium</a>
    <hr />

    <?php include "auth/logout-form.php" ?>

    <hr />

    <?php
    $db = mysqli_connect("mysql-db", "root", "secret", "tm_mysql_zadanie9");
    if (!$db)
    {
        echo " MySQL Connection error." . PHP_EOL;
        echo "Errno: " . mysqli_connect_errno() . PHP_EOL;
        echo "Error: " . mysqli_connect_error() . PHP_EOL;
        exit;
    }
    ?>

    <form method="POST" action="/zadanie9/msg-send-handle.php" enctype="multipart/form-data">
        Post:
        <input type="text" name="post" maxlength="90" size="90" class="form-control">
        <br>

        Odbiorca:
        <select name="recipient" class="form-control">
            <?php
            $curuser = $_SESSION["zadanie9-logged-in"];
            $result = mysqli_query($db, "select username from users WHERE username != '$curuser'") or die ("DB error: $dbname");
            while ($row = mysqli_fetch_array ($result)) {
                echo "<option>$row[0]</option>";
            }
            ?>
        </select>
        <br/>

        Załącznik (opcjonalny):
        <input type="file" name="fileToUpload" id="fileToUpload" class="form-control">
        <br/>

        <input type="submit" class="btn btn-success" value="Wyślij wiadomość"/>
    </form>

    <hr />

    <h1>Nadane do Ciebie</h1>
    <?php
    $recipient = $_SESSION["zadanie9-logged-in"];
    $where_clause = $recipient == "admin" ? "" : "WHERE recipient='$recipient'";
    $result = mysqli_query($db, "Select idk, datetime, message, user, attachment_url from messages $where_clause Order by idk Desc") or die ("DB error: $dbname");
    print "<TABLE class='table table-bordered' style='color: white;'>";
    print "<TR><TD>id</TD><TD>Date/Time</TD><TD>User</TD><TD>Message</TD><td>Załącznik</td></TR>\n";
    while ($row = mysqli_fetch_array ($result))
    {
        $id = $row[0];
        $date = $row[1];
        $message= $row[2];
        $user = $row[3];

        $attachment_url = $row[4];

        if (str_ends_with($row[4], "gif") || str_ends_with($row[4], "png") || str_ends_with($row[4], "jpg")) {
            $attachment = "<a target='_blank' href='$row[4]'><img src='$attachment_url' style='width: 120px; height: 80px;' /></a>";
        } else if (str_ends_with($row[4], "mp3")) {
            $attachment = "<audio controls><source src='$attachment_url' type='audio/mpeg'></audio>";
        } else if (str_ends_with($row[4], "mp4")) {
            $attachment = "<video width='320' height='240' controls><source src='$attachment_url' type='video/mp4'></video>";
        } else if(strlen($row[4]) >= 1) {
            $attachment = "<a target='_blank' href='$row[4]'>$row[4]</a>";
        } else {
            $attachment = "(brak załącznika)";
        }

        print "<TR><TD>$id</TD><TD>$date</TD><TD>$user</TD><TD>$message</TD><td>$attachment</td></TR>\n";
    }
    print "</TABLE>";
    ?>

    <hr />

    <h1>Nadane przez Ciebie</h1>
    <?php
    $sender = $_SESSION["zadanie9-logged-in"];
    $result = mysqli_query($db, "Select idk, datetime, message, recipient, attachment_url from messages WHERE user='$sender' Order by idk Desc") or die ("DB error: $dbname");
    print "<TABLE class='table table-bordered' style='color: white;'>";
    print "<TR><TD>id</TD><TD>Date/Time</TD><TD>User</TD><TD>Message</TD><td>Załącznik</td></TR>\n";
    while ($row = mysqli_fetch_array ($result))
    {
        $id = $row[0];
        $date = $row[1];
        $message= $row[2];
        $user = $row[3];
        $attachment_url = $row[4];

        if (str_ends_with($row[4], "gif") || str_ends_with($row[4], "png") || str_ends_with($row[4], "jpg")) {
            $attachment = "<a target='_blank' href='$row[4]'><img src='$attachment_url' style='width: 120px; height: 80px;' /></a>";
        } else if (str_ends_with($row[4], "mp3")) {
            $attachment = "<audio controls><source src='$attachment_url' type='audio/mpeg'></audio>";
        } else if (str_ends_with($row[4], "mp4")) {
            $attachment = "<video width='320' height='240' controls><source src='$attachment_url' type='video/mp4'></video>";
        } else if(strlen($row[4]) >= 1) {
            $attachment = "<a target='_blank' href='$row[4]'>$row[4]</a>";
        } else {
            $attachment = "(brak załącznika)";
        }

        print "<TR><TD>$id</TD><TD>$date</TD><TD>$user</TD><TD>$message</TD><td>$attachment</td></TR>\n";
    }
    print "</TABLE>";
    mysqli_close($db);
    ?>
</div>
</body>
</html>

