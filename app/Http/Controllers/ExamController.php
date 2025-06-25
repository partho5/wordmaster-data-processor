<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Processor\StringProcessor;
use App\Models\Antonyms;
use App\Models\Meanings;
use App\Models\SelfTestQuestions;
use App\Models\SelfTests;
use App\Models\Synonyms;
use App\Models\SelfTestAnswers;
use App\Models\User;
use App\Models\Words;
use App\Models\WordUsages;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ExamController extends Controller
{

    function index(Request $request){

        if($request->has('deviceId') && $request->has('maxdi') ){
            $deviceId = $request->deviceId;
            $u = User::where('device_id', $deviceId)->get(['id']);
            if(count($u)>0){
                return view('exam/index');
            }
        }
        return "<div style='text-align: center; font-size: 1.3em'> Invalid Link. <p> Please click <b>MCQ Test</b> option from Joy Vocabulary app menu</p> </div>";
    }


    function fetchQuestion(Request $request){
        $engOnly = $request->input('englishOnly'); // show only English content, if set it will look like englishOnly=1, or won't be set at all
        $stringProcessor = new StringProcessor();

        $mainWords = Words::where('importance_level', '>=', MyConstants::$minImportanceLevelForMainWords)
            ->whereNotNull('display_index')
            //->where('display_index', '>=', $request->mindi)
            ->where('display_index', '<=', $request->maxdi)
            ->orderBy('display_index', 'asc')
            ->get(['word']);
        $questions = SelfTestQuestions::whereIn('word', $mainWords)
            ->get()->groupBy('word');
        $questionSets = [];

        foreach ($questions as $question){
            $randIndex = rand(0, sizeof($question)-1);
            if($engOnly){
                if(! $stringProcessor->containsBanglaChar($question[$randIndex]['question'])){
                    array_push($questionSets, $question[$randIndex]);
                }
            }else{
                array_push($questionSets, $question[$randIndex]);
            }
        }

        shuffle($questionSets);
        $questionSets = array_slice($questionSets, 0, $request->numOfQ);

        $deviceId = $request->deviceId;
        $u = User::where('device_id', $deviceId)->get(['id']);
        if(count($u)>0) {
            $userId = $u[0]->id;

            $test = SelfTests::create([
                'user_id'   => $userId,
                'start_at'  => Carbon::now(),
                'maxdi'     => $request->maxdi,
                'mindi'     => @$request->mindi, //might be null
                'type'      => 'mini',
            ]);
            $response['questionSets'] = $questionSets;
            $response['examId'] = $test->id;
            return $response;
        }
    }


    function submitAnswer(Request $request){
        $answers = $request->answerSheet;
        $data = [];
        $testId = $request->examId;

        SelfTests::where('id', $testId)->update(['end_at'=>Carbon::now()]);

        foreach ($answers as $answer){
            array_push($data, [
                'self_test_id'   => $testId,
                'self_test_question_id' => $answer['qId'],
                'answered_option'   => $answer['answeredOption'],
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ]);
        }
        SelfTestAnswers::insert($data);
        return 1;
    }

    function showResult(){
        return view('exam/show_result');
    }


    function showSingleResult(Request $request){
        $testId = $request->testId;
        $qIds = [];
        $coll = SelfTestAnswers::where('self_test_id', $testId)->get(['self_test_question_id']);
        foreach ($coll as $obj){
            array_push($qIds, $obj->self_test_question_id);
        }

        $qa = DB::table('self_test_questions as q')
            ->select('q.id','q.question','q.option1','q.option2','q.option3','q.option4','q.correct_option','q.created_at', 'a.answered_option')
            ->join('self_test_answers as a', 'q.id', '=', 'a.self_test_question_id')
            ->whereIn('q.id', $qIds)
            ->get();
        $qa = $qa->unique('id');

        //return $qa;

        return view('exam/single_result', compact(
            'qa'
        ));
    }


    function fetchResult(Request $request){
        $prevTestId = $request->prevTestId;
        //$prevTestId = isset($prevTestId)? $prevTestId : '99999999999999999999999';//99....just a big value. No time value can be greater than this


        $deviceId = $_COOKIE['deviceId'];
        $u = User::where('device_id', $deviceId)->get(['id']);
        if(count($u)>0){
            $userId = $u[0]->id;

            if(!isset($prevTestId)){
                $resultColl = SelfTests::where('user_id', $userId)
                    ->whereNotNull('end_at')
                    ->orderBy('id', 'desc')
                    ->get(['id'])
                    ->groupBy('id');

                $testIds = [];
                foreach ($resultColl as $key=>$obj){
                    array_push($testIds, $key);
                }
                return compact('testIds');
            }else{
                $resultColl = SelfTests::where('id', '=', $prevTestId)
                    //->orderBy('id', 'desc')
                    ->get()
                    ->groupBy('id');//->take(1);
            }
            //return $resultColl;


            $testId = ''; $examStart = ''; $examEnd = ''; $type = '';
            $answers = []; $qIds = [];
            foreach ($resultColl as $key=>$obj){
                $testId = @$obj[0]->id;
                $examStart = @$obj[0]->start_at;
                $examEnd = @$obj[0]->end_at;
                $type = @$obj[0]->type;
                //break;//take only one
            }

            $qa = DB::table('self_test_questions as q')
                ->select('q.id','q.question','q.option1','q.option2','q.option3','q.option4','q.correct_option', 'a.answered_option')
                ->join('self_test_answers as a', 'q.id', '=', 'a.self_test_question_id')
                ->where('a.self_test_id', $testId)
                ->get();
            $qa = $qa->unique('id');

            //return $prevTestId;

            return compact('qa', 'testId', 'examStart', 'examEnd', 'type');
        }
    }



    function insertQuestions(){
        ini_set("max_execution_time", 30000);
        set_time_limit(30000);

        $mainWords = Words::where('importance_level', '>=', MyConstants::$minImportanceLevelForMainWords)
            ->whereNotNull('display_index')
            ->orderBy('display_index', 'asc')
            ->limit(100)
            ->get(['word', 'id']);

        foreach ($mainWords as $word){
            $path = storage_path().'/app/public/qLog.json';
            $log = json_decode( file_get_contents($path) );
            $lastWord = $log->last_word;

            if($word->word > $lastWord){
                $questions = $this->generateQuestions($word['id']);

                if(is_null($questions)){
                    //for some reason null is returned. so skip this word.
                    break;
                }
                
                $qSets = [];
                foreach ($questions as $question){
                    json_encode($question['options']);
                    array_push($qSets, [
                        'word'      => $word->word,
                        'question'  => $question['q'],
                        'option1'   => @$question['options'][0],
                        'option2'   => @$question['options'][1],
                        'option3'   => @$question['options'][2],
                        'option4'   => @$question['options'][3],
                        'correct_option'    => $question['correctOption'],
                        'meta'  => null,
                        'created_at'    => Carbon::now(),
                        'updated_at'    => Carbon::now()
                    ]);
                }
                //return $qSets;
                SelfTestQuestions::insert($qSets);

                Storage::disk('public')->put('qLog.json', json_encode(['last_word' => $word->word]));
                //return $word['word'].' inserted<br>';
            }
        }
        //return $mainWords;
        return 'finished';
    }


    function generateQuestions($id){
        if(true){
            $questionSets = [];
            //$id = rand(1000, 3003);
            //$id=2626;
            $w = Words::where('id', '=', $id)->get();

            if(count($w)>0){
                $word = $w[0]->word;
                $wordId = $w[0]->id;

                //$questionSets['word'] = $word;

                $wordData = $this->wordDataForMakingQuestion($word);

                $englishContentOnly = true;
                $stringProcessor = new StringProcessor();

                try{
                    $meaning = $wordData['meanings'][0];
                    if($englishContentOnly){
                        if(! $stringProcessor->containsBanglaChar($meaning)){
                            $arr = explode("*", $meaning);
                            $meaning = trim($arr[1]);

                            //remove serial no. like: 1. , 2. etc
                            $b = explode(".", $meaning);
                            try{
                                $meaning = $b[1];
                                $meaning = trim($meaning);
                            }catch (\Exception $e){}


                            $spaceCount = substr_count($meaning, ' ');
                            $q = '';
                            if($spaceCount == 0){
                                $rand = rand(1,3);
                                if($rand==1){
                                    $q = "Which one is equivalent to ‘"."$meaning"."’ ?";
                                }elseif (($rand==2)){
                                    $q = "Which word has the similar meaning as ‘"."$meaning"."’ ?";
                                }elseif($rand==3){
                                    $q = "English word for ‘"."$meaning"."’ is-";
                                }

                                $options = $this->generateOptionsWithoutSynonym($wordId, $word);
                                array_push($questionSets, ['q' => $q, 'options' => $options, 'correctOption'=>$word] );
                            }


                            if($spaceCount == 1 || strpos($meaning, '/') == true || strpos($meaning, '(') == true){
                                $q = "‘".$meaning."’ - equivalent english word is :";

                                $options = $this->generateOptionsWithoutSynonym($wordId, $word);
                                array_push($questionSets, ['q' => $q, 'options' => $options, 'correctOption'=>$word] );
                            }
                            if($spaceCount >=2 || strpos($meaning, '/') == true || strpos($meaning, '(') == true){
                                $q = "Which word does express the sense ‘".$meaning."’ ?";

                                $options = $this->generateOptionsWithoutSynonym($wordId, $word);
                                array_push($questionSets, ['q' => $q, 'options' => $options, 'correctOption'=>$word] );
                            }



                            $def1 = $wordData['meanings'][2];
                            if($def1 != '#'){
                                //it's not blank

                                //keep only one definition if multiple available
                                try{
                                    preg_match("/<\/span>.*(<span)?.*/", $def1, $matches);
                                    $def1 = preg_replace("/<\/span>/", "", $matches[0]);
                                }catch (\Exception $e){}

                                //return $def1;

                                if(strpos($def1, $word) == false){
                                    //definition doesn't contain the word itself
                                    $q = '"'.trim($def1)."\" - this definition corresponds with :";

                                    $options = $this->generateOptionsWithoutSynonym($wordId, $word);
                                    array_push($questionSets, ['q' => $q, 'options' => $options, 'correctOption'=>$word] );
                                }
                            }

//                        $wordData['question'] = $q;
//                        $options = $this->generateOptionsWithoutSynonym($wordId, $word);
//                        $wordData['options'] = $options;
//                        $wordData['correctOption'] = $word;

                            $synonyms = $wordData['synonyms'];
                            //return $synonyms;
                            foreach ($synonyms as $synonym){
                                $syno = $synonym['word'];
                                $rand = rand(1,4);
                                if($rand==1){
                                    $q = "Which one is a synonym of $word ?";
                                    $options = $this->generateOptionsWithoutSynonym($wordId, $syno);
                                    array_push($questionSets, ['q' => $q, 'options' => $options, 'correctOption'=>$syno] );
                                } elseif($rand==2){
                                    $q = "Which word is closely related to '$word' ?";
                                    $options = $this->generateOptionsWithoutSynonym($wordId, $syno);
                                    array_push($questionSets, ['q' => $q, 'options' => $options, 'correctOption'=>$syno] );
                                } elseif($rand==3){
                                    $q = "Which word is synonymous with $word ?";
                                    $options = $this->generateOptionsWithoutSynonym($wordId, $syno);
                                    array_push($questionSets, ['q' => $q, 'options' => $options, 'correctOption'=>$syno] );
                                } elseif($rand==4){
                                    $q = "Find the best match for '$word' ?";
                                    $options = $this->generateOptionsWithoutSynonym($wordId, $syno);
                                    array_push($questionSets, ['q' => $q, 'options' => $options, 'correctOption'=>$syno] );
                                }
                            }


                            return $questionSets;
                        }
                    }

                    return null;


                    //return $wordData;
                }catch (\Exception $e){
                    //dd($e);
                }
            }

        }
    }//generateQuestions()

    function generateOptionsWithoutSynonym($wordId, $word){
        //options won't contain any synonym. But $word itself will be an option
        $upLimit = $wordId<100 ? 100 : $wordId;
        $nonSynos = Synonyms::where('word_id', '!=', $wordId)
            ->where('word_id', '<', $upLimit) //though should be based on display_index. but still it works.
            ->get(['word_id'])->random(10);
        $nonSynoColl = Words::whereIn('id', $nonSynos)->get();
        //return $nonSynoColl;
        if(count($nonSynoColl) < 4){
            $this->generateOptionsWithoutSynonym($wordId, $word);
        }

        $rand = rand(0,3);
        $options = [];
        foreach ($nonSynoColl as $i=>$item){
            if($i == $rand){
                array_push($options, $word);
            }else{
                array_push($options, $item->word);
            }

            if(count($options) == 4){
                break;
            }
        }

        if(count($options) < 4){
            $this->generateOptionsWithoutSynonym($wordId, $word);
        }

        return $options;
    }


    function wordDataForMakingQuestion($word){
        $w = Words::where('word', $word)->get(['id', 'display_index']);
        $wordDetails = [];
        if(count($w)){
            $wordId = $w[0]->id;
            $wordDetails['word'] = $word;
            $wordDetails['id'] = $wordId;

            /* this fetches both Bangla meaning and English definition */
            $meaningsCollection = Meanings::where('word_id', $wordId)
                ->limit(4)
                ->get(['bangla_meaning']);

            $allMeanings = [];
            foreach ($meaningsCollection as $row){
                $meaning = $row->bangla_meaning;
                array_push($allMeanings, $meaning);
            }
            $wordDetails['meanings'] = $allMeanings;

            $senCollection = WordUsages::where('word_id', $wordId)
                ->where('sentence', 'NOT LIKE', '>%')
                ->limit(2)->get();
            $sentences = [];
            foreach ($senCollection as $s){
                array_push($sentences, $s->sentence);
            }
            $wordDetails['sentences'] = $sentences;

            $di = $w[0]->display_index;
            $wordDetails['display_index'] = $di;

            $allSynonyms = Synonyms::where('word_id', $wordId)->get();
            //return $allSynonyms;
            $synonyms = []; $synoTaken = [];
            foreach ($allSynonyms as $row){
                $synId = $row->synonym_word_id;
                $w = Words::where('id', $synId)
                    ->where('display_index', '<', $di)
                    ->get(['word', 'display_index']);
                if(count($w)>0){
                    if($w[0]->display_index < $di && !in_array($w[0]->word, $synoTaken) ){
                        array_push($synonyms, [
                            'word'  => $w[0]->word,
                            'display_index' => $w[0]->display_index
                        ]);
                        array_push($synoTaken, $w[0]->word);
                    }
                }
            }
            $wordDetails['synonyms'] = $synonyms;

            $allAntonyms = Antonyms::where('word_id', $wordId)->get();
            $antonyms = [];
            foreach ($allAntonyms as $row){
                $antoId = $row->antonym_word_id;
                $w = Words::where('id', $antoId)
                    //->where('display_index', '<', $di)
                    ->get(['word', 'display_index']);
                if(count($w)>0){
                    array_push($antonyms, [
                        'word'  => $w[0]->word,
                        'display_index' => $w[0]->display_index
                    ]);
                }
            }
            $wordDetails['antonyms'] = $antonyms;
        }

        return $wordDetails;
    }
}
