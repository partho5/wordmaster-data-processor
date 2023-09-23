<?php
/**
 * Created by PhpStorm.
 * User: Partho
 * Date: 9/24/2023
 * Time: 12:33 AM
 */



namespace App\Http\Controllers\WordMeanings;


use App\Http\Controllers\Library;
use App\Models\Meanings;


class BengaliMeaning{

    /*
     * Primarily designed for Question bank. To show simple Bengali meaning of word alongside English word in question bank
     * */
    public function simpleBengaliMeaningOf($word){
        $bangla = "";
        $Lib = new Library();
        $meaning = Meanings::where('word_id', function ($query) use ($word){
            $query->select('id')
                ->from('words')
                ->where('word', $word);
        })
            ->where('bangla_meaning', '!=', '*')
            ->where('bangla_meaning', '!=', '#')
            ->limit(1)
            ->get();

        if(count($meaning) > 0){
            $bangla = $meaning[0]['bangla_meaning'];
            $bangla = $Lib->replaceFirstOccurrence($bangla, "*", "");
            $bangla = $Lib->replaceFirstOccurrence($bangla, "#", "");
            $bangla = trim($bangla);

            if (preg_match('/^[0-9]+\.\s*/', $bangla)) {
                //remove numbering 1. , 2. etc. if exists. because we will add numbering manually. If we dont remove starting number, some definition may look like: "1.1. definition here"
                $bangla = preg_replace('/^[0-9]+\.\s*/', '', $bangla);
            }
        }

        return $bangla;
    }

}