<?php
session_start();

// Sprawdzenie uprawnień administratora
if (!$_SESSION["zadanie14-rank"] == "admin") {
    header('HTTP/1.1 403 Forbidden');
    exit('Brak dostępu.');
}

// Połączenie z bazą danych
$db = mysqli_connect("mysql-db", "root", "secret", "tm_mysql_zadanie14");
if ($db->connect_error) {
    exit('Błąd połączenia z bazą danych.');
}

// Walidacja parametru userid
if (!isset($_GET['userid']) || !filter_var($_GET['userid'], FILTER_VALIDATE_INT)) {
    exit('Nieprawidłowe ID użytkownika.');
}
$userid = (int) $_GET['userid'];

// 2. Jeśli coach – usuń jego pytania, testy i lekcje
// Pobranie rangi użytkownika
$sel = $db->prepare("SELECT userrank FROM user WHERE userid = ?");
$sel->bind_param("i", $userid);
$sel->execute();
$sel->bind_result($rank);
$sel->fetch();
$sel->close();

if ($rank === 'coach') {
    // usuń pytania należące do jego testów
    $q = $db->prepare(
        "DELETE FROM pytania 
         WHERE idt IN (SELECT idt FROM test WHERE idc = ?)"
    );
    $q->bind_param("i", $userid);
    $q->execute();
    // usuń testy
    $q = $db->prepare("DELETE FROM test WHERE idc = ?");
    $q->bind_param("i", $userid);
    $q->execute();
    // usuń lekcje
    $q = $db->prepare("DELETE FROM lekcje WHERE idc = ?");
    $q->bind_param("i", $userid);
    $q->execute();
}

// Przygotowanie i wykonanie zapytania DELETE
$stmt = $db->prepare("DELETE FROM user WHERE userid = ?");
$stmt->bind_param("i", $userid);
$stmt->execute();

// Obsługa wyniku
if ($stmt->affected_rows > 0) {
    header('Location: ./index.php');
    exit;
} else {
    exit('Użytkownik nie został znaleziony.');
}
