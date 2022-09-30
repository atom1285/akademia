<?php

require 'assets/studentArrival.php';
require 'assets/arrival.php';

date_default_timezone_set('Europe/Bratislava');

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

function writeArrival($name, $time, $delay) {

    writeArrivalToTXT($name, $time, $delay);
    writeArrivalToStudentsJSON($name, $time, $delay);
    writeArrivalToArrivalsJSON($time);
}

function writeArrivalToTXT($name, $time, $delay) {
    $writeFile = fopen('data/prichody.txt', 'a');

    if ($delay) {
        $text = "\n" . $name . ' ' . $time . ', meskanie;';
    }
    else {
        $text = "\n" . $name . ' ' . $time . ';';
    }

    fwrite($writeFile, $text);
    fclose($writeFile);
}

function getJSONFileContents($fileName) {
    $jsonContents = file_get_contents("data/$fileName.json");
    return $jsonContents;
}

function writeArrivalToStudentsJSON($name, $time, $delay) {

    $newArrival = new studentArrival();
    $newArrival->name = $name;
    $newArrival->time = $time;
    $newArrival->delay = $delay;

    
    $jsonContents = getJSONFileContents('students');

    $newArrival->write($jsonContents);
}

function writeArrivalToArrivalsJSON($time) {

    $newArrival = new Arrival();
    $newArrival->time = $time;

    $jsonContents = getJSONFileContents('arrivals');

    $newArrival->write($jsonContents);
}

function preiterateArrivalsJSON() {
    $data = json_decode(getJSONFileContents('arrivals'), true);
    $arrivals = $data['arrivals'];
    $array = [];

    foreach ($arrivals as $i => $value) {

        $hour = intval( substr($value['time'], 11, -6) );

        if ($hour >= 8) {
            $value['delay'] = true;
        }
        else {
            $value['delay'] = false;
        }
        array_push($array, $value);
    }

    $data['arrivals'] = $array;

    $jsonToWrite = json_encode($data, JSON_PRETTY_PRINT);
    file_put_contents('data/arrivals.json', $jsonToWrite);
}

function outputArrivalFile() {
    $data = explode(';',  file_get_contents('data/prichody.txt'));

    foreach ($data as $i => $value) {
        echo "<li> $value </li>";
    }
}

function getInput() {
    if ( isset($_GET['studentName']) && !empty($_GET['studentName'])) {
        return $_GET['studentName'];
    }
    else {
        return $_POST['studentName'];
    } 
}