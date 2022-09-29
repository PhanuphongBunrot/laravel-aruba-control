<?php

namespace App\Http\Controllers;

use MongoDB\Client as Mongo;
use Illuminate\Http\Request;

class CheckMasterController extends Controller
{
    public function check()
    {
        error_reporting(E_ALL ^ E_NOTICE);


        //$ex = array("34:8a:12:cc:b5:58","192.168.207.236","192.168.5.2");
        $mon = new Mongo;
        $conn = $mon->iparuba->ipaps;
        $data = $conn->find()->toArray();
        //-------------------------------------//
        $conn =  new Mongo;
        $companydb  = $conn->iparuba;
        $empcollection = $companydb->ipaps;
        //----------------------------------------//
        $mon = new Mongo;
        $conn = $mon->iparuba->ipaps;
        $aps = $conn->find()->toArray();
        //----------------------------------------//
        $mon = new Mongo;
        $conn = $mon->iparuba->temporary;
        $tem = $conn->find()->toArray();
        //----------------------------------------//
        $conn =  new Mongo;
        $companydb  = $conn->iparuba;
        $off = $companydb->offline;
        //-------------------------------------//
        $conn =  new Mongo;
        $companydb  = $conn->iparuba;
        $on = $companydb->online;
        //-------------------------------------//
        //var_dump ($tem);
       // print_r ($aps);
        $ex = [];
        for ($g = 0 ; $g < count($tem) ;$g++){
            $ex [] = $tem[$g]['Max'];
        }
        //print_r($ex);
                
                if (count($data) == 0) {
                    for ($i = 0; $i < count($data); $i++) {
                        $inser = $empcollection->insertMany([
                            ['Max' => $data[$i]['Max'],
                            'Apname'=>'ArubaAP',
                            'S/N' => '--'
                            ]

                        ]);
                    }
                }
                $toon[] = 0;
                $tooff[] = 0;
                $o = 0;
                $f = 0;
                $t = date_default_timezone_set('Asia/Bangkok');
                $t = date('Y-m-d H:i:s');
                $Y = date('Y');
                $m = date('m');
                $d = date('d');
                $h = date('H');
                $min = date('i');
                $s = date('s');
               // print_r($ex);
                for ($i = 0; $i < count($ex); $i++) {
                    if (count($data) == 0) {
                        $inser = $empcollection->insertMany([
                            [
                                'Max' => $ex[$i],
                                'Apname'=>'ArubaAP',
                                'S/N' => '--'
                            ]
                        ]);
                    }
                }

                for ($i = 0; $i < count($data); $i++) {
                    $tyy[] = $data[$i]['Max'];
                }

               // print_r($tyy);
                $arr = [];
                $re = array_diff($ex, $tyy);
                //print_r($ex);
                //var_dump($re);
                for ($x = 0; $x < count($ex); $x++) {
                   // var_dump($re[$x]);
                    if ($re[$x] != null) {
                        $inser = $empcollection->insertMany([
                            ['Max' => $re[$x],
                            'Apname'=>'ArubaAP',
                            'S/N' => '--'
                            ]


                        ]);
                    }
                }
            //     //----------------------------------------------------------------------------
            //print_r($tyy);
            $ex1 = array_intersect($tyy,$ex);
            print_r($ex1);
                for ($i = 0; $i < count($ex1); $i++) {
                    for ($y = 0; $y < count($data); $y++) {
                        if ($ex1[$i] === $data[$y]['Max']) {
                            $a = 1;
                           // echo ($ex1[$i]." ".$i."<br>");
                        }
                    }
                    if ($a == 1) {
                        $toon[] = $o = $o + 1;
                        // $inser = $on->insertMany([
                        //     ['Max' => $ex1[$i],
                        //      'Status' => 'Online',
                        //     'd/m/y'=> $d . "/" . $m . "/" . $Y,
                        //     'time' => $h . ":" . $min  
                        //     ]


                        // ]);
                         // print_r ($ex1[$i]."<br>");      
                       // echo ($ex1[$i] . " " .$data[$i]['Apname']. " Online" . " " . $d . "/" . $m . "/" . $Y . " " . $h . ":" . $min  . " ");
                       //echo ($data[$i]['Apanme']);
                    } else {

                        $toon[] = $o + 1;
                        //echo ($ex1[$i] . " " . "Online" . " " . $d . "/" . $m . "/" . $Y . " " . $h . ":" . $min . "น." . "<br>");
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
                    $result = array_diff($db, $ex1,);
                    if (($result[0] != null)) {
                        $tooff[] = $f= $f + 1;
                        // $inser = $off->insertMany([
                        //     ['Max' => $result[0],
                        //      'Status' => 'Offline',
                        //     'd/m/y'=> $d . "/" . $m . "/" . $Y,
                        //     'time' => $h . ":" . $min  
                        //     ]


                        // ]);
                       // echo ($result[0]) . " " .$data[$z]['Apname']." "."Offline" . " " . $d . "/" . $m . "/" . $Y . " " . $h . ":" . $min  . " ";
                    }
                }

                echo(end($toon)." ".end($tooff));

    }
}
