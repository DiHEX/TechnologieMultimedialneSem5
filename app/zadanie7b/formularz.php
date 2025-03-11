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
    <p><a href="/zadanie7b">(Powróć do poprzedniej podstrony)</a></p>

    <p>Wprowadź pomiary do umieszczenia w bazie:</p>
    <form method="post" action="add.php">
        <div><label>x1</label>
        <input type="number" id="x1" name="x1" required /></div>

        <div><label>x2</label>
        <input type="number" id="x2" name="x2" required /></div>

        <div><label>x3</label>
        <input type="number" id="x3" name="x3" required /></div>

        <div><label>x4</label>
        <input type="number" id="x4" name="x4" required /></div>

        <div><label>x5</label>
        <input type="number" id="x5" name="x5" required /></div>

        <input type="submit" value="Wyślij" />
    </form>
</body>
</html>
