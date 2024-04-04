<?php
/**
 * Created by PhpStorm.
 * User: Partho
 * Date: 9/23/2023
 * Time: 10:56 PM
 */

namespace App\Http\Controllers\Processor;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Library;
use App\Http\Controllers\MyConstants;
use App\Http\Controllers\Processor\Word\WordDataProcessor;
use App\Http\Controllers\WordMeanings\BengaliMeaning;
use App\Models\Meanings;
use App\Models\PreviousJobExams;
use App\Models\WordUsages;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


use App\Models\Mnemonics;
use App\Models\Notes;
use App\Models\PartsOfSpeech;
use App\Models\Words;
use App\Models\Synonyms;
use Illuminate\Http\Request;


class AppReadyDataExporter{
    function __construct(){

    }

    private $savePath = "/private/word_data_for_android";


    function prepareWordsForAndroid(){
        $start = round(microtime(true)*1000);

        if(! Auth::id()){
            abort(403);
        }

        ini_set("max_execution_time", 30000);

        $wordsPerFile = 500;
        $startIndex = 1;
        $savePath = $this->savePath;

        $fetchableWordsCount = count($this->wordsToFetch($startIndex, "8000"));//8000 is just an assumed max value, we won't extract more words than this number.
        $numOfFiles = ceil( $fetchableWordsCount/$wordsPerFile );

        for($fileNo=1; $fileNo <= $numOfFiles; $fileNo++){
            $wordData = [];
            $words = $this->wordsToFetch($startIndex, $wordsPerFile);
            //return $words;

            foreach ($words as $word){
                array_push($wordData, $this->extractEverythingOfWord($word));
            }
            //return ($wordData);

            Storage::disk('local')->put($savePath.'/'.$fileNo.'.json', json_encode($wordData));

            //if $words collection has last display_index n, then next start with n+1
            $ws = sizeof($words)-1;
            $ws = $ws<0? 0 : $ws;
            $startIndex = $words[$ws]['display_index'] + 1;
        }

        echo "words JSON files saved in ".storage_path($savePath)."<br>";


        /************ Now export question bank **************/
        $this->exportPrevYearQuestions();


        $end = round(microtime(true)*1000);

        return 'Time taken : '.(($end-$start)/1000).' seconds';
    }




    /*
    public function fetchWordData(Request $request){
        //if device_id not in database, this call is from a newly installed device
        ini_set("max_execution_time", 30000);
        $start = round(microtime(true)*1000);
        $howManyWordsFetch = 2;
        $retVal = [];

        if($request->has('start_word_index')
            //&& $request->has('device_id')
        ){

            $words = $this->wordsToFetch($request->start_word_index, $howManyWordsFetch);

            foreach ($words as $word){
                array_push($retVal, $this->extractEverythingOfWord($word));
            }

            Storage::disk('public')->put('words_for_android1.json', json_encode($retVal));

            return $retVal;
            return count($retVal);


            $end = round(microtime(true)*1000);
            return (($end-$start)/1000) .' sec';
        }
    }
    */


    function wordsToFetch($start_word_index, $howManyWordsFetch){
        $words = Words::where('display_index', '>=', $start_word_index)
            ->where('importance_level', '>=', MyConstants::$minImportanceLevelForMainWords)
            ->orderBy('display_index', 'asc')
            ->limit($howManyWordsFetch)
            ->get(['id', 'word', 'display_index', 'importance_level', 'is_spelling_noticeable']);
        return $words;
    }


