<?php

namespace App\Http\Controllers;
use MongoDB\Client as Mongo;
use Illuminate\Http\Request;

class Inputcontroller extends Controller
{
    public function input(Request $req){
        echo 'success';
        $conn =  new Mongo;
        $companydb  = $conn->iparuba;
        $empcollection = $companydb->ipmaster;
        //-----------------------------------------//
        
        $str =  $req->input();
        $inser = $empcollection->insertMany([
            [
                'ip' => $str['master'],
                'address'=>$str['add'],
                'Longitude'=>$str['long'],
                'Latitude '=>$str['lati']

            ]
        ]);
        
    }
}
