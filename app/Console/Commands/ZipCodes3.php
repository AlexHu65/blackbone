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

                $asentamiento = DB::table('zipsettlements')
                ->where('name', $phpDataArray['table'][$i]['d_asenta'])
                ->where('id_federal_entity')
                ->first();    
                
                if(!$asentamiento){
                    DB::insert('insert into zipsettlements (name,zone_type,id_federal_entity,id_municipality,id_asenta_cpcons,codigo) values (?,?,?,?,?,?)', 
                    [$phpDataArray['table'][$i]['d_asenta'],
                    $phpDataArray['table'][$i]['d_tipo_asenta'],
                    $phpDataArray['table'][$i]['c_estado'],
                    $phpDataArray['table'][$i]['c_mnpio'],
                    $phpDataArray['table'][$i]['id_asenta_cpcons'],
                    $phpDataArray['table'][$i]['d_codigo']]);
                }   
            
            } catch (Exception $e) {
                echo 'Error al ejecutar comando: ',  $e->getMessage(), "\n";
            }
            
        }

        return 'success';

    }
}
