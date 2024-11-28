<?php
    session_start();
    $user = htmlentities ($_POST['user'], ENT_QUOTES, "UTF-8"); // rozbrojenie potencjalnej bomby w zmiennej $user
    $pass = htmlentities ($_POST['pass'], ENT_QUOTES, "UTF-8"); // rozbrojenie potencjalnej bomby w zmiennej $pass
    $passConfirm = htmlentities ($_POST['pass_confirm'], ENT_QUOTES, "UTF-8"); // rozbrojenie potencjalnej bomby w zmiennej $pass

    if ($pass != $passConfirm) {
        header('Location: rejestruj.php'); 
        exit; 
    }

    $link = mysqli_connect("mysql-db", "root", "secret", "tm_mysql_database"); // połączenie z BD – wpisać swoje dane

    if(!$link) 
    { 
        //echo"Błąd: ". mysqli_connect_errno()." ".mysqli_connect_error();
        header('Location: rejestruj.php'); 
        exit; 
    } // obsługa błędu połączenia z BD

    mysqli_query($link, "SET NAMES 'utf8'"); // ustawienie polskich znaków
    $result = mysqli_query($link, "SELECT * FROM users WHERE username='$user'"); // wiersza, w którym login=login z formularza
    $rekord = mysqli_fetch_array($result); // wiersza z BD, struktura zmiennej jak w BD

    if($rekord)
    {
        mysqli_close($link); // zamknięcie połączenia z BD
        //echo "Brak użytkownika o takim loginie !"; // UWAGA nie wyświetlamy takich podpowiedzi dla hakerów
        header('Location: rejestruj.php'); 
        exit;
    }
    else
    { 
        header('Location: ./index.php'); 
        $_SESSION ['loggedin'] = true;
        $_SESSION ['userName'] = $user;
        
        mysqli_query($link, "SET NAMES 'utf8'"); // ustawienie polskich znaków
        mysqli_query($link, "INSERT INTO users (username, password) VALUES ('$user', '$pass')"); // wiersza, w którym login=login z formularza
        //echo "Logowanie Ok. User: {$rekord['username']}. Hasło: {$rekord['password']}";

        $targetDir = "/var/www/html/files";

        if (!file_exists("$targetDir/$user")) {
            mkdir("$targetDir/$user", 0777, true);
        }

        $file = $_FILES["avatar"];

        $basename = "$targetDir/$user/" . basename($file["name"]);

        $user_avatar = "";

        if(isset($_FILES["avatar"]) && $_FILES['avatar']['size'] > 1) {

            move_uploaded_file($file["tmp_name"], $basename);

            $user_avatar = "/files/$user/" . basename($file["name"]);
         
        } else {
            
            $user_avatar = "https://cdn-icons-png.flaticon.com/512/8742/8742495.png";
            
        }

        $_SESSION['avatar'] = $user_avatar;

        $ipaddress = $_SERVER["REMOTE_ADDR"];
        function ip_details($ip) {
        $json = file_get_contents ("http://ipinfo.io/{$ip}/geo");
        $details = json_decode ($json);
        return $details;
        }
        $details = ip_details($ipaddress);

        $data_region = isset($details->region) ? $details->region : '';
        $data_country = isset($details->country) ? $details->country : '';
        $data_city = isset($details->city) ? $details->city : '';
        $data_location = isset($details->loc) ? $details->loc : '';
        $data_ipaddress = isset($details->ip) ? $details->ip : '';
        $data_datetime = date('Y-m-d H:i:s');
        $data_browsername = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
        $data_screenresolution = isset($_POST["guest-screen-resolution"]) ? $_POST["guest-screen-resolution"] : '';
        $data_browserresolution = isset($_POST["guest-browser-resolution"]) ? $_POST["guest-browser-resolution"] : '';
        $data_colors = isset($_POST["guest-colors"]) ? $_POST["guest-colors"] : '';
        $data_cookiesenabled = isset($_POST["guest-cookies-enabled"]) ? $_POST["guest-cookies-enabled"] : '';
        $data_java_enabled = isset($_POST["guest-java-enabled"]) ? $_POST["guest-java-enabled"] : '';
        $data_language = isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2) : '';

        $link = mysqli_connect("mysql-db", "root", "secret", "tm_mysql_database");

        $result = mysqli_query($link, "SELECT COUNT(ID) AS count FROM goscieportalu WHERE ipaddress = '$data_ipaddress'");
        $row = mysqli_fetch_assoc($result);
        $count = $row['count'];

        if ($count > 0) {
            mysqli_query($link, "UPDATE goscieportalu SET ilosc=ilosc+1 WHERE ipaddress = '$data_ipaddress'");
        }
        else {
            $result = mysqli_query($link, "INSERT INTO goscieportalu (region, country, city, location, ipaddress, datetime, browsername, screenresolution, browserresolution, colors, cookiesenabled, java_enabled, language, ilosc) VALUES ('$data_region', '$data_country', '$data_city', '$data_location', '$data_ipaddress', '$data_datetime', '$data_browsername', '$data_screenresolution', '$data_browserresolution', '$data_colors', '$data_cookiesenabled', '$data_java_enabled', '$data_language', 1)");
        }
          
        exit;
    }
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<HEAD>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Kalinowski</title>
</HEAD>
<BODY>

</BODY>
</HTML>