<?php
    $text1 = $_POST['text1'];

    // Read the existing JSON file
    $jsonFilePath = 'my_file.json';
    $jsonData = file_get_contents($jsonFilePath);
    $data = json_decode($jsonData, true);

    // Update the 'imie' variable
    $data['imie'] = $text1;

    // Write the updated data back to the JSON file
    file_put_contents($jsonFilePath, json_encode($data, JSON_PRETTY_PRINT));

    header("Location: /zadanie7a/formularzPlik.php");
    exit();
?>