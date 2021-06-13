<?php

namespace App\Repositories;

use App\Entities\CableModem;
use App\Interfaces\CableModemRepositoryInterface;
use App\Models\DocsisUpdate;

class CableModemRepository implements CableModemRepositoryInterface {

    private $model;

    public function __construct() {

        $this->model = new DocsisUpdate();
    }

    public function vendorExists(string $vsi_vendor): bool {

        return $this->model->vendorExists($vsi_vendor)->first() ? true : false;

    }

    public function getCableModems(string $vsi_vendor, array $vsi_models): array {

        $modems = [];

        $results = $this->model->modelsNotIn($vsi_vendor, $vsi_models)->get();

        foreach ($results as $result) {

            $modems[] = new CableModem(
                $result->modem_macaddr,
                $result->ipaddr,
                $result->vsi_model,
                $result->vsi_vendor,
                $result->vsi_swver
            );
        }

        return $modems;
    }   

    public function getByMacAddress(string $modem_macaddr): ?CableModem {
       
        $result = $this->model->byMacAddress($modem_macaddr)->first();

        if($result) {
            return new CableModem(
                $result->modem_macaddr,
                $result->ipaddr,
                $result->vsi_model,
                $result->vsi_vendor,
                $result->vsi_swver
            );
        }

    }

}