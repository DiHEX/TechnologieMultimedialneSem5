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
        echo"Błąd: ". mysqli_connect_errno()." ".mysqli_connect_error();
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
        $_SESSION ['loggedin'] = true;
        $_SESSION ['userName'] = $user;

        mysqli_query($link, "SET NAMES 'utf8'"); // ustawienie polskich znaków
        mysqli_query($link, "INSERT INTO users (username, password) VALUES ('$user', '$pass')"); // wiersza, w którym login=login z formularza
        //echo "Logowanie Ok. User: {$rekord['username']}. Hasło: {$rekord['password']}";
        header('Location: info.php'); 
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