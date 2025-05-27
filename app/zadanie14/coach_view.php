
<h3 style="margin-top: 30px;">Twoje lekcje</h3><hr />
<?php
// Pobierz i wyświetl wszystkie lekcje z tabeli "lekcje" MySQL
// Wyświetl je w formie tabeli HTML
$db = mysqli_connect("mysql-db", "root", "secret", "tm_mysql_zadanie14");
if ($db->connect_error) throw new InvalidArgumentException("Database error");

$sql = $db->prepare("SELECT * FROM lekcje WHERE idc=?");
$sql->bind_param("i", $_SESSION["zadanie14-userid"]);
$sql->bind_result($idl, $idc, $nazwa, $tresc, $plik_multimedialny);
$sql->execute();

$i = 0;
while($sql->fetch()) {
    echo "<div style='border: 1px dotted black; padding: 4px; margin: 5px;'>";
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

    echo "<div><a href='coach_delete_lesson.php?idl=$idl' class='btn btn-sm' style='margin-top: 3px;'>Usuń tę lekcję</a></div>";

    echo "</div>";
    $i++;
}
if ($i == 0) {
    echo "<div>Brak lekcji</div>";
}
?>

<h3 style="margin-top: 30px;">Twoje testy</h3><hr />
<?php
// Pobierz i wyświetl wszystkie testy z tabeli "test" MySQL
// Wyświetl je w formie tabeli HTML
$db = mysqli_connect("mysql-db", "root", "secret", "tm_mysql_zadanie14");
$db2 = mysqli_connect("mysql-db", "root", "secret", "tm_mysql_zadanie14");

$sql = $db->prepare("SELECT * FROM test WHERE idc=?");
$sql->bind_param("i", $_SESSION["zadanie14-userid"]);
$sql->bind_result($idt, $idc, $nazwa, $max_time);
$sql->execute();
// Przy każdym teście wyświetl odpowiadające mu pytania
$sql2 = $db2->prepare("SELECT * FROM pytania WHERE idt=?");
$sql2->bind_param("i", $idt);
$sql2->bind_result($idpyt, $idt, $tresc_pytania, $odpowiedz_a, $odpowiedz_b, $odpowiedz_c, $odpowiedz_d, $a, $b, $c, $d, $plik_multimedialny);
$i = 0;
while($sql->fetch()) {
    echo "<div style='border: 1px dotted black; padding: 4px; margin: 5px;'>";
    echo "<h3>Test #" . ($idt + 1) . " - " . $nazwa . "</h3>";
    echo "<p>Czas na rozwiązanie: " . $max_time . " sekund</p>";
    $sql2->execute();
    while($sql2->fetch()) {
        echo "<div style='border: 1px dotted black; padding: 4px; margin: 5px;'>";
        echo "<h4>$tresc_pytania</h4>";
        echo "<p>A: " . $odpowiedz_a . ($a == 1 ? " (poprawna)" : " (niepoprawna)") . "</p>";
        echo "<p>B: " . $odpowiedz_b . ($b == 1 ? " (poprawna)" : " (niepoprawna)") ."</p>";
        echo "<p>C: " . $odpowiedz_c . ($c == 1 ? " (poprawna)" : " (niepoprawna)") ."</p>";
        echo "<p>D: " . $odpowiedz_d . ($d == 1 ? " (poprawna)" : " (niepoprawna)") . "</p>";
        echo "</div>";
    }
    echo "<div><a href='coach_delete_test.php?idt=$idt' class='btn btn-sm' style='margin-top: 3px;'>Usuń ten test</a></div>";
    echo "</div>";
    $i++;
}
if ($i == 0) {
    echo "<div>Brak testów</div>";
}
?>

<h3 style="margin-top: 30px;">Dodaj lekcję</h3><hr />
<form method="POST" action="coach_add_lesson.php" enctype="multipart/form-data">
    <div class="form-group">
        <label>Nazwa lekcji</label>
        <input type="text" placeholder="(wpisz nazwę lekcji)" class="form-control" name="lesson_name" required>
    </div>

    <div class="form-group">
        <label>Treść lekcji</label>
        <div style="color: black;">
            <textarea name="lesson_content" id="editor1"></textarea>
        </div>
    </div>

    <div class="form-group">
        <label>Dodaj plik (opcjonalnie)</label>
        <input type="file" name="lesson_file" style="color: white;"  />
    </div>

    <div class="form-group">
        <input type="submit" value="Dodaj lekcję" class="btn btn-success">
    </div>
