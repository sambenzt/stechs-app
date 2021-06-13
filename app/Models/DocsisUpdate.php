<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocsisUpdate extends Model
{
    protected $table = 'docsis_update';

    protected $columns = [
        'modem_macaddr',
        'ipaddr',
        'vsi_model',
        'vsi_vendor',
        'vsi_swver'
    ];

    public function scopeVendorExists($query, string $vsi_vendor) {

        return $query->select($this->columns)->where('vsi_vendor', 'like', "%{$vsi_vendor}%");

    }

    public function scopeModelsNotIn($query, string $vsi_vendor, array $vsi_models) {

        return $query->select($this->columns)->where('vsi_vendor', 'like', "%{$vsi_vendor}%")->whereNotIn('vsi_model', $vsi_models);

    }

    public function scopeByMacAddress($query, string $modem_macaddr) {

        return $query->select($this->columns)->where('modem_macaddr', $modem_macaddr);

    }

}
