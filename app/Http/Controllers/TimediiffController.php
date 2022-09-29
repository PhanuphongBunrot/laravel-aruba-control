<?php

namespace App\Http\Controllers;

use MongoDB\Client as Mongo;

use Illuminate\Http\Request;

class TimediiffController extends Controller
{
    public function td()
    {
        $mon = new Mongo;
        $conn = $mon->iparuba->status;
        $data = $conn->find()->toArray();
        //-------------------------------------//
        $conn = new Mongo;
        $companydb  = $conn->iparuba;
        $tlod = $companydb->tlod;
        //-------------------------------------//
        $mon = new Mongo;
        $conn = $mon->iparuba->ipaps;
        $dataap = $conn->find()->toArray();
        //-------------------------------------//

        $t = date_default_timezone_set('Asia/Bangkok');
        $T = date('Y-m-d H:i');
        $hour = 15;
        $min = 22;

        $mon = new Mongo;
        $conn = $mon->iparuba->time;
        $ti = $conn->find()->toArray();
        $conn = new Mongo;
        $companydb  = $conn->iparuba;
        $tlod = $companydb->tlod;
        //print_r($ti);
        for ($t = 0; $t < count($ti); $t++) {
            $timeH[] = $ti[$t]['hour'];
            $timeM[] = $ti[$t]['minute'];
        }
        echo (end($timeH) . ":" . end($timeM) . " น. ");


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
        $ap = [];
        //-----------ประกาศตัวแปรทั้งหมด----------//
        for ($z = 0; $z < count($diff); $z++) {
            for ($y = 0; $y < count($data); $y++) {
                //  echo $diff[$z];
                // echo $data[$y]['Max'];
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

                    if ($arr3[$z]['stu'] === "online") {


                        $tobleOn[] = $a = $a + 1;
                    } else if ($arr3[$z]['stu'] === "offline") {
                        $tobleOff[] = $b = $b + 1;
                        $ap[] = $arr3[$z];
                    }
                } else if ($diff[$o] !== $arr3[$z]) {
                    $c = 0;
                    $a = 0;
                    $b = 0;
                }
            }
            echo ($diff[$o] . " " . "online ทั้งหมด" . " " . end($tobleOn) . "ชั่วโมง และ offline ทั้งหมด" . " " . end($tobleOff) . " ชั่วโมง  <br>");

            //echo(end($tobleOn)." ".end($tobleOff));

            if (end($timeH) == $hour && end($timeM) == $min) {
                $inser = $tlod->insertMany([
                    [
                        'Max' => $diff[$o],
                        'Time' => $T,
                        'online' => end($tobleOn),
                        'offline' => end($tobleOff)
                    ]

                ]); //การเเอดข้อมูลลงใน mongoDB

            } else if (end($timeH) == $hour && $timeM == $min) {
                $tobleOff[] = 0;
                $tobleOn[] = 0;
            }
            $tobleOn[] = 0;
            $tobleOff[] = 0;
        }
    }
}
