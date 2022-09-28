<?php

function isDelay($time) {
    $hour = intval( substr($time, 0, 2) );

    if ($hour >= 20) {
        die('nemozne');
    }
    else if ($hour >= 8) {
        return true;
    }
    else {
        return false;
    }
} 

function writeArrival($time, $delay) {
    $WriteFile = fopen('data/prichody.txt', 'a');

    if ($delay) {
        $text = "\n" . $time . ', meskanie;';
    }
    else {
        $text = "\n" . $time . ';';
    }

    fwrite($WriteFile, $text);
    fclose($WriteFile);
}

function outputArrivalFile() {
    $readFile = fopen('data/prichody.txt', 'r');
       
    $data = explode(';', fread( $readFile, filesize('data/prichody.txt') ) );

    for ($i=0; $i < count($data); $i++) { 
        echo "<li> $data[$i] </li>";
    }

    fclose($readFile);
}

$arrivalTime = date('H:i:s');
$arrivalDateTime = date('d.m.Y H:i:s');
$delay = isDelay($arrivalTime);
writeArrival($arrivalDateTime, $delay);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/main.css">
    
    <title>Prichody studentov</title>
</head>
<body>

    <main class="container"> 
        
    <?php
    echo '<h2> Ahoj </h2>';
    
    echo "<h3> Cas tvojho prichodu $arrivalTime </h3>";
    ?>

    <ul class="list-group">
        <?php 
            outputArrivalFile();
        ?>
    </ul>
    
    </main>
</body>
</html>