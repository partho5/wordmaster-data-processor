<?php


/**
 * Created by PhpStorm.
 * User: Partho
 * Date: 10/11/2023
 * Time: 9:46 PM
 */


namespace App\Http\Controllers\Processor\Word;

use App\Models\Words;


class WordDataProcessor{

    public function idOfWord($word){
        $w = Words::where('word', $word)->pluck('id');
        if(count($w) > 0){
            $wid = $w[0];
            return $wid;
        }
        return null;
    }


}

