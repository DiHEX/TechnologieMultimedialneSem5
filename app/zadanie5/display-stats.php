<?php
session_start();
if (! isset($_SESSION["zadanie5-logged-in"])) {
    header("Location: /zadanie5");
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <h1>Lab 5</h1>
    <a href="/zadanie5">Powrót do strony laboratorium</a>
    <hr />

    <h1>Twoja historia logowania:</h1>

    <table>
        <tr>
            <th>Id</th>
            <th>Użytkownik</th>
            <th>Data i czas</th>
            <th>IP</th>
            <th>Współrzędne</th>
            <th>Przeglądarka</th>
        </tr>

        <?php
        $link = mysqli_connect("mysql-db", "root", "secret", "tm_mysql_database"); 
        $rs = mysqli_query($link, "SELECT * FROM login_history WHERE username='{$_SESSION["zadanie5-logged-in"]}'");

        while($row = mysqli_fetch_array($rs)) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['username'] . "</td>";
            echo "<td>" . $row['login_time'] . "</td>";
            echo "<td>" . $row['ip_address'] . "</td>";
            echo "<td>" . $row['loc'] . "</td>";
            echo "<td>" . $row['user_agent'] . "</td>";
            echo "</tr>";
        }

        mysqli_close($link);
        ?>
    </table>
</div>
</body>
</html>

