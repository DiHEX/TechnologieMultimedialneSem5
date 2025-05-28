<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalinowski</title>

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" />
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.27.3/ui/trumbowyg.min.css"  crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.27.3/trumbowyg.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <style>
        p {
            margin: 0;
        }

        #chatbot-history > div {
            margin-top: 6px;
            margin-bottom: 6px;
        }
    </style>
</head>
<body class="container" style="margin-top: 30px">
    <div class="row" style="text-align: center; margin-bottom: 15px;">
        <?php
            $connection = mysqli_connect("mysql-db", "root", "secret", "tm_mysql_zadanie16");
            $select_query = $connection->prepare("SELECT filename FROM logo");
            $select_query->bind_result($logo_url);
            $select_query->execute();
            $select_query->fetch();
        ?>

        <?php if(isset($_SESSION['is-admin'])) { ?>
            <div class="col-md-8">
                <img src="<?php echo $logo_url; ?>" alt="logo firmy" style="max-width: 175px; display: inline-block;" />
            </div>
            <div class="col-md-4">
                <form action="/zadanie16/actions/upload-logo.php" method="post" enctype="multipart/form-data">
                    <label for="logo-input">Zmień logotyp:</label>
                    <input type="file" class="form-control" id="logo-input" name="logo-input" />
                    <input type="submit" value="Zapisz" class="btn btn-primary btn-sm" />
                </form>
            </div>
        <?php } else { ?>
            <img src="<?php echo $logo_url; ?>" alt="logo firmy" style="max-width: 175px; display: inline-block;" />
        <?php } ?>
    </div>

    <div class="row">
        <div class="col-md-4">
            <nav>
                <h2>Nawigacja</h2>
                <ul class="list-group">
                    <li class="list-group-item"><a href="index.php">Strona główna</a></li>
                    <li class="list-group-item"><a href="index.php?page=about-company">O firmie</a></li>
                    <li class="list-group-item"><a href="index.php?page=contact">Kontakt</a></li>
                    <li class="list-group-item"><a href="index.php?page=how-to-reach-us">Jak do nas dotrzeć?</a></li>
                    <li class="list-group-item"><a href="index.php?page=offers">Oferta</a></li>
                    <li class="list-group-item"><a href="index.php?page=chatbot">Chatbot</a></li>
                    <li class="list-group-item"><a href="index.php?page=chatbot-history">Historia Chatbota</a></li>
                </ul>
            </nav>

            <div style="margin-top: 10px; margin-bottom: 20px;">
                <h2>Logowanie admina</h2>
                <?php
                    if (isset($_GET['error'])) {
                        $error = $_GET['error'];
                        if ($error == "cred-empty") {
                            echo "<div class='alert alert-danger' role='alert'>Wprowadź nazwę użytkownika i hasło.</div>";
                        } else if ($error == "cred-invalid") {
                            echo "<div class='alert alert-danger' role='alert'>Nieprawidłowe dane logowania.</div>";
                        }
                    }
                ?>

                <?php if (isset($_SESSION['is-admin'])) { ?>
                    <p>Jesteś zalogowany jako administrator.</p>
                    <p><a href="/zadanie16/actions/logout.php">Wyloguj mnie</a></p>
                <?php } else { ?>
                    <form style="margin-top: 7px;" action="/zadanie16/actions/login.php" method="post">
                        <div>
                            <label for="username-input" class="form-label">Nazwa użytkownika</label>
                            <input type="text" class="form-control" id="username-input" name="username">
                        </div>
                        <div>
                            <label for="password-input" class="form-label">Hasło</label>
                            <input type="password" class="form-control" id="password-input" name="password">
                        </div>
                        <div>
                            <input type="submit" class="btn btn-primary" value="Zaloguj" />
                        </div>
                    </form>
                <?php } ?>
            </div>

        </div>

        <main class="col-md-8">
            <?php
                if (isset($_GET['page'])) {
                    $page = $_GET['page'];
                    include "subpages/$page.php";
                } else {
                    echo "<h2>Strona główna</h2>Wybierz podstronę, korzystając z menu dostępnego w lewej krawędzi ekranu.";
                }
            ?>
        </main>
    </div>
</body>
</html>
