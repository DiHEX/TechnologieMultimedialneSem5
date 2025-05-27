<h3 style="margin-top: 30px;">Dostępne lekcje</h3><hr />
<?php
// Pobierz i wyświetl wszystkie lekcje z tabeli "lekcje" MySQL
// Wyświetl je w formie tabeli HTML
$db = mysqli_connect("mysql-db", "root", "secret", "tm_mysql_zadanie14");
if ($db->connect_error) throw new InvalidArgumentException("Database error");

$sql = $db->prepare("SELECT * FROM lekcje");
$sql->bind_result($idl, $idc, $nazwa, $tresc, $plik_multimedialny);
$sql->execute();

$i = 0;
$lessons = [];

while($sql->fetch()) {
    array_push($lessons, $nazwa);
    echo "<div style='border: 1px dotted black; padding: 4px; margin: 5px; margin-bottom: 15px; display: none;' id='t-$i' class='less'>";
    echo "<h3>Lekcja #" . ($idl + 1) . " - " . $nazwa . "</h3>";
    echo "<p>" . $tresc . "</p>";
    if (str_ends_with($plik_multimedialny, "gif") || str_ends_with($plik_multimedialny, "png") || str_ends_with($plik_multimedialny, "jpg")) {
        echo "<a target='_blank' href='{$plik_multimedialny}'><img src='$plik_multimedialny' style='width: 120px; height: 80px;' /></a>";
    } else if (str_ends_with($plik_multimedialny, "mp3")) {
        echo "<audio controls><source src='$plik_multimedialny' type='audio/mpeg'></audio>";
    } else if (str_ends_with($plik_multimedialny, "mp4")) {
        echo "<video width='320' height='240' controls><source src='$plik_multimedialny' type='video/mp4'></video>";
    } else if(strlen($plik_multimedialny) >= 1) {
        echo "<a target='_blank' href='{$plik_multimedialny}'>{$plik_multimedialny}</a>";
    }

    echo "</div>";
    $i++;
}
if ($i == 0) {
    echo "<div>Brak lekcji</div>";
}

echo <<<JSSCRIPT
 <script>
function openLesson(ii) {
    // Set display: none for each element with class "less"
    var elements = document.getElementsByClassName("less");
    for (var i = 0; i < elements.length; i++) {
        elements[i].style.display = "none";
    }

    // Set display: block for element with id "t-i"
    document.getElementById("t-" + ii).style.display = "block";
}
</script>
JSSCRIPT;

$j = 0;
while ($j < $i) {
    echo "<button class='btn btn-sm' style='margin-top: 1px; display: block; color: white;' name='' onclick='openLesson($j)'>Przejdź do lekcji: {$lessons[$j]}</button>";
    $j++;
}
?>

<h3 style="margin-top: 30px;">Dostępne testy</h3><hr />
<?php
// Pobierz i wyświetl wszystkie testy z tabeli "test" MySQL
// Wyświetl je w formie tabeli HTML
$db = mysqli_connect("mysql-db", "root", "secret", "tm_mysql_zadanie14");
$db2 = mysqli_connect("mysql-db", "root", "secret", "tm_mysql_zadanie14");

$sql = $db->prepare("SELECT * FROM test");
$sql->bind_result($idt, $idc, $nazwa, $max_time);
$sql->execute();
// Przy każdym teście wyświetl odpowiadające mu pytania
$sql2 = $db2->prepare("SELECT * FROM pytania WHERE idt=?");
$sql2->bind_param("i", $idt);
$sql2->bind_result($idpyt, $idt, $tresc_pytania, $odpowiedz_a, $odpowiedz_b, $odpowiedz_c, $odpowiedz_d, $a, $b, $c, $d, $plik_multimedialny);
$i = 0;
$tests = [];
$question_ids = [];
while($sql->fetch()) {
    echo "<div style='' class='tt' id='tt-$i' data-active='false' data-timeleft='$max_time' data-maxtime='$max_time'>";
    echo "<form class='test-form' action='pracownik_check_test.php' method='post'>";
    echo "<h3>Test #" . ($idt + 1) . " - " . $nazwa . "</h3>";
    echo "<p>Czas na rozwiązanie: <span class='timecounter'>" . $max_time . "</span> sekund</p>";
    echo "<input type='hidden' value='$idt' name='idt' />";
    $sql2->execute();
    array_push($tests, $nazwa);
    $j = 0;
    while($sql2->fetch()) {
        array_push($question_ids, $idpyt);
        echo "<div style='border: 1px dotted black; padding: 4px; margin: 5px;'>";
        echo "<h4>$tresc_pytania</h4>";
        echo "<div><label><input type='checkbox' class='form-checkbox' name='question_{$idpyt}_answer_a'>$odpowiedz_a</label></div>";
        echo "<input type='hidden' value='$a' name='question_{$idpyt}_answer_a_correct' />";
        echo "<div><label><input type='checkbox' class='form-checkbox' name='question_{$idpyt}_answer_b'>$odpowiedz_b</label></div>";
        echo "<input type='hidden' value='$b' name='question_{$idpyt}_answer_b_correct' />";
        echo "<div><label><input type='checkbox' class='form-checkbox' name='question_{$idpyt}_answer_c'>$odpowiedz_c</label></div>";
        echo "<input type='hidden' value='$c' name='question_{$idpyt}_answer_c_correct' />";
        echo "<div><label><input type='checkbox' class='form-checkbox' name='question_{$idpyt}_answer_d'>$odpowiedz_d</label></div>";
        echo "<input type='hidden' value='$d' name='question_{$idpyt}_answer_d_correct' />";
        echo "</div>";
        $j++;
    }
    $i++;
    echo "<input type='hidden' value='$j' name='licz_pyt' />";
    $question_ids_string = implode(",", $question_ids);
    echo "<input type='hidden' value='$question_ids_string' name='ids_pyt' />";
    echo "<input type='submit' value='Prześlij do sprawdzenia' class='btn btn-success' />";
    echo "</form>";
    echo "</div>";
}
if ($i == 0) {
    echo "<div>Brak testów</div>";
}

echo <<<JSSCRIPT
 <script>
function openTest(ii) {
    // Set display: none for each element with class "less"
    var elements = document.getElementsByClassName("tt");
    for (var i = 0; i < elements.length; i++) {
        elements[i].style.display = "none";
        elements[i].setAttribute("data-active", "false");
        elements[i].setAttribute("data-timeleft", elements[i].getAttribute("data-maxtime"));
    }

    // Set display: block for element with id "tt-i"
    document.getElementById("tt-" + ii).style.display = "block";
    document.getElementById("tt-" + ii).setAttribute("data-active", "true");
}
</script>
JSSCRIPT;

$j = 0;
while ($j < $i) {
    echo "<button class='btn btn-sm' style='margin-top: 1px; display: block; color: white;' name='' onclick='openTest($j)'>Rozpocznij test: {$tests[$j]}</button>";
    $j++;
}
?>

<script>
    setInterval(() => {
        const elements = document.getElementsByClassName("tt");
        for (let i = 0; i < elements.length; i++) {
            if (elements[i].getAttribute("data-active") === "true") {
                let timeleft = parseInt(elements[i].getAttribute("data-timeleft"));
                timeleft--;
                elements[i].setAttribute("data-timeleft", timeleft);
                elements[i].getElementsByClassName("timecounter")[0].innerHTML = timeleft;
                if (timeleft <= 0) {
                    elements[i].getElementsByClassName("test-form")[0].submit();
                }
            }
        }
    }, 1000);
</script>
