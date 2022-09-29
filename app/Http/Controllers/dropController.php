<?php

namespace App\Http\Controllers;
use MongoDB\Client as Mongo;
use Illuminate\Http\Request;

class dropController extends Controller
{
    // 
    public function drop (){
        $conn = new Mongo;
        $companydb  = $conn->iparuba;
    
    
        $delete =$companydb->dropCollection('temporary');
        echo "Drop Success";
     }
}

