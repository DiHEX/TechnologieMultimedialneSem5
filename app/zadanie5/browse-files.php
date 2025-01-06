<?php
session_start();
if (! isset($_SESSION["zadanie5-logged-in"])) {
    header("Location: /zadanie5");
    exit();
}
$currentSubDir = $_GET["subdir"] ?? "";
if ($currentSubDir == "/") {
    header("Location: browse-files.php");
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kalinowski</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href=
    "https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" />

    <style>
        .file {
            font-size: 115%;
        }
        * {
            vertical-align: middle;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Lab 5</h1>
    <a href="/zadanie5">Powrót do strony głównej</a>
    <hr />

    <?php
    $currentSubDir = $_GET["subdir"] ?? "";

    if ($currentSubDir == "") {
        $previousSubDir = null;
    } else {
        $previousSubDir = dirname($currentSubDir);
    }

    if ($previousSubDir != null && $currentSubDir != "/") {
        echo "<p style='font-weight: bold;'><a href='browse-files.php?subdir=$previousSubDir'>&larr; Poprzedni folder: $previousSubDir</a></p>";
    }

    $baseDirPath = "/var/www/html/user_storage/{$_SESSION["zadanie5-logged-in"]}";
    $dirPath = $baseDirPath . $currentSubDir;

    if (!is_dir($dirPath)) {
        mkdir($dirPath, 0777, true);
    } 

    if (is_dir($dirPath)) {
        $files = array_filter(scandir($dirPath), function($path) {
           return !str_starts_with($path, ".");
        });

        foreach ($files as $file) {
            $filePath = $dirPath . '/' . $file;
            echo "<p class='file'>";
            if (is_file($filePath)) {
                $fileUrl = "/user_storage/{$_SESSION["zadanie5-logged-in"]}$currentSubDir/$file";
                $fileUrlExploded = explode(".", $fileUrl);
                $fileExtension = end($fileUrlExploded);

                if (in_array($fileExtension, ["png", "jpg", "jpeg", "bmp", "gif"])) {
                    $fileType = "image";
                } else if (in_array($fileExtension, ["mp4", "avi", "mkv"])) {
                    $fileType = "video";
                } else if (in_array($fileExtension, ["mp3", "wav", "ogg"])) {
                    $fileType = "audio";
                } else {
                    $fileType = "else";
                }

                echo "<i class='bi bi-file-earmark'></i> ";
                echo "<a href='$fileUrl'>Plik: $file</a> ";
                echo "<a href='/zadanie5/delete-file.php?subdir=$currentSubDir&filename=$file'><i class='bi bi-trash'></i></a>";

                if ($fileType == "image") {
                    echo "<br/><a href='$fileUrl'><img src='{$fileUrl}' style='width: 32px; height: 64px;' /></a>";
                } else if ($fileType == "audio") {
                    echo "<br/><audio controls style='display: inline;'><source src='$fileUrl'></audio>";
                } else if ($fileType == "video") {
                    echo "<br/><video controls style='display: inline;'><source src='$fileUrl'></video>";
                }
            } else if (is_dir($filePath)) {
                $nextSubDir = $currentSubDir . '/' . $file;
                echo "<i class='bi bi-folder'></i> ";
                echo "<a href='/zadanie5/browse-files.php?subdir=$nextSubDir'>Folder: $file</a>";
                echo "<a href='/zadanie5/delete-dir.php?subdir=$currentSubDir&subdirToDelete=$nextSubDir'> <i class=\"bi bi-trash\"></i></a>";
            }
            echo "</p>";
        }

        if (count($files) == 0) {
            echo "<p>Ten folder jest pusty</p>";
        }
    } else {
        echo "Błąd 404 ścieżki!";
    }
    ?>

    <hr />

    <div>
        <button class="btn btn-info" id="add-file-btn">
            <i class="bi bi-plus-circle"></i> Dodaj plik
        </button>
        <button class="btn btn-info" id="add-dir-btn">
            <i class="bi bi-folder-plus"></i> Dodaj folder
        </button>
    </div>

    <div id="add-dir-modal" class="margin-top: 40px;">
        <p>
            <strong><i class="bi bi-folder-plus"></i> Tworzenie folderu</strong>
        </p>
        <form action="create-dir.php?subdir=<?php echo $currentSubDir; ?>" method="POST">
            <input type="text" class="form-control" placeholder="(nazwa folderu)" required name="newdir" style="width: 30%; display: inline-block;" />
            <input type="submit" value="Utwórz folder" class="btn btn-sm btn-success" style="width: 30%; display: inline-block;" />
        </form>
    </div>

    <div id="add-file-modal" class="margin-top: 40px;">
        <p>
            <strong><i class="bi bi-plus-circle"></i> Dodawanie pliku</strong>
        </p>
        <form action="upload-file.php?subdir=<?php echo $currentSubDir; ?>" method="POST" enctype='multipart/form-data'>
            <input type="file" class="form-control" placeholder="(plik)" required name="newfile" style="width: 30%; display: inline-block;" />
            <input type="submit" value="Dodaj plik" class="btn btn-sm btn-success" style="width: 30%; display: inline-block;" />
        </form>
    </div>

    <script>
        const addDirModal = document.getElementById("add-dir-modal");
        const addFileModal = document.getElementById("add-file-modal");

        addDirModal.style.display = "none";
        addFileModal.style.display = "none";

        document.getElementById("add-file-btn").addEventListener("click", () => {
            addDirModal.style.display = "none";
            addFileModal.style.display = "block";
        });

        document.getElementById("add-dir-btn").addEventListener("click", () => {
            addDirModal.style.display = "block";
            addFileModal.style.display = "none";
        });
    </script>
</div>
</body>
</html>