    public function extractEverythingOfWord($word){
        $wordId = $word->id;
        $meaningsCollection = Meanings::where('word_id', $wordId)
//            ->where('bangla_meaning', '!=', '*')
//            ->where('bangla_meaning', '!=', '#')
            ->limit(4)->get(['bangla_meaning']);
        $allMeanings = [];
        foreach ($meaningsCollection as $row){
            $meaning = $row->bangla_meaning;
            array_push($allMeanings, $meaning);
//            if(strpos($meaning, '.' != false)){
//                if($meaning[strlen($meaning)-1] == ":"){
//                    //take only 1 definition from cambridge dictionary
//                    //got the 1st definition of cambridge, thats enough for now
//                    break;
//                }
//            }
        }
        $word['meanings'] = $allMeanings;


        $notes = Notes::where('word_id', $wordId)->get();
        if(count($notes) > 0){
            $word['word_note'] = $notes[0]->word_note;
        }


        $mnemonicsCollection = Mnemonics::where('word_id', $wordId)->get(['mnemonic']);
        if(count($mnemonicsCollection) > 0){
            $word['mnemonic'] = $mnemonicsCollection[0]->mnemonic;
        }else{
            $word['mnemonic'] = null;
        }


        // $categoryCollection = WordCategories::where('word_id', $wordId)->get(['category_id']);
        // $allCategories = [];
        // foreach ($categoryCollection as $row){
        //     array_push($allCategories, $row->category_id);
        // }
        // $word['categories'] = $allCategories;


        $pofCollection = PartsOfSpeech::where('word_id', $wordId)
            ->whereNotNull('parts_of_speech')
            ->limit(1)
            ->get(['parts_of_speech']);
        $pofs = [];
        foreach ($pofCollection as $row){
            array_push($pofs, $row->parts_of_speech);
        }
        $word['pofs'] = $pofs;


        // $derivedCollection = DerivedWords::where('word_id', $wordId)->get(['derived_word_id']);
        // $deriveds = [];
        // foreach ($derivedCollection as $row){
        //     array_push($deriveds, $row->derived_word_id);
        // }
        // $word['derived'] = $deriveds;


        $synoCollection = Synonyms::where('word_id', $wordId)->where('take', 1)->get(['synonym_word_id']);
        $syno = [];
        foreach ($synoCollection as $row){
            $w = Words::find($row->synonym_word_id);
            // https://stackoverflow.com/questions/53020833/count-parameter-must-be-an-array-or-an-object-that-implements-countable-in-lar
            if(count( array($w) )>0){
                array_push($syno, $w->word);
            }
        }
        $word['synonyms'] = $syno;


        // $antoCollection = Antonyms::where('word_id', $wordId)->get(['antonym_word_id']);
        // $anto = [];
        // foreach ($antoCollection as $row){
        //     $w = Words::find($row->antonym_word_id);
        //     if(count($w)>0){
        //         array_push($anto, $w->word);
        //     }
        // }
        // $word['antonyms'] = $anto;



        $usesCollection = WordUsages::where('word_id', $wordId)
            ->where('sentence', 'NOT LIKE', '>%')
            ->limit(6)->get(['sentence']);
        $allSentences = [];
        foreach ($usesCollection as $row){
            array_push($allSentences, $row->sentence);
        }
        $word['uses'] = $allSentences;

        return $word;
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

                if(isset($meaning) && !empty($meaning)){
                    //don't add the word not having Bangla meaning. In later version we will add all the meanings
                    array_push($wordList, $wordAndMeaning);
                }



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


        /**  Add the last entry. it was prepared in the last iteration of loop, but it didn't get pushed in main array **/

        if(sizeof($wordList)>0){
            sort($wordList);

            $data['bank'] = $lastExam;
            $data['postName'] = $lastPostName;
            $data['year'] = $lastYear;
            $data['wordList'] = $wordList;
            array_push($bankDataSet, $data);
        }



        return $bankDataSet;
    }


    public function exportPrevYearQuestions(){
        ini_set("max_execution_time", 30000);

        $savePath = $this->savePath;

        $bcsDataSet = $this->prepareBcsQuestionBank();
        //return $bcsDataSet;
        Storage::disk('local')->put($savePath.'/'.'bcs_questions_with_bangla_meaning.json', json_encode($bcsDataSet));
        echo "BCS words save in ".storage_path($savePath)."<br>";

        $bankDataSet = $this->prepareBankExamsQuestionBank();
        //return $bankDataSet;
        Storage::disk('local')->put($savePath.'/'.'bank_questions_with_bangla_meaning.json', json_encode($bankDataSet));
        echo "Bank words save in ".storage_path($savePath)."<br>";
    }






    public function importPrevYearQuestions(){
        ini_set("max_execution_time", 30000);

        $this->insertWordsFromQuestionBank();
    }

    private function insertWordsFromQuestionBank(){
        $startFileNo = 49;
        $endFileNo = 54;
        $fileDir = storage_path("app/private/bank_question_words_json");
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




    public function mostFrequentExamWords($numOfWordsToFetch, $importanceLevel){
        $results = DB::select("SELECT pje.word AS word, COUNT(pje.word) AS frequency FROM previous_job_exams pje JOIN words w ON pje.word = w.word GROUP BY word ORDER BY frequency DESC LIMIT $numOfWordsToFetch");

        $dataArray = [];
        foreach ($results as $examWord){
            $word =  $examWord->word;
            $data['word'] = $word;


            $wordProcessor = new WordDataProcessor();
            $banglaMeaning = new BengaliMeaning();
            $wid = $wordProcessor->idOfWord($word);
            if(! is_null($wid)){
                $synonyms = (new AdminController())->extractSynonymWordsWithImportanceLevel($wid, $importanceLevel);
                $synonymsArray = [];
                if (!is_null($synonyms)) {
                    foreach ($synonyms as $synonym){
                        $synonymWord = $synonym->synoword;

                        $syn['word'] = $synonymWord;

                        /*
                         * all perfect synonyms are not marked yet. so some synonyms are fetched which are distant in meaning.
                         * so better not to show bangla right now
                         * */
                        //$syn['meaning'] = $banglaMeaning->simpleBengaliMeaningOf($synonymWord);

                        array_push($synonymsArray, $syn);
                    }

                    $data['synonyms'] = $synonymsArray;
                }
            }


            $data['meaning'] = $banglaMeaning->simpleBengaliMeaningOf($word);


            $exams = $this->prevExamDataOf($word);
            $data['exam'] = [];
            array_push($data['exam'], $exams);


            array_push($dataArray, $data);
        }


        return $dataArray;
    }


    public function prevExamDataOf($word){
        $jobExam = PreviousJobExams::where('word', $word)->get(['exam', 'post_name', 'year']);

        $exams = [];
        foreach ($jobExam as $object){
            $exam['exam'] = $object->exam;
            $exam['postName'] = $object->post_name;
            $exam['year'] = $object->year;

            array_push($exams, $exam);
        }

        return $exams;
    }


}