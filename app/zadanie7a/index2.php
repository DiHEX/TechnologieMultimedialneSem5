<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kalinowski</title>
    <link href="/assets/global.css" rel="stylesheet">
    <style>p{margin: 0; padding: 0;}</style>
</head>
<body>
<div class="container">
    <p><a href="/zadanie7a">(Powróć do poprzedniej podstrony)</a></p>

    <div id='date'></div>
    <script>
        var evtSource = new EventSource('text_from_db.php');
        var date = document.getElementById('date');
        evtSource.onmessage = function(e) { date.innerHTML = "Tekst z bazy danych: " + e.data; };
        evtSource.onerror = function() { evtSource.close(); console.log('Done!'); };
    </script>
</body>
</html>
