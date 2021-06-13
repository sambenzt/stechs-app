<?php

namespace App\Entities;

class Model {

    public string $vendor;
    public string $name;
    public string $soft;

    public function __construct(string $vendor, string $name, string $soft) {
        $this->vendor = $vendor;
        $this->name = $name;
        $this->soft = $soft;
    }

}
