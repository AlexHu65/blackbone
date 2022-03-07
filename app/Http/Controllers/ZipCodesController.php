<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ZipSettlements;
use App\FederalEntities;
use App\Municipalities;

class ZipCodesController extends Controller
{
    public function zipCodes(Request $request){

        $zipSettlements = ZipSettlements::where(['codigo' => $request->zip_code])->get(['id', 'name', 'zone_type']);
        $codeFederal = ZipSettlements::where(['codigo' => $request->zip_code])->first(['id_federal_entity']);       
        $municipality = ZipSettlements::where(['codigo' => $request->zip_code])->first(['id_federal_entity', 'id_asenta_cpcons', 'id_municipality']);

        $municiple = Municipalities::where(['id_federal_entity' => $municipality->id_federal_entity,
            'id_municipality' => $municipality->id_municipality])
            ->first();
              

        $response  = [
            'status' => 200,
            'zip_code' => $request->zip_code,
            'locality' => $municiple->name,
            'municipality' => [
                'key' => $municiple->id,
                'name' => $municiple->name
            ],
            'federal_entity' => FederalEntities::find($codeFederal->id_federal_entity),       
            'settlements' => $zipSettlements
        ];

        return response($response,200);


    }
}
