<?php

namespace App\Services;

use App\Entities\Model;
use App\Interfaces\CableModemRepositoryInterface;
use App\Interfaces\ModelRepositoryInterface;

class ModemService {

    private $cableModemRepository;
    private $modelRepository;

    public function __construct(CableModemRepositoryInterface $cableModemRepository, ModelRepositoryInterface $modelRepository) {
        
        $this->cableModemRepository = $cableModemRepository;
        
        $this->modelRepository = $modelRepository;
    }

    public function searchVendor(string $vendor): bool {

        return $this->cableModemRepository->vendorExists($vendor);
    }

    public function searchCableModemByVendor(string $vendor): array {

        $model_names = $this->modelRepository->getModelsByVendor($vendor);
      
        return $this->cableModemRepository->getCableModems($vendor, $model_names);
    }

    public function saveCableModem(string $mac_address): bool {

        $cableModem = $this->cableModemRepository->getByMacAddress($mac_address);
        
        if($cableModem) {
            
            $model = new Model($cableModem->vsi_vendor, $cableModem->vsi_model, $cableModem->soft);
        
            return $this->modelRepository->saveModel($model);
        }

        return false;
    }
    

}