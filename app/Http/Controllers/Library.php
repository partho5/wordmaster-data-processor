<?php
/**
 * Created by PhpStorm.
 * User: parth
 * Date: 10/28/2020
 * Time: 05:08 PM
 */

namespace App\Http\Controllers;


class Library
{
    public function secondHumanReadable($seconds){
        if($seconds < 60){
            return $seconds.' sec';
        }else{
            return round($seconds/60, 1).' min';
        }
    }
}