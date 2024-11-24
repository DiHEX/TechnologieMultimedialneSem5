<?php
    session_start();
    if (!isset($_SESSION["loggedin"])) {
        header('Location: ../zadanie.php');
        exit();
    }
$ipaddress = $_SERVER["REMOTE_ADDR"];
function ip_details($ip) {
$json = file_get_contents ("http://ipinfo.io/{$ip}/geo");
$details = json_decode ($json);
return $details;
}
$details = ip_details($ipaddress);

if ($details->country != "PL") {
    echo "<p>Ta strona jest dostepna wylacznie dla uzytkownikow z Polski!</p>";
    exit();
}

$data_region = $details -> region;
$data_country = $details->country;
$data_city = $details->city;
$data_location = $details->loc;
$data_ipaddress = $details->ip;
$data_datetime = date( 'Y-m-d H:i:s');
$data_browsername = $_SERVER['HTTP_USER_AGENT'];
$data_screenresolution = $_POST["guest-screen-resolution"];
$data_browserresolution = $_POST["guest-browser-resolution"];
$data_colors = $_POST["guest-colors"];
$data_cookiesenabled = $_POST["guest-cookies-enabled"];
$data_java_enabled = $_POST["guest-java-enabled"];
$data_language = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);

echo $_SERVER['HTTP_ACCEPT_LANGUAGE'];

$link = mysqli_connect("mysql-db", "root", "secret", "tm_mysql_database");
$result = mysqli_query($link, "INSERT INTO goscieportalu (id, region, country, city, location, ipaddress, datetime, browsername, screenresolution, browserresolution, colors, cookiesenabled, java_enabled, language) VALUES (null, '$data_region', '$data_country', '$data_city', '$data_location', '$data_ipaddress', '$data_datetime', '$data_browsername', '$data_screenresolution', '$data_browserresolution', '$data_colors', '$data_cookiesenabled', '$data_java_enabled', '$data_language')");


mysqli_close($link);

header("Location: /guests.php");

?>