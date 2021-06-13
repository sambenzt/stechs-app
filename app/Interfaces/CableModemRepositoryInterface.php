<?php

namespace App\Interfaces;

use App\Entities\CableModem;

interface CableModemRepositoryInterface {

    public function vendorExists(string $vendor): bool;

    public function getCableModems(string $vsi_vendor, array $vsi_models): array;

    public function getByMacAddress(string $modem_macaddr): ?CableModem;

}