<?php
/**
 * Created by PhpStorm.
 * User: parth
 * Date: 10/28/2020
 * Time: 05:08 PM
 */

namespace App\Http\Controllers;


use function Symfony\Component\String\length;

class Library
{
    public function secondHumanReadable($seconds){
        if($seconds < 60){
            return $seconds.' sec';
        }else{
            return round($seconds/60, 1).' min';
        }
    }


    public function generateRandomString($length){
        $ingredients = "abcdefghkjpqrstuvwxyz";
        $arr = str_split($ingredients);
        $string = "";
        $char = "";
        for($i=0; $i < $length; $i++){
            while(str_contains($string, $char)){
                $char = $arr[ rand(0, count($arr)-1) ];
            }
            $string = $string.$char;
        }
        return $string;
    }


    public function forgeAffiliateToken($userId){
        $string = $this->generateRandomString(4);
        $token = substr($string, 0, 2).$userId.substr($string, 2);
        return $token;
    }

}