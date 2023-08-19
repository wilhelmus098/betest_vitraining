<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Task2 extends BaseController
{
    public function index($num = "10")
    {
        $this->isPrimeNum($num);
    }

    public function isPrimeNum($num) 
    {
        $numList = array_fill(2, $num-1, true);
        // print("<pre>".print_r($num,true)."</pre>");

        for ($p = 2; ($p * $p) < $num; $p++) {
            for ($i = ($p * $p); $i <= $num; $i += $p) {
                $numList[$i] = false;
            }
        }

        print("<pre>".print_r($numList,true)."</pre>");
    }
}