</form>
<script>
    ClassicEditor
        .create( document.querySelector( '#editor1' ) )
        .catch( error => {
            console.error( error );
        } );
</script>

<h3 style="margin-top: 30px;">Dodaj test</h3><hr/>
<form method="POST" action="coach_add_test.php" enctype="multipart/form-data">
    <div class="form-group">
        <label>Nazwa testu</label>
        <input type="text" placeholder="(wpisz nazwę testu)" class="form-control" name="test_name" required>
    </div>

    <div class="form-group">
        <label>Czas testu (sekundy)</label>
        <input type="number" class="form-control" name="test_max_time" required />
    </div>

    <div class="form-group">
        <label>Ilość pytań</label>
        <input type="number" class="form-control" name="test_questions_count" id="test_questions_count" required />
    </div>

    <div id="questions">
    </div>

    <input type="submit" value="Zapisz test" class="btn btn-success" />
</form>

<script>
    const qTpl = `
        <div class="form-group" style="border: 1px dotted black; padding: 4px;">
            <label style="font-weight: bold">Pytanie #NUM</label>
            <div>
                <label>Treść pytania</label>
                <input type="text" class="form-control" name="test_question_NUM_content" required />
                <div style="margin-bottom: 5px; margin-top: 5px;">
                    <label>Opowiedź A</label>
                    <input type="text" class="form-control" name="test_question_NUM_answer_a" required />
                    <input type="checkbox" class="form-group" name="test_question_NUM_answer_a_correct"> Czy A poprawna?
                </div>
                <div style="margin-bottom: 5px; margin-top: 5px;">
                    <label>Opowiedź B</label>
                    <input type="text" class="form-control" name="test_question_NUM_answer_b" required />
                    <input type="checkbox" class="form-group" name="test_question_NUM_answer_b_correct"> Czy B poprawna?
                </div>
                <div style="margin-bottom: 5px; margin-top: 5px;">
                    <label>Opowiedź C</label>
                    <input type="text" class="form-control" name="test_question_NUM_answer_c" required />
                    <input type="checkbox" class="form-group" name="test_question_NUM_answer_c_correct"> Czy C poprawna?
                </div>
                <div style="margin-bottom: 5px; margin-top: 5px;">
                    <label>Opowiedź D</label>
                    <input type="text" class="form-control" name="test_question_NUM_answer_d" required />
                    <input type="checkbox" class="form-group" name="test_question_NUM_answer_d_correct"> Czy D poprawna?
                </div>
            </div>
        </div>
    `;

    document.getElementById("test_questions_count").addEventListener("input", (ev) => {
        let questionsCount = ev.target.value;
        let questionsHtml = "";
        for(let i = 0; i < questionsCount; i++) {
            questionsHtml += qTpl.replace(/NUM/g, i + 1);
        }
        document.getElementById("questions").innerHTML = questionsHtml;
    })
</script>

<h3 style="margin-top: 30px;">Wyniki twoich testów</h3>
<hr />
<?php
// Pobierz i wyświetl wyniki z tabeli "wyniki" MySQL
// Wyświetl je w formie tabeli HTML
$db = mysqli_connect("mysql-db", "root", "secret", "tm_mysql_zadanie14");
if ($db->connect_error) throw new InvalidArgumentException("Database error");
$sql = $db->prepare("SELECT * FROM `wyniki` JOIN test ON wyniki.idt = test.idt JOIN user ON wyniki.idp = user.userid WHERE test.idc=?");
$sql->bind_param("i", $_SESSION["zadanie14-userid"]);
$sql->bind_result($idw, $idp, $idt, $data, $pkt, $url_pdf, $idtt, $idct, $nazwat, $max_timet, $useridu, $usernameu, $passwordu, $userranku);
$sql->execute();
while ($sql->fetch()) {
    echo "<div style='border: 1px dotted black; padding: 4px; margin: 5px;'>";
    echo "<p>Test: " . $nazwat . "</p>";
    echo "<p>Pracownik: $usernameu</p>";
    echo "<p>Punkty: " . $pkt . "</p>";
    echo "<p><a href='$url_pdf'>Pobierz PDF</a></p>";
    echo "</div>";
}