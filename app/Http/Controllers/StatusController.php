<?php

namespace App\Http\Controllers;

use MongoDB\Client as Mongo;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class StatusController extends Controller
{

    public function stu()
    {
        error_reporting(E_ALL ^ E_NOTICE);
        $response = Http::withHeaders([
            'Content-Type' => 'application/json;charset=UTF-8'
        ])
            ->withOptions(["verify" => false])
            ->get('http://127.0.0.1:8000/api/toaps');
        $ex = explode('/', $response);
        //$ex = array("34:8a:12:cc:b5:58","192.168.207.236","192.168.5.2");
        $mon = new Mongo;
        $conn = $mon->iparuba->ipaps;
        $data = $conn->find()->toArray();
        //-------------------------------------//
        $conn =  new Mongo;
        $companydb  = $conn->iparuba;
        $empcollection = $companydb->ipaps;
        //----------------------------------------//
        $conn =  new Mongo;
        $companydb  = $conn->iparuba;
        $stus = $companydb->status;
        //----------------------------------------//
        $conn =  new Mongo;
        $companydb  = $conn->iparuba;
        $times = $companydb->time;
        //----------------------------------------//
        if (count($data) == 0) {
            for ($i = 0; $i < count($data); $i++) {
                $inser = $empcollection->insertMany([
                    ['Max' => $data[$i]['Max']]

                ]);
            }
        }
        $a = 0;
        $t = date_default_timezone_set('Asia/Bangkok');
        $t = date('Y-m-d H:i:s');
        $Y = date('Y');
        $m = date('m');
        $d = date('d');
        $h = date('H');
        $min = date('i');
        $s = date('s');
        $inser = $times->insertMany([
            [
                'day' => $d,
                'month' => $m,
                'year' => $Y,
                'hour' => $h,
                'minute' => $min

            ]

        ]);
        for ($i = 1; $i < count($ex); $i++) {
            if (count($data) == 0) {
                $inser = $empcollection->insertMany([
                    [
                        'Max' => $ex[$i],


                    ]
                ]);
            }
        }




        for ($i = 0; $i < count($data); $i++) {
            $tyy[] = $data[$i]['Max'];
        }

        //print_r($tyy);
        $arr = [];
        $re = array_diff($ex, $tyy);
        //print_r($re);

        for ($x = 0; $x < count($ex); $x++) {
            //var_dump($re[$x]);
            if ($re[$x] != null) {
                $inser = $empcollection->insertMany([
                    ['Max' => $re[$x]]

                ]);
            }
        }
        //----------------------------------------------------------------------------
        //print_r($ex);
        for ($i = 1; $i < count($ex); $i++) {
            for ($y = 0; $y < count($data); $y++) {
                if ($ex[$i] === $data[$y]['Max']) {
                    $a = 1;
                }
            }
            if ($a == 1) {

                $inser = $stus->insertMany([
                    [
                        'Max' => $ex[$i],
                        'dateTime' => $t,
                        'status' => 'online',

                    ]

                ]);
                echo ($ex[$i] . " " . "Online" . " " . $d . "/" . $m . "/" . $Y . " " . $h . ":" . $min . "น." . "<br>");
            } else {
                echo ($ex[$i] . " " . "Online" . " " . $d . "/" . $m . "/" . $Y . " " . $h . ":" . $min . "น." . "<br>");
                $inser = $stus->insertMany([
                    [
                        'Max' => $ex[$i],
                        'dateTime' => $t,
                        'status' => 'online',
                    ]

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

            if (($result[0] != null)) {

                echo ($result[0]) . " " . "Offline" . " " . $d . "/" . $m . "/" . $Y . " " . $h . ":" . $min . "น." . "<br>";
                $inser = $stus->insertMany([
                    [
                        'Max' => $result[0],
                        'dateTime' => $t,
                        'status' => 'offline',
                    ]

                ]);
            }
        }
    }
}
