<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ZipSettlements;

class ZipCodesController extends Controller
{
    public function zipCodes(Request $request){

        $zipSettlements = ZipSettlements::where(['codigo' => $request->zip_code])->get(['id', 'name', 'zone_type']);

        $response  = [
            'status' => 200,            
            'zip_code' => $request->zip_code,
            'settlements' => $zipSettlements
        ];

        return response($response,200);


    }
}
