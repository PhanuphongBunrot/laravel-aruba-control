<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class InfoController extends Controller
{
    public function info (){
        $ip = array("172.16.0.50");
        for ($i = 0; $i < count($ip); $i++) {
            $resp = Http::withHeaders([
                'Content-Type' => 'application/json;charset=UTF-8'
            ])
                ->withOptions(["verify" => false])
                ->post('https://' . $ip[$i] . ':4343/rest/login', [
                    'user' => 'admin',
                    'passwd' => 'ssit1234'
                ]);
            $sid = $resp->json()['sid'];
            //echo $sid;
            $response = Http::withHeaders([
                'Content-Type' => 'application/json;charset=UTF-8'
            ])
                ->withOptions(["verify" => false])
                ->get('https://' . $ip[$i] . ':4343/rest/show-cmd?iap_ip_addr=' . $ip[$i] . '&cmd=show%20aps&sid=' . $sid);
            
                $ex = explode('\n', $response);

                // echo"<pre>";
                // print_r($ex);
                // echo"</pre>";
                for ($x = 9; $x < count($ex); $x++) {
                    $keywords = preg_split("/[\s,]+/", $ex[$x]);
                // echo"<pre>";
                // print_r($keywords);
                // echo"</pre>";
                   
                $key = $keywords[0]." " . $keywords[1]." " . $keywords[2]." " . $keywords[6]." " . $keywords[9]." " . $keywords[27]." ";
                    
    
                 echo   $key;
                 
                }
        }
    }
}
