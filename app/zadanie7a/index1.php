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

    <p>Tekst z pliku: <span class="status"></span></p>
    <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script>
        (function()
        {
            var status = $('.status'),
                poll = function()
                {
                    $.ajax(
                        {
                            url: 'my_file.json',
                            dataType: 'json',
                            type: 'get',
                            cache: false,
                            success: function(data) { status.text(data.imie); },
                            error: function() { console.log('Error!'); }
                        });
                },
                pollInterval = setInterval(function() {poll();}, 2000);
            poll(); // init
        })();
    </script>
</body>
</html>
