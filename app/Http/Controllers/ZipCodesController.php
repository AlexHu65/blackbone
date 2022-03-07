<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ZipSettlements;
use App\FederalEntities;
use App\Municipalities;

class ZipCodesController extends Controller
{
    public function zipCodes(Request $request){

        $zipSettlements = ZipSettlements::with('settlements_type')->where(['codigo' => $request->zip_code])->get(['id_asenta_cpcons as key', 'name', 'zone_type', 'id_settlement_type']);

		foreach ($zipSettlements as $key => $value) {
			unset($value->id_settlement_type);
			unset($value->settlements_type->id);
		}

        $codeFederal = ZipSettlements::where(['codigo' => $request->zip_code])->first(['id_federal_entity']);       
        $municipality = ZipSettlements::where(['codigo' => $request->zip_code])->first(['id_federal_entity', 'id_asenta_cpcons', 'id_municipality']);

        $municiple = Municipalities::where(['id_federal_entity' => $municipality->id_federal_entity,
            'id_municipality' => $municipality->id_municipality])
            ->first();

        $federalEntity =  FederalEntities::find($codeFederal->id_federal_entity);
        $code = $this->getStates(strtoupper($this->eliminar_acentos($federalEntity->name)));
              

        $response  = [
            'zip_code' => $request->zip_code,
            'locality' => strtoupper($this->eliminar_acentos($municiple->ciudad)),
            'municipality' => [
                'key' => $municiple->id_municipality,
                'name' => strtoupper($this->eliminar_acentos($municiple->name))
            ],
            'federal_entity' => [
                "key" => $federalEntity->id,
                "name" => strtoupper($this->eliminar_acentos($federalEntity->name)),
                "code" => $this->getStates(strtoupper($this->eliminar_acentos($federalEntity->name)))['clave']
            ],       
            'settlements' => $zipSettlements
        ];

        return response($response,200);


    }

    function eliminar_acentos($cadena){
		
		//Reemplazamos la A y a
		$cadena = str_replace(
		array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
		array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
		$cadena
		);
 
		//Reemplazamos la E y e
		$cadena = str_replace(
		array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
		array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
		$cadena );
 
		//Reemplazamos la I y i
		$cadena = str_replace(
		array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
		array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
		$cadena );
 
		//Reemplazamos la O y o
		$cadena = str_replace(
		array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
		array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
		$cadena );
 
		//Reemplazamos la U y u
		$cadena = str_replace(
		array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
		array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
		$cadena );
 
		//Reemplazamos la N, n, C y c
		$cadena = str_replace(
		array('Ñ', 'ñ', 'Ç', 'ç'),
		array('N', 'n', 'C', 'c'),
		$cadena
		);
		
		return $cadena;
	}


    public function getStates($state){
        $states = json_decode(file_get_contents(public_path('states.json')), true);
        foreach ($states as $key => $value) {
            if($value['nombre'] == $state){
                return $value;                
            }
        }
    }
    
}
