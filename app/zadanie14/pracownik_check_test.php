<?php
require('fpdf/fpdf.php');
session_start();

class PDF extends FPDF {

    // Page header
    function Header() {
        // Set font family to Arial bold
        $this->SetFont('Arial','B',20);

        // Move to the right
        $this->Cell(80);

        // Header
        $this->Cell(50,10,'WYNIKI TWOJEGO TESTU',0,0,'C');

        // Line break
        $this->Ln(20);
    }

    // Page footer
    function Footer() {

        // Position at 1.5 cm from bottom
        $this->SetY(-15);

        // Arial italic 8
        $this->SetFont('Arial','I',8);

        // Page number
        $this->Cell(0,10,'Page ' .
            $this->PageNo() . '/{nb}',0,0,'C');
    }
}

// Instantiation of FPDF class
$pdf = new PDF();

// Define alias for number of pages
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',14);

$question_ids = explode(",", $_POST["ids_pyt"]);
$correct_answers = 0;
foreach ($question_ids as $question_id) {
    // Fetch question data from database
    $db = mysqli_connect("mysql-db", "root", "secret", "tm_mysql_zadanie14");
    $sql = $db->prepare("SELECT * FROM pytania WHERE idpyt = ?");
    $sql->bind_param("i", $question_id);
    $sql->bind_result($idpyt, $idt, $tresc_pytania, $odpowiedz_a, $odpowiedz_b, $odpowiedz_c, $odpowiedz_d, $a, $b, $c, $d, $plik_multimedialny);
    $sql->execute();
    $sql->fetch();

    $answer_a_correct = $_POST["question_{$question_id}_answer_a_correct"];
    $answer_b_correct = $_POST["question_{$question_id}_answer_b_correct"];
    $answer_c_correct = $_POST["question_{$question_id}_answer_c_correct"];
    $answer_d_correct = $_POST["question_{$question_id}_answer_d_correct"];

    $answer_a = isset($_POST["question_{$question_id}_answer_a"]) ? 1 : 0;
    $answer_b = isset($_POST["question_{$question_id}_answer_b"]) ? 1 : 0;
    $answer_c = isset($_POST["question_{$question_id}_answer_c"]) ? 1 : 0;
    $answer_d = isset($_POST["question_{$question_id}_answer_d"]) ? 1 : 0;

    $answer_correct = 0;
    if ($answer_a == $answer_a_correct &&
        $answer_b == $answer_b_correct &&
        $answer_c == $answer_c_correct &&
        $answer_d == $answer_d_correct) {
        $correct_answers++;
        $answer_correct = 1;
    }

    // Replace all polish characters in $tresc_pytania with their latin equivalents
    $tresc_pytania = strtolower($tresc_pytania);
    $tresc_pytania = str_replace("ą", "a", $tresc_pytania);
    $tresc_pytania = str_replace("ć", "c", $tresc_pytania);
    $tresc_pytania = str_replace("ę", "e", $tresc_pytania);
    $tresc_pytania = str_replace("ł", "l", $tresc_pytania);
    $tresc_pytania = str_replace("ń", "n", $tresc_pytania);
    $tresc_pytania = str_replace("ó", "o", $tresc_pytania);
    $tresc_pytania = str_replace("ś", "s", $tresc_pytania);
    $tresc_pytania = str_replace("ź", "z", $tresc_pytania);
    $tresc_pytania = str_replace("ż", "z", $tresc_pytania);

    $pdf->Cell(0, 10, "Pytanie: $tresc_pytania ($answer_correct pkt)", 0, 1);
}

$pdf->Cell(0, 10, "Suma pkt: $correct_answers", 0, 1);
$pdf->Cell(0, 10, "", 0, 1);
$pdf->Cell(0, 10, "Kopia tego raportu zostala przeslana twojemu coachowi", 0, 1, "C");
// $pdf->Output();
$random_name = bin2hex(openssl_random_pseudo_bytes(10));
$pdf->Output("/zadanie14/files/$random_name.pdf", 'F');


// There is SQL table with rows: idw	idp	idt	datetime	punkty	plik_pdf
// Insert a row into this table
$db = mysqli_connect("mysql-db", "root", "secret", "tm_mysql_zadanie14");
$sql = $db->prepare("INSERT INTO wyniki(idw, idp, idt, datetime, punkty, plik_pdf) VALUES (NULL, ?, ?, ?, ?, ?)");
$pdf_url = "/var/www/html/zadanie14/files/$random_name.pdf";
$curdate = date("Y-m-d H:i:s");
$sql->bind_param("iisss", $_SESSION["zadanie14-userid"], $_POST["idt"], $curdate, $correct_answers, $pdf_url );
$sql->execute();

$pdf->Output();