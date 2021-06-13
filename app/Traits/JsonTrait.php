<?php

namespace App\Traits;

trait JsonTrait {

    private function getPath() {
        return base_path() . '/models.json';
    }

    private function readFile() {
        return json_decode(file_get_contents($this->getPath()));
    }
 
     private function saveFile($data) {
 
         $jsonData = json_encode($data, JSON_PRETTY_PRINT);
 
         file_put_contents($this->getPath(), $jsonData);
     }
 
    private function rollback() {
 
         $data = $this->readFile();
 
         array_pop($data->models);
 
         $this->saveFile($data);
    }
 

}