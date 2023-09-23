<?php
/**
 * Created by PhpStorm.
 * User: Partho
 * Date: 9/23/2023
 * Time: 10:56 PM
 */

namespace App\Http\Controllers\Processor;

use App\Http\Controllers\Library;
use App\Http\Controllers\WordMeanings\BengaliMeaning;
use App\Models\Meanings;
use App\Models\PreviousJobExams;
use Illuminate\Support\Facades\Storage;

class AppReadyDataExporter{
    function __construct(){

    }


    public function prepareBcsQuestionBank(){
        $obj  = PreviousJobExams::where('exam', 'BCS')->get()->groupBy('year');
        //return $obj;
        $bcsDataSet = [];
        foreach ($obj as $key=>$val){
            $wordList = [];
            foreach ($val as $row){
                //return $row;
                $word = trim($row->word);
                $bengaliMeaning = new BengaliMeaning();
                $meaning = $bengaliMeaning->simpleBengaliMeaningOf($word);
                $meaning = trim($meaning);
                $wordAndMeaning = $word.' - '.$meaning;
                array_push($wordList, $wordAndMeaning);
            }
            $data['bcs'] = $key;
            $data['wordList'] = $wordList;
            array_push($bcsDataSet, $data);
        }
        return $bcsDataSet;
    }
    
    
    
    public function prepareBankExamsQuestionBank(){
        $obj  = PreviousJobExams::where('exam', '!=', 'BCS')
            //->orderBy('year', 'desc')
            ->get()
            ->groupBy('year');
        //return $obj;
        $bankDataSet = []; $wordList = []; $data = [];
        $lastXmPostY = ""; $lastExam = ""; $lastPostName = ""; $lastYear = "";
        foreach ($obj as $year=>$rows){
            foreach ($rows as $row){
                //return $row;
                $xmPostY = $row->exam.'-'.$row->post_name.'-'.$row->year;
                if($lastXmPostY != $xmPostY){
                    if(sizeof($wordList)>0){
                        sort($wordList);
//                        echo $lastXmPostY." - ".'<br>';
//                        echo implode(", ", $wordList).'<hr>';

                        $data['bank'] = $lastExam;
                        $data['postName'] = $lastPostName;
                        $data['year'] = $lastYear;
                        $data['wordList'] = $wordList;
                        array_push($bankDataSet, $data);

                        $wordList = [];
                    }
                }

                $word = trim($row->word);
                $bengaliMeaning = new BengaliMeaning();
                $meaning = $bengaliMeaning->simpleBengaliMeaningOf($word);
                $meaning = trim($meaning);
                $wordAndMeaning = $word.' - '.$meaning;
                array_push($wordList, $wordAndMeaning);


                $lastXmPostY = $xmPostY;
                $lastExam = $row->exam;
                $lastPostName = $row->post_name;
                $lastYear = $row->year;
            }
        }

        return $bankDataSet;
    }


    public function exportPrevYearQuestions(){
        ini_set("max_execution_time", 30000);

        $bcsDataSet = $this->prepareBcsQuestionBank();
        //return $bcsDataSet;
        Storage::disk('public')->put('bcs_questions_with_bangla_meaning.json', json_encode($bcsDataSet));

        $bankDataSet = $this->prepareBankExamsQuestionBank();
        return $bankDataSet;
        Storage::disk('public')->put('bank_questions_with_bangla_meaning.json', json_encode($bankDataSet));
    }



}