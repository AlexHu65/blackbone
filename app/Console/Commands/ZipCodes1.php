<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ZipCodes1 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:zipcodes1';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crea las entidades federativas para la tabla';

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

        for ($i=0; $i < count($phpDataArray['table']); $i++) { 

            try {

                echo  'Se inserta entidad: ' . $phpDataArray['table'][$i]['d_codigo'] . nl2br("\n");

                $entidad = DB::table('federal_entities')
                ->where('name', $phpDataArray['table'][$i]['d_estado'])
                ->first();    
                
                if(!$entidad){
                    DB::insert('insert into federal_entities (id,name,code) values (?,?,?)', 
                    [$phpDataArray['table'][$i]['c_estado'],
                    $phpDataArray['table'][$i]['d_estado'],
                    $phpDataArray['table'][$i]['d_estado']]);
                }   
            
            } catch (Exception $e) {
                echo 'Error al ejecutar comando: ',  $e->getMessage(), "\n";
            }
            
        }

        return 'success';

    }
}
