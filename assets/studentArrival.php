<?php

class studentArrival {
        
    public $name;
    public $time;
    public $delay;

    public function write($json) {
          
        if ($json == false) {
            $data = ['students' => [['id' => 1, 'name' => $this->name, 'time' => $this->time, 'delay' => $this->delay]] ];
            $jsonToWrite = json_encode($data, JSON_PRETTY_PRINT);
        }
        else {  
            $data = json_decode($json, true);
            $array = $data['students'];
            $id = count($array) + 1;
            
            array_push($array, ['id' => $id, 'name' => $this->name, 'time' => $this->time, 'delay' => $this->delay]);

            $data['students'] = $array;
            $jsonToWrite = json_encode($data, JSON_PRETTY_PRINT);
        }
        
        file_put_contents('data/students.json', $jsonToWrite);
    }
}