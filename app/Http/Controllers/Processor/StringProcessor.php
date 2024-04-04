<?php
/**
 * Created by PhpStorm.
 * User: Partho
 * Date: 4/5/2024
 * Time: 12:53 AM
 */

namespace App\Http\Controllers\Processor;


class StringProcessor{

    function containsBangla($s){
        $containsBangla = false;
        $splited = mb_str_split($s);
        foreach ($splited as $c){
            if($this->uniord($c) > 2432 && $this->uniord($c) < 2559){
                //its bengali character
                $containsBangla = true;
            }
        }
        return $containsBangla;
    }

    function containsBanglaChar($s) {
        // Define a regular expression pattern to match Bengali characters
        $pattern = '/[\x{0980}-\x{09FF}]/u';

        // Use preg_match to check if the string contains any Bengali characters
        return preg_match($pattern, $s);
    }

}