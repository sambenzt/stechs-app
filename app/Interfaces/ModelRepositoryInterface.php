<?php

namespace App\Interfaces;

use App\Entities\Model;

interface ModelRepositoryInterface {

    public function getModelsByVendor(string $vendor): array;

    public function saveModel(Model $model): bool;

}