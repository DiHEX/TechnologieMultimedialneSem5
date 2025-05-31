<h3>Panel Administratora</h3><hr/>

<?php
$db = mysqli_connect("mysql-db","root","secret","tm_mysql_zadanie14");
if($db->connect_error) throw new InvalidArgumentException("DB error");

// 1. Lista coachów
echo "<h4>Coachowie</h4>";
$sql = $db->prepare("SELECT userid,username FROM user WHERE userrank='coach'");
$sql->execute(); $sql->bind_result($uid,$uname);
while($sql->fetch()){
    echo "<div>{$uname} ";
    echo "<a href='admin_delete_user.php?userid={$uid}' class='btn btn-sm btn-danger'>Usuń</a>";
    echo "</div>";
}

// 2. Lista pracowników
echo "<h4>Pracownicy</h4>";
$sql = $db->prepare("SELECT userid,username FROM user WHERE userrank='pracownik'");
$sql->execute(); $sql->bind_result($uid,$uname);
while($sql->fetch()){
    echo "<div>{$uname} ";
    echo "<a href='admin_delete_user.php?userid={$uid}' class='btn btn-sm btn-danger'>Usuń</a>";
    echo "</div>";
}

// 3. Lista lekcji
echo "<h4>Wszystkie lekcje</h4>";
$sql = $db->prepare("SELECT idl,nazwa FROM lekcje");
$sql->execute(); $sql->bind_result($idl,$ln);
while($sql->fetch()){
    echo "<div>{$ln} ";
    echo "<a href='coach_delete_lesson.php?idl={$idl}' class='btn btn-sm btn-danger'>Usuń lekcję</a>";
    echo "</div>";
}

// 4. Lista testów
echo "<h4>Wszystkie testy</h4>";
$sql = $db->prepare("SELECT idt,nazwa FROM test");
$sql->execute(); $sql->bind_result($idt,$tn);
while($sql->fetch()){
    echo "<div>{$tn} ";
    echo "<a href='coach_delete_test.php?idt={$idt}' class='btn btn-sm btn-danger'>Usuń test</a>";
    echo "</div>";
}
?>
