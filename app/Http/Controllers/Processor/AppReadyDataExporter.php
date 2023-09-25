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


                /************** ESSENTIAL ************
                 * uncommenting this chunk will show which words/phrases don't have meaning set in database.
                 * Need to update raw file / database word field in `previous_job_exams` table.
                 * Decide later when app grows significantly
                 * ***********************************/
                /*
                if(! isset($meaning) || empty($meaning)){
                    echo $word."  --at $xmPostY <br>";
                }
                */
            }
        }

        return $bankDataSet;
    }


    public function exportPrevYearQuestions(){
        ini_set("max_execution_time", 30000);

        $savePath = "/private/word_data_for_android";

        $bcsDataSet = $this->prepareBcsQuestionBank();
        //return $bcsDataSet;
        Storage::disk('local')->put($savePath.'/'.'bcs_questions_with_bangla_meaning.json', json_encode($bcsDataSet));
        //echo "BCS words save in $savePath<br>";

        $bankDataSet = $this->prepareBankExamsQuestionBank();
        return $bankDataSet;
        Storage::disk('local')->put($savePath.'/'.'bank_questions_with_bangla_meaning.json', json_encode($bankDataSet));
        echo "Bank words save in $savePath<br>";
    }






    public function importPrevYearQuestions(){
        ini_set("max_execution_time", 30000);

        $this->insertWordsFromQuestionBank();
    }

    private function insertWordsFromQuestionBank(){
        $startFileNo = 49;
        $endFileNo = 54;
        $fileDir = storage_path("app/private/bank_question_words");
        for($i = $startFileNo; $i <= $endFileNo; $i++){
            $filePath = $fileDir.'/'.$i.'.json';
            $this->insertWordsFromFile($filePath);
            echo "$filePath inserted<br>";
        }
    }

    private function insertWordsFromFile($filePath){
        $json = json_decode(file_get_contents($filePath));

        $dataToInsert = []; // Initialize an array to store data for bulk insert

        foreach ($json as $object) {
            // Check if 'wordList' property exists and is an array
            if (isset($object->wordList) && is_array($object->wordList)) {
                foreach ($object->wordList as $word) {
                    // Create data for each word and add it to the bulk insert array
                    $dataToInsert[] = [
                        'word' => $word, // Insert each word separately
                        'exam' => $object->bankName,
                        'post_name' => $object->postName,
                        'year' => $object->examYear,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }

        //dd($dataToInsert);

        // Perform a single bulk insert operation
        PreviousJobExams::insert($dataToInsert);
    }





}