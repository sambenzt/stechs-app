<?php

namespace App\Repositories;

use App\Entities\Model;
use App\Interfaces\ModelRepositoryInterface;
use App\Models\ModelsJson;

class ModelRepository implements ModelRepositoryInterface {

    private $model;

    public function __construct() {

        $this->model = new ModelsJson();

    }

    public function getModelsByVendor(string $vendor): array {

        $model_names = [];

        $colletion = $this->model->get();

        $filtered_models = array_filter($colletion, fn($model) => $this->isSameVendor($model->vendor, $vendor));

        foreach ($filtered_models as $model) {

            $model_names[] = $model->name;

        }

        return $model_names;
    }

    public function saveModel(Model $model): bool {

        return $this->model->save($model);

    }

    private function isSameVendor(string $str1, string $str2): bool {

        $str1 = strtolower($str1);

        $str2 = strtolower($str2);

        return str_contains($str1, $str2) || str_contains($str2, $str1);
    }
}