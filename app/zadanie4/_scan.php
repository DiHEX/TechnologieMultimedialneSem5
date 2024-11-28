<?php
session_start();
if (! isset($_SESSION["zscan-logged-in"])) {
    header("Location: /zadanie4/auth/login-form.php");
    exit();
}
?>

<body>
<?php
$polaczenie = mysqli_connect("mysql-db", "root", "secret", "tm_mysql_database");
if (!$polaczenie) {
    echo "Błąd połączenia z MySQL." . PHP_EOL;
    echo "Errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}
$id = $_SESSION["zscan-logged-in"];
$userID = $_SESSION["zscan-user-id"];

if ($id == "admin") {
    $sql = "SELECT * FROM hosts";
} else {
    $sql = "SELECT * FROM hosts WHERE userId='$userID'";
}
$rezultat = mysqli_query($polaczenie, $sql) or die ("Błąd zapytania do bazy: $dbname");
print "<TABLE CELLPADDING=5 BORDER=1>";
print "<TR><TD>id</TD><TD>Host</TD><TD>Port</TD><TD>Status</TD><TD>Usuwanie</TD></TD></TR>\n";
while ($wiersz = mysqli_fetch_array ($rezultat)) {
    $idRow = $wiersz[0];
    $host = $wiersz[1];
    $port = $wiersz[2];
    $fp = @fsockopen($host, $port, $errno, $errstr, 1);
    if ($fp) { $stan = "Ok"; } else { $stan = "$errno $errstr"; }
    print "<TR><TD>$idRow</TD><TD>$host</TD><TD>$port</TD><TD>$stan</TD><TD><a href='/zadanie4/kasuj.php?id=$idRow'>(Usuń)</a></TD></TR>\n";
}
print "</TABLE>";
mysqli_close($polaczenie);
?>
</body>

<hr style="margin-top: 20px; margin-bottom: 20px;" />

<form action="add.php" method="post">
    <label>Podaj nazwę hosta</label>
    <input type="text" name="host" value="" required id="host" />
    <br/>

    <label>Podaj numer portu</label>
    <input type="number" min="1" name="port" value="" required id="port" />
    <br />

    <input type="submit" value="Zapisz" />
    <br/>
</form>

<hr style="margin-top: 20px; margin-bottom: 20px;" />

<?php include "auth/logout-form.php"; ?>