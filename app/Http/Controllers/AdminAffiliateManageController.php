<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminAffiliateManageController extends Controller
{
    public function index(Request $request){

        $path = storage_path().'/visitor_logs.json';
        $json = json_decode(file_get_contents($path));
        $data = $json[2]->data;
        foreach ($data as $obj){
            if(str_contains($obj->client, "M2003J15SC")){
                //echo "<p>".$obj->client."</p>";
            }
        }

        $client = "Mozilla/5.0 (Linux; Android 12; CPH2269 Build/SP1A.210812.016; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/106.0.5249.126 Mobile Safari/537.36 [FB_IAB/FB4A;FBAV/390.0.0.27.105;]";
        //$client = "Mozilla\/5.0 (Linux; Android 11; Redmi Note 9 Pro Max Build\/RKQ1.200826.002; wv) AppleWebKit\/537.36 (KHTML, like Gecko) Version\/4.0 Chrome\/106.0.5249.126 Mobile Safari\/537.36 [FB_IAB\/FB4A;FBAV\/390.0.0.27.105;";
        $client = $data[14]->client;
        //return $client;

        $androidVersion = "";

        $pattern='/Android \d{1,2}/m';
        if (preg_match($pattern, $client, $match)){
            // $match[0] should be like 'Android x' or 'Android xx'
            $androidVersion = substr($match[0], 8);
            echo $androidVersion;
        }
        echo "<br>";

        $pattern='/(Android \d{1,2};) (\w|\s)+ Build/m';
        if (preg_match($pattern, $client, $match)){
            // $match[0] should be like 'Android X; MODEL_NUMBER Build'
            //echo $match[0];
            $modelNumber = preg_replace('/Android (\d{1,2}); /', '', $match[0]);
            $modelNumber = preg_replace('/ Build/', '', $modelNumber);
            echo $modelNumber;
        }else{
            echo 'no match';
        }




        //return "AdminAffiliateManageController";
    }
}