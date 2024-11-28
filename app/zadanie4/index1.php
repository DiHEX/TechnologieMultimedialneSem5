<?php
    session_start();
    if (!isset($_SESSION["zscan-logged-in"])) {
        header("Location: /zadanie4/auth/login-form.php");
        exit();
    }
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

<div class="container">
    <h1 style="margin-top: 30px;">Zadanie 4</h1>
    <hr />

    <script>
        function fetchContents() {
            fetch("_scan.php").then(data => data.text()).then(data => {
                document.getElementById("main-content").innerHTML = data;

                document.getElementById("host").addEventListener("input", function() {
                    localStorage.setItem("host", this.value);
                });

                document.getElementById("port").addEventListener("input", function() {
                    localStorage.setItem("port", this.value);
                });

                document.getElementById("host").value = localStorage.getItem("host");
                document.getElementById("port").value = localStorage.getItem("port");
            });
        }

        fetchContents();
        setInterval(fetchContents, 10000);
    </script>

    <div id="main-content">
        Trwa ładowanie pomiarów...
    </div>
</div>