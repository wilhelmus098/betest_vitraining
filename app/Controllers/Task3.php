<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Task3 extends BaseController
{
    public function index($num, $digit)
    {
        echo "Find $digit in $num <br>";
        echo substr_count($num, $digit) . " occurence found";
    }
}
