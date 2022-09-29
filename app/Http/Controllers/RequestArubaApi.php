<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use MongoDB\Client as Mongo;

class RequestArubaApi extends Controller
{
    //
    public function reqaruba()
    {
        $conn =  new Mongo;
        $companydb  = $conn->iparuba;
        $tem = $companydb->temporary;


        $mon = new Mongo;
        $conn = $mon->iparuba->ipmaster;
        $data = $conn->find()->toArray();


        for ($r = 0; $r < count($data); $r++) {

            $ip = $data[$r]['ip'];
            echo $ip . "<br>";
            //dd($ip);
            try {
                $resp = Http::timeout(5)->withHeaders([
                    'Content-Type' => 'application/json;charset=UTF-8'
                ])
                    ->withOptions(["verify" => false])
                    ->post('https://' . $ip . ':4343/rest/login', [
                        'user' => 'admin',
                        'passwd' => 'ssit1234'
                    ]);
                $sid = $resp->json()['sid'];
                $response = Http::withHeaders([
                    'Content-Type' => 'application/json;charset=UTF-8'
                ])
                    ->withOptions(["verify" => false])
                    ->get('https://' . $ip . ':4343/rest/show-cmd?iap_ip_addr=' . $ip . '&cmd=show%20aps&sid=' . $sid);
                $ex = explode('\n', $response);

                // echo"<pre>";
                // print_r($ex);
                // echo"</pre>";
                for ($x = 9; $x < count($ex); $x++) {
                    $keywords = preg_split("/[\s,]+/", $ex[$x]);

                    $inser = $tem->insertMany([
                        ['Max' => $keywords[0],

                        ]


                    ]);
                    echo ($keywords[0] . "<br>");
                }
            } catch (\Illuminate\Http\Client\ConnectionException $e) {
                // echo $ip."<br>";
            }
        }
    }
}
