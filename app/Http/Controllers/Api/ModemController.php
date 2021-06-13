<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ModemService;
use Illuminate\Http\Request;

class ModemController extends Controller
{
    private ModemService $modemService;

    public function __construct(ModemService $modemService) {

        $this->modemService = $modemService;
    }

    public function index(Request $request) {

        $vendor = $request->vendor ? $request->vendor : '';

        if( !$this->modemService->searchVendor($vendor) ) {

            return response()->json(['message' => 'Fabricante no encontrado.'], 404);
        
        }

        $modems = $this->modemService->searchCableModemByVendor($vendor);

        if(count($modems) === 0) {

            return response()->json(['message' => 'No se encontraron modems.' ], 404);
        }

        return response()->json(['data' => $modems], 200);
    }

    public function store($modem_macaddr) {

         if( $this->modemService->saveCableModem($modem_macaddr) ) {

            return response()->json(['message' => 'Modelo guardado.'], 201);

         }

         return response()->json(['message' => 'Modelo no guardado.'], 200);

    }
}
