<?php

namespace App\Http\Controllers;

use MongoDB\Client as Mongo;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rules\In;

class ViewonoffController extends Controller
{
    public function view()
    {
        error_reporting(E_ALL ^ E_NOTICE);

        $mon = new Mongo;
        $conn = $mon->iparuba->ipaps;
        $ip_db = $conn->find()->toArray();

        $conn =  new Mongo;
        $companydb  = $conn->iparuba;
        $sta = $companydb->statustotals;

        $mon = new Mongo;
        $conn = $mon->iparuba->statustotals;
        $sta_view = $conn->find()->toArray();


        $response = Http::withHeaders([
            'Content-Type' => 'application/json;charset=UTF-8'
        ])
            ->withOptions(["verify" => false])           
            ->get('http://127.0.0.1:8000/api/apistatus');
        $ex = explode(" ", $response);


        $arr_ip[] = 0;        
        $data = array_chunk($ex, 6);

        
        for ($i = 0; $i < count($data) - 1; $i++) {
            $data_arr[] = $data[$i][0];
            if (count($sta_view) == 0) {
                $inser = $sta->insertMany([
                    [
                        'Max' => $data[$i][0],
                        'Apname' => $data[$i][1],
                        'Status' => $data[$i][2],
                        'd/m/y' => $data[$i][3],
                        'time' => $data[$i][4],
                        'ip' => $data[$i][5],
                    ]

                ]);
            }
        }
        for ($l = 0; $l < count($ip_db); $l++) {
            $arr_ip[] = $ip_db[$l]['Max'];
        }
        for ($s = 0; $s < count($sta_view); $s++) {
            $arr_sta[]   =   $sta_view[$s]['Max'];
        }
            if ($arr_sta != null){
            $str_arr = array_diff($arr_ip, $arr_sta);
            $inn = array_intersect($data_arr,$str_arr);
    
        }
       
        
        for ($go = 0; $go <  count($arr_ip); $go++) {

            if ( $inn[$go] != null) {
                         
                   echo $inn[$go]."===".$data[$go][0]."<br>";
                    
                    $inser = $sta->insertMany([
                        [
                            'Max' => $data[$go][0],
                            'Apname' => $data[$go][1],
                            'Status' => $data[$go][2],
                            'd/m/y' => $data[$go][3],
                            'time' => $data[$go][4],
                            'ip' => $data[$go][5],
                        ]

                    ]);
                
            }
        }

      
        for ($j = 0; $j < count($data) - 1; $j++) {
            
            
                $updateResult = $sta->replaceOne(
                ['Max' => $data[$j][0] ],
                [
                    'Max' => $data[$j][0],
                    'Apname' => $data[$j][1],
                    'Status' => $data[$j][2],
                    'd/m/y' => $data[$j][3],
                    'time' => $data[$j][4],
                    'ip' => $data[$j][5]
                ]
            );
           
        
               
            

        }


        return "success ";
    }
}









