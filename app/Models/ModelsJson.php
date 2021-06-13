<?php

namespace App\Models;

use App\Entities\Model;

class ModelsJson {

    private string $filePath;
    private $file;

    public function __construct() {

        $this->filePath = base_path() . '/models.json'; 

        $this->file = json_decode(file_get_contents($this->filePath));
        
    }

    public function get(): array {

        $models = [];

        foreach ($this->file->models as $model) {
            $models[] = new Model($model->vendor, $model->name, $model->soft);
        }

        return $models;
    }

    public function save(Model $new_model): bool {

        array_push($this->file->models, $new_model);

        $jsonData = json_encode($this->file, JSON_PRETTY_PRINT);

        file_put_contents($this->filePath, $jsonData);

        return true;
    }

}
