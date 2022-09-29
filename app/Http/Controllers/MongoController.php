<?php

namespace App\Http\Controllers;

require '../vendor/autoload.php';

use MongoDB\Client as Mongo;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class MongoController extends Controller
{
    //
    public function mongo()
    {
        error_reporting(E_ALL ^ E_NOTICE);
        $mon = new Mongo;
        $conn = $mon->iparuba->status;
        $data = $conn->find()->toArray();
        
        $conn = new Mongo;
        $companydb  = $conn->iparuba;
        $tlod = $companydb->tlod;
        
        $mon = new Mongo;
        $conn = $mon->iparuba->ipaps;
        $dataap = $conn->find()->toArray();
        
        $t = date_default_timezone_set('Asia/Bangkok');
        $t = date('Y-m-d H:i:s');
        $hour = date('H');
        $min = date('i');
        //$a = 5;
        // $mins = $data[0]['min'];
        $saveH = 12;
        $saveM = 4;
        $timeH = 12;
        $timeM = 5; //$mins +7 ;
        
        echo $t . "<br>";
        //echo $future;
        for ($x = 0; $x < count($dataap); $x++) {
        
            $arr2[] = $dataap[$x]['Max'];
        }
        
        
        
        for ($i = 0; $i < count($data); $i++) {
            $arr[] = $data[$i]['Max'];
        }
        //print_r($arr);
        
        $diff  = array_intersect($arr2, $arr);
        //print_r($diff);
        $a = 0;
        $b = 0;
        $c = 0;
        $tobleOff[] = 0;
        $tobleOn[] = 0;
        //-----------ประกาศตัวแปรทั้งหมด
        for ($z = 0; $z < count($diff); $z++) {
            for ($y = 0; $y < count($data); $y++) {
                if ($diff[$z] === $data[$y]['Max']) {
                    $arr3[] = array(
                        'ip' => $data[$y]['Max'],
                        'stu' => $data[$y]['status']
                    );
                }
            }
        }
        
        for ($o = 0; $o < count($diff); $o++) {
            //echo ($diff[$o]);
            for ($z = 0; $z < count($arr3); $z++) {
                //echo ($arr3[$z]);
                if ($diff[$o]  === $arr3[$z]['ip']) {
                    $c = $c + 1;
                    //echo ($arr3[$z]['ip']. " ".$arr3[$z]['stu']." ". $c ."<br>") ;
                    if ($arr3[$z]['stu'] === "online") {
                        //echo ($arr3[$z]['ip']. " ".$arr3[$z]['stu']." ". $c ."<br>") ;
                        $tobleOn[] = $a = $a + 1;
                        //echo $a;
                        //echo ($diff[$o]." "."online ทั้งหมด".$a ."ชั่วโมง" . "<br>"); 
                    } else if ($arr3[$z]['stu'] === "offline") {
                        $tobleOff[] = $b = $b + 1;
                        //echo $b;
                    }
                } else if ($diff[$o] !== $arr3[$z]) {
                    $c = 0;
                    $a = 0;
                    $b = 0;
                }
            }
            //echo(end($tobleOn)." ".end($tobleOff));
        
            if ($saveH == $hour && $saveM == $min) {
                $inser = $tlod->insertMany([
                    [
                        'Max' => $diff[$o],
                        'Time' => $t,
                        'online' => end($tobleOn),
                        'offline' => end($tobleOff)
                    ]
        
                ]); //การเเอดข้อมูลลงใน mongoDB
        
            } else if ($timeH == $hour && $timeM == $min) {
                $tobleOff[] = 0;
                $tobleOn[] = 0;
                $delete = $companydb->dropCollection('status');
            }
            echo ($diff[$o] . " " . "online ทั้งหมด" . " " . end($tobleOn) . "ชั่วโมง และ offline ทั้งหมด" . " " . end($tobleOff) . "ชั่วโมง  <br>");
            // var_dump(end($tobleOff));
            // print_r(end($tobleOn)) ;
            // print_r(end($tobleOff)) ;
        }
    }
}
