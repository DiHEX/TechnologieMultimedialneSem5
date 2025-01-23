<?php
$db = mysqli_connect("mysql-db", "root", "secret", "tm_mysql_database");
session_start();
if (! isset($_SESSION["zadanie6a-logged-in"])) {
    header("Location: /zadanie6a/auth/login-form.php");
    exit();
}

$current_user_idu = null;
$current_user_name = $_SESSION["zadanie6a-logged-in"];
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
    <link href="/assets/global.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1>Lab 6a</h1>
    <a href="/zadanie6a">Powrót do strony lab6a</a>
    <hr />

    <h2>Formularz dodawania piosenki</h2>

    <form action="songs-add.php" enctype="multipart/form-data" method="POST">
        <div class="form-group">
            <label>Tytuł</label>
            <input type="text" class="form-control" placeholder="(tytuł)" name="song-title" required>
        </div>
        <div class="form-group">
            <label>Wykonawca</label>
            <input type="text" class="form-control" placeholder="(wykonawca)" name="song-musician" required>
        </div>
        <div class="form-group">
            <label>Plik audio</label>
            <input type="file" class="form-control" style="display: block;" name="song-file" required>
        </div>
        <div class="form-group">
            <label>Gatunek</label>
            <select name="song-genre" class="form-control">
                <?php
                $link = mysqli_connect("mysql-db", "root", "secret", "tm_mysql_database");
                $result = mysqli_query($link, "select name from musictype") or die ("DB error");
                while ($row = mysqli_fetch_array ($result)) {
                    echo "<option value='$row[0]'>$row[0]</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label>Tekst (opcjonalny)</label>
            <textarea style="display: block;" class="form-control" name="song-lyrics"></textarea>
        </div>
        <input type="submit" value="Prześlij piosenkę" class="btn btn-success" />
    </form>

    <hr />

    <h2>Lista piosenek</h2>

    <table>
        <tr>
            <th>Title</th>
            <th>Musician</th>
            <th>Datetime</th>
            <th>Lyrics</th>
            <th>Audio</th>
        </tr>

        <?php
            $query = "SELECT * FROM songs";
            $result = $db->query($query);
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                    <td>{$row['title']}</td>
                    <td>{$row['musician']}</td>
                    <td>{$row['datetime']}</td>
                    <td>{$row['lyrics']}</td>
                    <td><audio controls><source src='{$row['filename']}'></audio></td>
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
            <label>Wybierz piosenki</label><br/>

            <div>
                <?php
                $query = "SELECT * FROM songs";
                $result = $db->query($query);
                while ($row = $result->fetch_assoc()) {
                    echo "<div><input type='checkbox' name='playlist-song[]' value='{$row['ids']}' id='playlist-song-{$row['ids']}' /><label for='playlist-song-{$row['ids']}'>{$row['title']} - {$row['musician']}</label></div>";
                }
                ?>
            </div>
        </div>

        <input type="submit" value="Zapisz playlistę" class="btn btn-success" />
    </form>

    <hr />

    <h2 id="playlist-show">Wyświetl playlisty</h2>

    <?php
    $query = "SELECT * FROM playlistname";
    $result = $db->query($query);
    while ($row = $result->fetch_assoc()) {
        if ($row['public'] == 0 && $row['idu'] != $current_user_idu) {
            continue;
        }

        $html_songs = "";
        $result_songs = $db->query("SELECT * FROM playlistdatabase WHERE idpl=" . $row["idpl"]);
        while ($row_song = $result_songs->fetch_assoc()) {
            $song_id = $row_song["ids"];
            $result_song = $db->query("SELECT * FROM songs WHERE ids=".$song_id)->fetch_assoc();

            $html_songs .= "
            <tr>
                <td>{$result_song["title"]} - {$result_song["musician"]}</td>
                <td><audio controls><source src='{$result_song['filename']}'></audio></td>
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
            $html_songs
        </table>
        ";
    }
    ?>

</div>
</body>
</html>
