<?php
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
    // $readFile = fopen("data/$fileName.json", 'r');
    $jsonContents = file_get_contents("data/$fileName.json");
    // fclose($readFile);

    return $jsonContents;
}

function writeArrivalToStudentsJSON($name, $time, $delay) {

    class studentArrival {
        
        public $name;
        public $time;
        public $delay;

        public function write($file, $json) {
              
            if ($json == false) {
                $id = 1;
                $data = array('students' => array($id => array('name' => $this->name, 'time' => $this->time, 'delay' => $this->delay)));
                $jsonToWrite = json_encode($data, JSON_PRETTY_PRINT);
            }
            else {
                $data = json_decode($json);
                $array = $data->students;
                $id = count((array)$array) + 1;
                
                $array->$id = array('name' => $this->name, 'time' => $this->time, 'delay' => $this->delay);

                $data->students = $array;
                $jsonToWrite = json_encode($data, JSON_PRETTY_PRINT);
            }
            
            fwrite($file, $jsonToWrite);
        }
    }

    $newArrival = new studentArrival();
    $newArrival->name = $name;
    $newArrival->time = $time;
    $newArrival->delay = $delay;

    
    $jsonContents = getJSONFileContents('students');

    $writeFile = fopen('data/students.json', 'w');
    $newArrival->write($writeFile, $jsonContents);
    fclose($writeFile);
}

function writeArrivalToArrivalsJSON($time) {

    class Arrival {
        public $time;

        public function write($file, $json) {

            if ($json == false) {
                $id = 1;
                $data = array('arrivals' => array($id => array('time' => $this->time)));
                $jsonToWrite = json_encode($data, JSON_PRETTY_PRINT);
            }
            else {
                $data = json_decode($json);
                $array = $data->arrivals;
                $id = count((array)$array) + 1;
                
                $array->$id = array('time' => $this->time);

                $data->arrivals = $array;
                $jsonToWrite = json_encode($data, JSON_PRETTY_PRINT);
            }
            
            fwrite($file, $jsonToWrite);
        }
    }

    $newArrival = new Arrival();
    $newArrival->time = $time;

    $jsonContents = getJSONFileContents('arrivals');

    $writeFile = fopen('data/arrivals.json', 'w');
    $newArrival->write($writeFile, $jsonContents);
    fclose($writeFile);
}

function preiterateArrivalsJSON() {
    $data = json_decode(getJSONFileContents('arrivals'));
    $arrivals = $data->arrivals;
    
    for ($i=1; $i <= count( (array)$arrivals ); $i++) { 

        $hour = intval( substr($arrivals->$i->time, 11, -6) );

        if ($hour >= 8) {
            $arrivals->$i->delay = true;
        }
        else {
            $arrivals->$i->delay = false;
        }
    }
    $data->arrivals = $arrivals;

    $writeFile = fopen('data/arrivals.json', 'w');
    $jsonToWrite = json_encode($data, JSON_PRETTY_PRINT);
    fwrite($writeFile, $jsonToWrite);
    fclose($writeFile);
}

function outputArrivalFile() {
    $data = explode(';',  file_get_contents('data/prichody.txt'));

    for ($i=0; $i < count($data); $i++) { 
        echo "<li> $data[$i] </li>";
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