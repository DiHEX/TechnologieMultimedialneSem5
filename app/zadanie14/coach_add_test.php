<?php

// Insert test into database
session_start();
$db = mysqli_connect("mysql-db", "root", "secret", "tm_mysql_zadanie14");
if ($db->connect_error) throw new InvalidArgumentException("Database error");

$test_name = $_POST["test_name"];
$test_author = $_SESSION["zadanie14-userid"];
$test_q_count = $_POST["test_questions_count"];
$test_max_time = $_POST["test_max_time"];

// Make SQL Insert
$sql = $db->prepare("INSERT INTO test(idt, idc, nazwa, max_time) VALUES (NULL, ?, ?, ?)");
$sql->bind_param("isi", $test_author, $test_name, $test_max_time);
$sql->execute();

// Get ID of inserted test
$idt = $sql->insert_id;

// Insert questions into database
for ($i = 1; $i <= $test_q_count; $i++) {
    $question = $_POST["test_question_" . $i . "_content"];
    $answer_a = $_POST["test_question_" . $i . "_answer_a"];
    $answer_b = $_POST["test_question_" . $i . "_answer_b"];
    $answer_c = $_POST["test_question_" . $i . "_answer_c"];
    $answer_d = $_POST["test_question_" . $i . "_answer_d"];
    $answer_a_correct = isset($_POST["test_question_" . $i . "_answer_a_correct"]) ? 1 : 0;
    $answer_b_correct = isset($_POST["test_question_" . $i . "_answer_b_correct"]) ? 1 : 0;
    $answer_c_correct = isset($_POST["test_question_" . $i . "_answer_c_correct"]) ? 1 : 0;
    $answer_d_correct = isset($_POST["test_question_" . $i . "_answer_d_correct"]) ? 1 : 0;
    $path_url_file = "";

    $sql = $db->prepare("INSERT INTO pytania(idpyt, idt, tresc_pytania, odpowiedz_a, odpowiedz_b, odpowiedz_c, odpowiedz_d, a, b, c, d, plik_multimedialny) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $sql->bind_param("isssssiiiis", $idt, $question, $answer_a, $answer_b, $answer_c, $answer_d, $answer_a_correct, $answer_b_correct, $answer_c_correct, $answer_d_correct, $path_url_file);
    $sql->execute();
}

header("Location: index.php");