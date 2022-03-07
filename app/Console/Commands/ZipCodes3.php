<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ZipCodes3 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:zipcodes3';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(){

        ini_set('memory_limit','50000M');

        $xmlDataString = file_get_contents(public_path('zipcodes.xml'));
        $xmlObject = simplexml_load_string($xmlDataString,'SimpleXMLElement',LIBXML_NOWARNING );
                   
        $json = json_encode($xmlObject);
        $phpDataArray = json_decode($json, true); 

        for ($i=0; $i < count($phpDataArray['table'])  ; $i++) { 

            try {

                echo  'Se inserta asentamiento: ' . $phpDataArray['table'][$i]['d_codigo'] . nl2br("\n");


                // se inserta el tipo de asentamiento
                $asentamiento_type = DB::table('settlements_types')
                ->where('name', $phpDataArray['table'][$i]['d_tipo_asenta'])
                ->first();
                
                if(!$asentamiento_type){
                    DB::insert('insert into settlements_types (name) values (?)', 
                    [$phpDataArray['table'][$i]['d_tipo_asenta']]);
                }   

                // una vez que ya insertamos el asentamiento generamos el id
                $asentamiento = DB::table('zipsettlements')
                ->where('name', $phpDataArray['table'][$i]['d_asenta'])
                ->where('id_federal_entity')
                ->first();    
                
                if(!$asentamiento){

                    //buscar el asentamiento id
                    $asentamiento_type_id = DB::table('settlements_types')
                    ->where('name', $phpDataArray['table'][$i]['d_tipo_asenta'])
                    ->first('id');

                    DB::insert('insert into zipsettlements (name,zone_type,settlement_type,id_federal_entity,id_municipality,id_asenta_cpcons,id_settlement_type,codigo) values (?,?,?,?,?,?,?,?)', 
                    [strtoupper($this->eliminar_acentos($phpDataArray['table'][$i]['d_asenta'])),
                    $phpDataArray['table'][$i]['d_zona'],
                    $phpDataArray['table'][$i]['d_tipo_asenta'],
                    $phpDataArray['table'][$i]['c_estado'],
                    $phpDataArray['table'][$i]['c_mnpio'],
                    $phpDataArray['table'][$i]['id_asenta_cpcons'],
                    $asentamiento_type_id->id,
                    $phpDataArray['table'][$i]['d_codigo']]);
                }   
            
            } catch (Exception $e) {
                echo 'Error al ejecutar comando: ',  $e->getMessage(), "\n";
            }
            
        }

        return 'success';

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
}
