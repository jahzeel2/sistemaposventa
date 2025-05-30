<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Carbon\Carbon;

class FechaController extends Controller
{
    public $datenow;
    public $datetimenow;
    public $year;
    public $month;
    public $day;
    public $yesterday;
    //public $datecontry;
    public function __construct()
    {
        $datecontry = Carbon::now('America/Mexico_City');
        $this->fecha_hora=$datecontry->toDateTimeString();
        $this->datenow = $datecontry->toDateString();
        $this->datetimenow = $datecontry->toTimeString();
        $this->year = $datecontry->year;
        $this->month = $datecontry->month;
        $this->day = $datecontry->day;
        $this->yesterday = $datecontry->yesterday('America/Mexico_City')->toDateString();


    }

    public function fecha_hora()
    {

        return $this->fecha_hora;
    }


    public function datenow()
    {
        return $this->datenow;
    }

    public function day()
    {
        return $this->day;
    }

    public function month()
    {

        return $this->month;
    }
    
    public function year()
    {
        return $this->year;
    }

    public function timenow()
    {
        return $this->datetimenow;
    }

    public function yesterday()
    {
        return $this->yesterday;
    }

}
//https://www.delftstack.com/es/howto/php/how-to-return-more-values-from-a-php-function/