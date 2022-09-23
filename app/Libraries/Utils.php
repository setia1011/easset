<?php

namespace App\Libraries;

class Utils
{

    public function dateTimeId($date)
    {
        $d = date_create($date);
        $dx = date_format($d, "d-m-Y H:i:s");
        return $dx;
    }

    public function dateId($date)
    {
        $d = date_create($date);
        $dx = date_format($d, "d-m-Y");
        return $dx;
    }

    public function dateSys($date)
    {
        $d = date_create($date);
        $dx = date_format($d, "Y-m-d");
        return $dx;
    }

    public function strToDateWithSlash($str)
    {
        return substr(str_replace("/", "", $str), 4, 4) . '-' . substr(str_replace("/", "", $str), 2, 2) . '-' . substr(str_replace("/", "", $str), 0, 2);
    }

    public function passCharExs() {
        return "@, #, &, !";
    }
}
