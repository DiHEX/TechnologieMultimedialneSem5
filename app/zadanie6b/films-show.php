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
    <link href="/assets/global.css" rel="stylesheet">
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

    <div style="text-align: center;" name="playlist-show">
        <?php
            $query = "SELECT * FROM films";
            $result = $db->query($query);
            $videos = [];
            while ($row = $result->fetch_assoc()) {
            $videos[] = $row['filename'];
            }
        ?>
        <video id="videoPlayer" controls style="width:800px; height: 500px;">
            <source src="<?php echo $videos[0]; ?>">
        </video>
        <script>
            const videos = <?php echo json_encode($videos); ?>;
            let currentVideoIndex = 0;
            const videoPlayer = document.getElementById('videoPlayer');

            videoPlayer.addEventListener('ended', () => {
            currentVideoIndex++;
            if (currentVideoIndex < videos.length) {
                videoPlayer.src = videos[currentVideoIndex];
                videoPlayer.play();
            }
            });
        </script>
        <br />
        <button id="prevButton" class="btn btn-primary">Poprzedni</button>
        <button id="nextButton" class="btn btn-primary">Następny</button>

        <script>
            document.getElementById('prevButton').addEventListener('click', () => {
                if (currentVideoIndex > 0) {
                    currentVideoIndex--;
                    videoPlayer.src = videos[currentVideoIndex];
                    videoPlayer.play();
                }
            });

            document.getElementById('nextButton').addEventListener('click', () => {
                if (currentVideoIndex < videos.length - 1) {
                    currentVideoIndex++;
                    videoPlayer.src = videos[currentVideoIndex];
                    videoPlayer.play();
                }
            });
        </script>
    </div>

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
                    <td><video controls style=\"width: 600px; height: 400px;\"><source src='{$row['filename']}'></video></td>
                </tr>";
            }
        ?>
    </table>
</div>
</body>
</html>
