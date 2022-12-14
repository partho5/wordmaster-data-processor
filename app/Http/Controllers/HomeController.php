<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\VisitorLog;
use App\Models\Meanings;
use App\Models\Mnemonics;
use App\Models\Notes;
use App\Models\PartsOfSpeech;
use App\Models\Synonyms;
use App\Models\UserActivityLog;
use App\Models\Words;
use App\Models\WordUsages;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request){

        //retutn $ref;

        return view('home/featuredHome');
        //return 'index page';

        if( null !== $request->w){
            //url parameter
            $currentWord = $request->w;
        } else if( isset($_COOKIE['currentReadingWord']) ){
            //currentWord (cookie) exists, so existing user
            $currentWord = $_COOKIE['currentReadingWord'];
        }else{
            //new visitor, so words.id "1" will be his currentWord
            $obj = Words::where('id', '>=', 1)->limit(1)->get();
            $currentWord = $obj[0]->word;
        }

        $allWords = $this->getWordDetails($currentWord, 30);// always put even number
//return $allWords;

        return view('home/index', compact(
            'allWords'
        ));
    }


    function showDownloadPage(){
        return view('home.download');
    }



    function getWordDetails($currentWord, $numOfWordsToFetch){
        $stepBack = Words::where('word', '<', $currentWord)
            ->where('is_base_word', 1)
            ->orderBy('word', 'desc')
            ->limit(round($numOfWordsToFetch/2)-2)->get()
            ->reverse()->values();
        if(count($stepBack) > 0){
            $backWord = $stepBack[0];
            $queryStartingWord = $backWord->word;
        }else{
            $queryStartingWord = $currentWord;
        }
        //return $queryStartingWord;
        //$queryStartingWord = $currentWord;


        $words = Words::where('word', '>=', $queryStartingWord)->limit($numOfWordsToFetch)->get();
        if(count($words) > 0){
            $retVal = [];
            $wordDetails = [];
            foreach ($words as $i=>$word){
                $wordDetails['word'] = $word->word;
                $wordDetails['wordId'] = $word->id;

                $meanings = Meanings::where('word_id', $word->id)->limit(1)->get(['id', 'bangla_meaning']);
                if(count($meanings)>0){
                    $wordDetails['meanings'] = $meanings;
                }

                $partsOfSpeech = PartsOfSpeech::where('word_id', $word->id)->get(['id', 'parts_of_speech']);
                if(count($partsOfSpeech)>0){
                    $wordDetails['parts_of_speech'] = $partsOfSpeech;
                }

                $mnemonic = Mnemonics::where('word_id', $word->id)->get(['mnemonic']);
                if(count($mnemonic)>0){
                    $wordDetails['mnemonic'] = $mnemonic;
                }


                $derived = DB::table('words as w')
                    ->select('w.word', 'w.id', 'd.derived_word_id', 'd.how_related')
                    ->join('derived_words as d', 'd.word_id', '=', 'w.id')
                    ->where('w.id', '=', $word->id)->get();
                //return $derived;
                $dIds = [];
                if(count($derived)>0){
                    foreach ($derived as $row){
                        array_push($dIds, $row->derived_word_id);
                    }
                    $derived = DB::table('words as w')
                        ->select('w.word as dword', 'd.derived_word_id as dword_id', 'd.how_related')
                        ->join('derived_words as d','w.id', 'd.derived_word_id')
                        ->get();
                    if(count($derived)>0){
                        $wordDetails['derived'] = $derived;
                        return $derived;
                    }
                }


                $syns = DB::table('words as w')
                    ->select('w.word', 's.synonym_word_id')
                    ->join('synonyms as s', 'w.id', '=', 's.word_id')
                    ->where('w.id', '=', $word->id)
                    ->get();
                $synIds = [];
                foreach ($syns as $syn){
                    if( ! in_array($syn->synonym_word_id, $synIds)){
                        array_push($synIds, $syn->synonym_word_id);
                    }
                }
                $synonyms = Words::whereIn('id', $synIds)->get(['id', 'word', 'is_base_word']);
                if(count($synonyms) > 0){
                    $wordDetails['synonyms'] = $synonyms;
                }



                $notes = Notes::where('word_id', $word->id)->get();
                if(count($notes)>0){
                    $wordDetails['notes'] = $notes;
                }

                $uses = WordUsages::where('word_id', $word->id)->limit(4)->get(['id','sentence']);
                if(count($uses)>0){
                    $wordDetails['uses'] = $uses;
                }

                $next = Words::where('word', '>', $word->word)->limit(1)->get('word');
                if(count($next) > 0){
                    $wordDetails['nextWord'] = $next[0]->word;
                }

                $prev = Words::where('word', '<', $word->word)->orderBy('word', 'desc')->limit(1)->get('word');
                if(count($prev) > 0){
                    $wordDetails['prevWord'] = $prev[0]->word;
                }

                if(count($meanings)>0){
                    //if meaning doesnt exist, skip this word
                    array_push($retVal, $wordDetails);
                }
            }

            $allWords = $retVal;
            return $allWords;
        }
    }



    public function saveVisitLog(Request $request){
        //return @$request->referredBy;
        //return $request->all();

        $deviceToken = isset($request['visitorLogId']) ? $request['visitorLogId'] : null;
        $log = VisitorLog::where('device_token', $deviceToken)->orderBy('id', 'desc')->limit(1)->get();
        $retVal = [];

        $now = round(microtime(true) * 1000);
        if(count($log) == 0){
            //new user
            VisitorLog::create([
                'device_token'  => $deviceToken,
                'client'        => $request['browser'],
                'referred_by' => $request->referredBy,
                'reading_start_at'    =>  $now,
                'reading_end_at'      => $now,
                'url'   => $request->url,
                'meta'  => $request->meta
            ]);
        }
        else{
            //old visitor
            $sessionEnd = VisitorLog::where('device_token', $deviceToken)
                ->orderBy('id', 'desc')->limit(1)->get(['reading_end_at', 'url']);
            if(count($sessionEnd)>0){
                $lastEndTime = $sessionEnd[0]->reading_end_at;
                if( abs($lastEndTime - $request['current_time'])/1000 < 5  && $sessionEnd[0]->url == $request->url){
                    //no dormancy within 5 seconds, so user is active continuously
                    $retVal['msg']= "user active continuously";

                    $lastLog = VisitorLog::where('device_token', $deviceToken)
                        ->orderBy('id', 'desc')->limit(1)->get();
                    if(count($lastLog)>0){
                        $meta = $request->meta;
                        if(isset($meta) || !is_null($meta)){
                            $meta = $lastLog[0]->meta.', '.$request->meta;
                            //echo $meta;
                        }else{
                            $meta = $lastLog[0]->meta;
                            //echo "meta not set";
                        }
                        VisitorLog::where('id', $lastLog[0]->id)->update([
                            'reading_end_at'    => $request['current_time'],
                            'meta'              => $meta
                        ]);
                    }
                }else{
                    //user came again after exit
                    $retVal['msg']= "user came again after exit";
                    VisitorLog::create([
                        'device_token'  => $deviceToken,
                        'client'   => $request['browser'],
                        'referred_by' => $request->referredBy,
                        'reading_start_at'    => $now,
                        'reading_end_at'    => $now,
                        'url'   => $request->url,
                        'meta'  => $request->meta
                    ]);
                }
                $retVal['time diff'] = abs($lastEndTime - $request['current_time'])/1000;

                $lastLog = VisitorLog::where('device_token', $deviceToken)
                    ->orderBy('id', 'desc')->limit(1)->get();
                if(count($lastLog)>0){
                    $meta = $request->meta;
                    if(isset($meta) || !is_null($meta)){
                        $meta = $lastLog[0]->meta.', '.$request->meta;
                        //echo $meta;
                    }else{
                        $meta = $lastLog[0]->meta;
                        //echo "meta not set";
                    }
                    VisitorLog::where('id', $lastLog[0]->id)->update([
                        'reading_end_at'    => $request['current_time'],
                        'meta'              => $meta
                    ]);
                }
            }
        }
        return "";
        return $retVal;
    }




    public function showVisitLog(Request $request){
        $groups = VisitorLog::where('id', '>=', 1)
            ->where('device_token', '!=', '3401224208')//that is my mobile 
            ->where('device_token', '!=', '2635464682')//that is my PC
            ->orderBy('updated_at', 'desc')
            ->get(['device_token', 'client', 'referred_by', 'reading_start_at', 'reading_end_at', 'url', 'meta'])
            ->groupBy('device_token');
//return $groups;

        return view('admin/log/show_log', compact('groups'));
    }


    function showAppUserActivity(Request $request){
        $numOfUsersToShow = 10;
        $userGroups = UserActivityLog::orderBy('id', 'desc')
            ->get()
            ->groupBy('user_id')
            ->map(function($row) {
                $logPerUser = 2;
                return $row->take($logPerUser);
            })
            ->take($numOfUsersToShow);

        //return $userGroups;

        $logData = [];

        foreach ($userGroups as $userGroup){
            //dd($userGroup[0]['created_at']);
            //echo '--------uid'.$userGroup[0]['user_id'].'-----------<br>';
            foreach ($userGroup as $group){
                $log  = json_decode($group->log);
                $log = array_reverse($log);//show latest event first
                //return $log;
                $data = [];
                foreach ($log as $row){
                    //echo @$row->wIndex.'<br>';
                    $start = "";
                    if(isset($row->start)){
                        $start = @Carbon::createFromTimestampMs($row->start)->format('Y-m-d h:i:s a');
                    }else{
                        $start = "created: ".$userGroup[0]['created_at'];
                    }

                    if(@$row->activity != null || @$row->a){
                        $eachLog['activity'] = @$row->activity;
                        $eachLog['details'] = @$row->details;
                        $eachLog['start'] = $start; //$group['created_at'] ; //@Carbon::createFromTimestampMs($userGroup[0]['created_at'])->format('Y-m-d h:i:s a');
                        $eachLog['end'] = @Carbon::createFromTimestampMs($row->end)->format('Y-m-d h:i:s a');
                        $eachLog['diff'] = @round(($row->end - $row->start)/1000);
                        if(isset($row->wIndex)){
                            $eachLog['wordIndex'] = @$row->wIndex;
                        }else{
                            $eachLog['wordIndex'] = @$row->a;
                        }
                        array_push($data, $eachLog);
                    }
                }
                $uid = $userGroup[0]['user_id'];
                $logData[$uid]['logs'] = $data;

                //echo '<br><br><br>';
            }
            //echo '<hr>';
        }

        //return $logData;

        return view('admin/log/app_user_activity', compact(
            'logData'
        ));
    }

    function osVersion($apiLevel){
        $osV['21']='Lollipop 5.0'; $osV['22']='Lollipop 5.1'; $osV['23']='Marshmallow'; $osV['24']='Nougat 7.0'; $osV['25']='Nougat 7.1+'; $osV['26']='Oreo 8.0'; $osV['27']='Oreo 8.1';$osV['28']='Pie 9.0'; $osV['29']='Android 10'; $osV['30']='Android 11';
        return $osV[$apiLevel];
    }


    public function showPrivacyPolicy(){
        return view('home.privacy_policy');
    }


    function showAppActivity(){
        $activityData = UserActivityLog::all()->groupBy('device_id');

        foreach ($activityData as $data){
          $json = json_decode($data, true);
          foreach ($json as $single){
              //print_r($single);
              $log = json_decode($single['log'], true);

              foreach ($log as $activity){
                  $start = $this->milisToDateTime( $activity['start'] );
                  $end = $this->milisToTime( $activity['end'] );
                  $diff = $activity['end'] - $activity['start'];
                  echo $start.' - '.$end.' ('.round($diff/1000).' sec )'.' '.$activity['activity'].' '.$activity['wordIndex'].'<br>';
              }
              echo '<hr>';
          }
          //break;//show only first group
        }

        //return $activityData;
    }

    function milisToDateTime($mil){
        $seconds = $mil / 1000;
        return date("d/m/Y h:i:s", $seconds);
    }

    function milisToTime($mil){
        $seconds = $mil / 1000;
        return date("h:i:s A", $seconds);
    }












}
