<?php

include 'assets/functions.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/main.css">
    
    <title>Tvoj prichod</title>
</head>
<body>
    <main class="container">

    <?php
    $name = getInput();
    $arrivalTime = date('H:i:s');
    $arrivalDateTime = date('d.m.Y H:i:s');
    $delay = isDelay($arrivalTime);
    writeArrival($name, $arrivalDateTime, $delay);

    echo "<h2> Ahoj $name</h2>";
    echo "<h3> Cas tvojho prichodu $arrivalTime </h3>";

    ?>

    <ul class="list-group">
        <?php 
            outputArrivalFile();
        ?>
    </ul>

    <div class = "json_output">
        <?php 
            echo "<pre>";
            print_r (json_decode( getJSONFileContents('students') ), true);
            echo "</pre>";

            preiterateArrivalsJSON();
        ?>
    </div>

    </main>
</body>
</html>