<?php

namespace App\Http\Controllers;

use App\Models\Meanings;
use App\Models\Mnemonics;
use App\Models\Notes;
use App\Models\PartsOfSpeech;
use App\Models\UserActivityLog;
use App\Models\UserPayment;
use App\Models\WordCategories;
use App\Models\Words;
use App\Models\WordUsages;
use App\Models\Synonyms;
use App\Models\Antonyms;
use App\Models\DerivedWords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Mockery\Exception;
use App\Models\User;
use Carbon\Carbon;

class ApiController extends Controller
{
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



    function prepareWordsForAndroid(){
        if(! Auth::id()){
            abort(403);
        }
        ini_set("max_execution_time", 30000);
        $wordsPerFile = 100;
        $wordsPerFile = 500;
        $startIndex = 1;

        $fetchableWordsCount = count($this->wordsToFetch($startIndex, "8000"));//8000 is just an assumed max value, we won't extract more words than this number.
        $numOfFiles = ceil( $fetchableWordsCount/$wordsPerFile );

        $start = round(microtime(true)*1000);

        for($fileNo=1; $fileNo <= $numOfFiles; $fileNo++){
            $wordData = [];
            $words = $this->wordsToFetch($startIndex, $wordsPerFile);
            //return $words;

            foreach ($words as $word){
                array_push($wordData, $this->extractEverythingOfWord($word));
            }
            //return ($wordData);

            Storage::disk('public')->put('word_data_for_android/'.$fileNo.'.txt', json_encode($wordData));

            //if $words collection has last display_index n, then next start with n+1
            $ws = sizeof($words)-1;
            $ws = $ws<0? 0 : $ws;
            $startIndex = $words[$ws]['display_index'] + 1;
        }

        $end = round(microtime(true)*1000);

        return 'Time taken : '.(($end-$start)/1000).' seconds';
    }



    function saveAppLog(Request $request){
        //return $request->log;
        $log = $request->log;
        $userId = $request->userId;
        $meta = $request->meta;
        $versionCode = $request->versionCode;
        $meta = $meta.",vCode=".$versionCode;
        //$logJson = json_decode($log, true);
        //return $logJson;
        UserActivityLog::create([
        	'user_id'		=> $userId,
            'log'   		=> $log,
            'meta'  		=> $meta,
        ]);


        $data = [
            'userId' => $userId
        ];

        return response()->json($data);
    }


    function registerDevice(Request $request){
        //return $request->all();
    	$deviceId = $request->deviceId;
        $deviceOS = $request->os;
        $osVersion = $request->osV;
        $deviceName = $request->deviceName;
        $ip = $_SERVER['REMOTE_ADDR'];
        
    	$user = User::where('device_id', $deviceId)->get();
    	if( count($user) > 0 ){
    	    //user id for this device id exists
    	    $userId = $user[0]->id;

    	    //concatenate IP with meta column
    	    User::where('id', $userId)
                ->where('meta', 'not like', '%ip=%.%.%.%') //if meta already contains ip, don't concatenate
                ->update([
                'meta'  => $user[0]->meta." ip=".$ip."," //whenever concatenate a data to meta field; add a comma(,) at the end so that the newly added data in future get a comma(,) at it's beginning
            ]);
    	}else{
    	    //user id for this device NOT exist. so create user. remember about $fillable before inserting method
    	    $user = new User();
    	    $user->device_id = $deviceId;
            $user->device_os = $deviceOS;
            $user->os_version = $osVersion;
            $user->device_name = $deviceName;
            $user->meta = "ip=".$ip;
    	    $user->created_at = Carbon::now();
    	    $user->save();

    	    $userId = $user->id;
    	}


        $paymentVerified = 0;
        try{
            $payment = UserPayment::where('user_id', $userId)
                ->whereNotNull('verified_at')
                ->get();
            if(count($payment) > 0){
                //payment verified for this userId. That means this user has reinstalled the app
                $paymentVerified = 1;
            }
        }catch (\Exception $e){}

    	
    	$data = [
    	    'userId' => $userId,
            //'ip'     => $ip,
            'paymentVerified'   => $paymentVerified
    	];

    	return response()->json($data);
    }

}
