<?php

namespace App\Http\Controllers;
use MongoDB\Client as Mongo;
use Illuminate\Support\Facades\Http;

use Illuminate\Http\Request;

class DeathTimeController extends Controller
{
    //
    public function Death(){
        $response = Http::withHeaders([
            'Content-Type' => 'application/json;charset=UTF-8'
        ])
            ->withOptions(["verify" => false])
            ->get('http://127.0.0.1:8000/api/toaps');
        $ex = explode('/', $response);
        $mon = new Mongo;
        $conn = $mon->ipdb->IPmaster;
        $data = $conn->find()->toArray();
        $a = 0;
        $t=date_default_timezone_set('Asia/Bangkok');
        $t = date('Y-m-d H:i:s');
        //print_r($ex);
        for ($i = 1; $i < count($ex); $i++) {
            for ($y = 0; $y < count($data); $y++) {
                if ($ex[$i] === $data[$y]['Max']) {
                    $a = 1;
                }
            }
            if ($a == 1) {
                // $conn = new Mongo;
                // $companydb  = $conn->ipdb;
                // $empcollection = $companydb->IPmaster;
                // $inser = $empcollection->insertMany([
                //     ['Max' => $ex[$i]]

                // ]);
                echo ($ex[$i] . " " . "Online" ." ".$t. "<br>");
            } else {
                echo ($ex[$i] . " " . "Online" ." ".$t. "<br>");
                $conn = new Mongo;
                $companydb  = $conn->ipdb;
                $empcollection = $companydb->IPmaster;
                $inser = $empcollection->insertMany([
                    ['Max' => $ex[$i]]

                ]);
            }
        }
        function myfunction($a, $b)
        {
            if ($a === $b) {
                return 0;
            }
            return ($a > $b) ? 1 : -1;
        }
        for ($z = 0; $z < count($data); $z++) {
            $db = array($data[$z]['Max']);
            $result = array_diff($db, $ex,);
           if (count($result)== 1){
               
            echo implode(" ",$result). " " . "Offline" . " " .$t. "<br>";
           }
           
            
           
        }
        
    }
    }

