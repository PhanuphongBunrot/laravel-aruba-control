<?php

namespace App\Http\Controllers;

use MongoDB\Client as Mongo;

use Illuminate\Http\Request;

class TimeoutController extends Controller
{
    public function to()
    {
        require 'vendor/autoload.php';
        $mon = new Mongo;
        $conn = $mon->iparuba->time;
        $ti = $conn->find()->toArray();
        //-------------------------------------
        $conn = new Mongo;
        $companydb  = $conn->iparuba;
        $tlod = $companydb->tlod;
        //-------------------------------------
        //print_r($ti);
        $setH = 13;
        $setM = 46;
        for ($t = 0; $t < count($ti); $t++) {
            $timeH[] = $ti[$t]['hour'];
            $timeM[] = $ti[$t]['minute'];
        }
        echo (end($timeH) . ":" . end($timeM) . " น. ");

        if (end($timeH) == $setH && end($timeM) == $setM) {
            echo "Time Out";
            $delete = $companydb->dropCollection('status');
            $delete = $companydb->dropCollection('time');
        }
    }
}
