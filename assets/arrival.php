<?php

class Arrival {
    
    public $time;

    public function write($json) {

        if ($json == false) {
            $data = ['arrivals' => [['id' => 1, 'time' => $this->time]]];
            $jsonToWrite = json_encode($data, JSON_PRETTY_PRINT);
        }
        else {
            $data = json_decode($json, true);
            $array = $data['arrivals'];
            $id = count($array) + 1;

            array_push($array, ['id' => $id, 'time' => $this->time]);
            $data['arrivals'] = $array;

            $jsonToWrite = json_encode($data, JSON_PRETTY_PRINT);
        }
        
        file_put_contents('data/arrivals.json', $jsonToWrite);
    }
}