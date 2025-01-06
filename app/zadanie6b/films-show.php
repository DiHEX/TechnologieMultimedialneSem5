<?php
session_start();
$db = mysqli_connect("mysql-db", "root", "secret", "tm_mysql_database");
if (! isset($_SESSION["zadanie6b-logged-in"])) {
    header("Location: /zadanie6b/auth/login-form.php");
    exit();
}

$current_user_idu = null;
$current_user_name = $_SESSION["zadanie6b-logged-in"];
$idu_query = $db->prepare("SELECT id, username FROM users WHERE username=?");
$idu_query->bind_param("s", $current_user_name);
$idu_query->execute();
$idu_query->bind_result($current_user_idu, $current_user_name);
$idu_query->store_result();
$idu_query->fetch();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kalinowski</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <h1>Lab 6b</h1>
    <a href="/zadanie6b">Powrót do strony lab6b</a>
    <hr />

    <h2>Formularz dodawania filmu</h2>

    <form action="films-add.php" enctype="multipart/form-data" method="POST">
        <div class="form-group">
            <label>Tytuł</label>
            <input type="text" class="form-control" placeholder="(tytuł)" name="film-title" required>
        </div>
        <div class="form-group">
            <label>Reżyser</label>
            <input type="text" class="form-control" placeholder="(reżyser)" name="film-director" required>
        </div>
        <div class="form-group">
            <label>Plik wideo</label>
            <input type="file" class="form-control" style="display: block;" name="film-file" required>
        </div>
        <div class="form-group">
            <label>Gatunek</label>
            <select name="film-genre" class="form-control">
                <?php
                $link = mysqli_connect("mysql-db", "root", "secret", "tm_mysql_database");
                $result = mysqli_query($link, "select name from filmtype") or die ("DB error");
                while ($row = mysqli_fetch_array ($result)) {
                    echo "<option value='$row[0]'>$row[0]</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label>Napisy (opcjonalne)</label>
            <textarea style="display: block;" class="form-control" name="film-subtitle"></textarea>
        </div>
        <input type="submit" value="Prześlij film" class="btn btn-success" />
    </form>

    <hr />

    <h2>Lista filmów</h2>

    <table>
        <tr>
            <th>Title</th>
            <th>Director</th>
            <th>Datetime</th>
            <th>Subtitles</th>
            <th>Video</th>
        </tr>

        <?php
            $query = "SELECT * FROM films";
            $result = $db->query($query);
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>{$row['title']}</td>
                    <td>{$row['director']}</td>
                    <td>{$row['datetime']}</td>
                    <td>{$row['subtitle']}</td>
                    <td><video controls><source src='{$row['filename']}'></video></td>
                </tr>";
            }
        ?>
    </table>

    <hr />

    <h2>Utwórz playlistę</h2>
    <form action="playlist-add.php" method="POST">
        <div class="form-group">
            <label>Nazwa playlisty</label>
            <input type="text" class="form-control" placeholder="(nazwa)" name="playlist-name" required>
        </div>

        <div class="form-group">
            <label for="is-public">Czy publiczna?</label>
            <input type="checkbox" class="form-checkbox" placeholder="(nazwa)" name="playlist-public" id="is-public">
        </div>

        <div class="form-group">
            <label>Wybierz filmy</label><br/>

            <div>
                <?php
                $query = "SELECT * FROM films";
                $result = $db->query($query);
                while ($row = $result->fetch_assoc()) {
                    echo "<div><input type='checkbox' name='playlist-film[]' value='{$row['ids']}' id='playlist-film-{$row['ids']}' /><label for='playlist-film-{$row['ids']}'>{$row['title']} - {$row['director']}</label></div>";
                }
                ?>
            </div>
        </div>

        <input type="submit" value="Zapisz playlistę" class="btn btn-success" />
    </form>

    <hr />

    <h2 id="playlist-show">Wyświetl playlisty</h2>

    <?php
    $query = "SELECT * FROM playlistnameFilms";
    $result = $db->query($query);
    while ($row = $result->fetch_assoc()) {
        if ($row['public'] == 0 && $row['idu'] != $current_user_idu) {
            continue;
        }

        $html_films = "";
        $result_films = $db->query("SELECT * FROM playlistdatabaseFilms WHERE idpl=" . $row["idpl"]);
        while ($row_song = $result_films->fetch_assoc()) {
            $song_id = $row_song["ids"];
            $result_film = $db->query("SELECT * FROM films WHERE ids=".$song_id)->fetch_assoc();

            $html_films .= "
            <tr>
                <td>{$result_film["title"]} - {$result_film["director"]}</td>
                <td><video controls style='display: inline;'><source src='{$result_film['filename']}'></video></td>
            </tr>
            ";
        }

        $publicString = $row['public'] == 1 ? 'Tak' : 'Nie';
        echo "
        <table style='margin-bottom: 25px;'>
            <tr>
                <td colspan='2' style='background-color: #dadada; color: black;'>Playlista: {$row['name']}</td>
            </tr>
            <tr>
                <td colspan='2' style='background-color: #dadada; color: black;'>Publiczna: {$publicString}</td>
            </tr>
            $html_films
        </table>
        ";
    }
    ?>

</div>
</body>
</html>
