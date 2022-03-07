<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReadXmlController extends Controller
{

    //Utilizamos este metodo para leer un archivo xml primeramente
    public function index(Request $request){

        ini_set('memory_limit','50000M');

        $xmlDataString = file_get_contents(public_path('zipcodes.xml'));
        $xmlObject = simplexml_load_string($xmlDataString,'SimpleXMLElement',LIBXML_NOWARNING );
                   
        $json = json_encode($xmlObject);
        $phpDataArray = json_decode($json, true); 

        echo '<pre>';
        print_r($phpDataArray);
        echo '</pre>';
        
    }
}
