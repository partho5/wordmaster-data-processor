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



    public function generateRandomString($length, $customIngredients = null) {
        if ($customIngredients === null) {
            $ingredients = "abcdefghijkpqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_+=<>?";
        } else {
            $ingredients = $customIngredients;
        }

        $arr = str_split($ingredients);
        $string = "";
        $char = "";

        for ($i = 0; $i < $length; $i++) {
            while (str_contains($string, $char)) {
                $char = $arr[rand(0, count($arr) - 1)];
            }
            $string .= $char;
        }

        return $string;
    }




    /*
     * Unicode supported
     * */
    public function replaceFirstOccurrence($originalString, $search, $replacement) {
        $pos = mb_strpos($originalString, $search, 0, 'UTF-8');

        if ($pos !== false) {
            $newString = mb_substr($originalString, 0, $pos, 'UTF-8') . $replacement . mb_substr($originalString, $pos + mb_strlen($search, 'UTF-8'), null, 'UTF-8');
            return $newString;
        }

        return $originalString;
    }

}