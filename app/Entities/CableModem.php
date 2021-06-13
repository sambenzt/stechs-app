<?php

namespace App\Entities;

class CableModem {

    public string $modem_macaddr;
    public string $ipaddr;
    public string $vsi_model;
    public string $vsi_vendor;
    public string $vsi_swver;
    public string $soft = 'v1';

    public function __construct(
        string $modem_macaddr,
        string $ipaddr,
        string $vsi_model,
        string $vsi_vendor,
        string $vsi_swver
    ) {
        $this->modem_macaddr = $modem_macaddr;
        $this->ipaddr = $ipaddr;
        $this->vsi_model = $vsi_model;
        $this->vsi_vendor = $vsi_vendor;
        $this->vsi_swver = $vsi_swver;
    }

}
