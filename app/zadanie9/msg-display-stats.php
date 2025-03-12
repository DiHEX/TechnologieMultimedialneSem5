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
        $db = mysqli_connect("mysql-db", "root", "secret", "tm_mysql_zadanie9");
        $rs = mysqli_query($db, "SELECT * FROM login_history");

        while($row = mysqli_fetch_array($rs)) {
            echo "<tr>";
            echo "<td>" . $row['entry_id'] . "</td>";
            echo "<td>" . $row['username'] . "</td>";
            echo "<td>" . $row['login_date'] . "</td>";
            echo "<td>" . $row['ip_address'] . "</td>";
            echo "<td>" . $row['loc'] . "</td>";
            echo "<td>" . $row['user_agent'] . "</td>";
            echo "</tr>";
        }

        mysqli_close($db);
        ?>
    </table>
</div>
</body>
</html>

