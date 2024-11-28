<?php
    session_start();
    $user = htmlentities ($_POST['user'], ENT_QUOTES, "UTF-8"); // rozbrojenie potencjalnej bomby w zmiennej $user
    $pass = htmlentities ($_POST['pass'], ENT_QUOTES, "UTF-8"); // rozbrojenie potencjalnej bomby w zmiennej $pass
    $link = mysqli_connect("mysql-db", "root", "secret", "tm_mysql_database"); // połączenie z BD – wpisać swoje dane

    if(!$link) 
    { 
        echo"Błąd: ". mysqli_connect_errno()." ".mysqli_connect_error();
        header('Location: zadanie.php'); 
        exit; 
    } // obsługa błędu połączenia z BD

    mysqli_query($link, "SET NAMES 'utf8'"); // ustawienie polskich znaków
    $result = mysqli_query($link, "SELECT * FROM users WHERE username='$user'"); // wiersza, w którym login=login z formularza
    $rekord = mysqli_fetch_array($result); // wiersza z BD, struktura zmiennej jak w BD

    if(!$rekord) //Jeśli brak, to nie ma użytkownika o podanym loginie
    {
        mysqli_close($link); // zamknięcie połączenia z BD
        //echo "Brak użytkownika o takim loginie !"; // UWAGA nie wyświetlamy takich podpowiedzi dla hakerów
        header('Location: zadanie.php'); 
        exit;
    }
    else
    { // jeśli $rekord istnieje
        if($rekord['password']==$pass) // czy hasło zgadza się z BD
        {
            header('Location: index.php');  
            $_SESSION ['loggedin'] = true;
            $_SESSION ['userName'] = $user;
            //echo "Logowanie Ok. User: {$rekord['username']}. Hasło: {$rekord['password']}";

            $user_avatar = getFirstImageFromFolder("/var/www/html/files/$user", $user);

            if ($user_avatar == null) {
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
        else
        {
            mysqli_close($link);
            //echo "Błąd w haśle !"; // UWAGA nie wyświetlamy takich podpowiedzi dla hakerów
            header('Location: zadanie.php'); 
            exit;
        }
    }


    function getFirstImageFromFolder(string $folderPath, string $userPath): ?string {
        // Open the directory
        if ($handle = opendir($folderPath)) {
            // Loop through the directory contents
            while (false !== ($entry = readdir($handle))) {
                // Check if the entry is a file and has a valid image extension
                if (is_file($folderPath . '/' . $entry) && preg_match('/\.(gif|png|jpg|jpeg)$/i', $entry)) {
                    // Close the directory handle
                    closedir($handle);
                    // Return the first image found
                    return "/files/$userPath/" . $entry;
                }
            }
            // Close the directory handle
            closedir($handle);
        }
        // Return null if no image is found
        return null;
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