<?php

namespace App\Http\Controllers;

use App\Models\AffiliatePosts;
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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class HomeController extends Controller
{
    private $adminDevices = ["1761444613 ", "746347999", "3873590173", "1391769358", "145110509", "703968647", "2633596126", "3611826085", "2746203542", "2013181607", "1943572267", "2657667095", "2729225889", "786356722", "2308038079", "2015841309", "2034330327"];

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

        $target = $request->target;
        $viewFileToDisplay = 'home/featuredHome';


        $appDistributionThrough = 'playstore';
        //$appDistributionThrough = 'apk';



        if(isset($target)){
            if($target === 'admission'){
                $viewFileToDisplay = 'home/featuredHome_admission';
            }
        }

        return view($viewFileToDisplay, compact('appDistributionThrough', 'target'));

/*
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
*/
    }


    function showDownloadPage(){
        return view('home.download');
    }

    function showPdfDownload(Request $request){
        $type = $request->type;
        if(!isset($type)){
            return view('pdf_generator.show_download_pdf');
        }
        else{ /* same page. just url has 'type' paramater such as '?type=1' */
            if($type == 1){ /* 330 high frequency words pdf */
                $filePath = Storage::path("/public/330-high-frequency-words.pdf");
                $response = response()->file($filePath);
                //return $response;
                $downloadName = "330-high-frequency-words.pdf";
                // Create a ResponseHeaderBag object to set the headers
                $headers = new ResponseHeaderBag();
                $headers->set('Content-Type', 'application/pdf');
                $headers->set('Content-Disposition', "attachment; filename=$downloadName");

                // Set the headers on the BinaryFileResponse object
                $response->headers = $headers;

                //add visitor log



                return $response;
            }
        }
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
        $logInterval = 6; //second. if duration between two or more save request is less than this value, those requests will be counted saved in single row, no another new row will be created

        $now = round(microtime(true) * 1000);
        $clientInfo = $request['browser']." -ip=".$_SERVER['REMOTE_ADDR'].' -screenSize='.$request['screenSize'];
        if(count($log) == 0){
            //new user
            VisitorLog::create([
                'device_token'  => $deviceToken,
                'client'        => $clientInfo,
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
            if(count($sessionEnd) > 0){
                $lastEndTime = $sessionEnd[0]->reading_end_at;
                if( abs($lastEndTime - $request['current_time'])/1000 < $logInterval  && $sessionEnd[0]->url == $request->url){
                    //no dormancy within $logInterval seconds, so user is active continuously
                    $retVal['msg']= "user active continuously";

                    $lastLog = VisitorLog::where('device_token', $deviceToken)
                        ->orderBy('id', 'desc')->limit(1)->get();

                    if(count($lastLog)>0){
                        $meta = $lastLog[0]->meta;
                        if(! str_contains($meta, $request->meta)){
                            $meta = $meta.', '.$request->meta; //if newly arrived meta data is null just comma (,) will be being concatenated repeatedly. And if again new metadata has value it will be added. So metadata like "some data ,,,,, another data" means there was no activity for a while
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
                        'client'        => $clientInfo,
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
        return "logged";
    }




    public function showVisitLog(Request $request){
        $groups = VisitorLog::where('id', '>=', 1)
            ->whereNotIn('device_token', $this->adminDevices)
            ->orderBy('updated_at', 'desc')
            ->get(['device_token', 'client', 'referred_by', 'reading_start_at', 'reading_end_at', 'url', 'meta'])
            ->groupBy('device_token')
            ->take(20);
//return $groups;

        return view('admin/log/show_log', compact('groups'));
    }


    function showAppUserActivity(Request $request){
        return $this->getUserActivityLogs();

        $numOfUsersToShow = 10;
        $userGroups = UserActivityLog::orderBy('id', 'desc')
            ->get()
            ->groupBy('user_id')
            ->map(function($row) {
                $logPerUser = 10;
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


    public function getUserActivityLogs()
    {
        // Android OS versions mapping
        $osVersions = [
            '21' => 'Lollipop 5.0',
            '22' => 'Lollipop 5.1',
            '23' => 'Marshmallow',
            '24' => 'Nougat 7.0',
            '25' => 'Nougat 7.1+',
            '26' => 'Oreo 8.0',
            '27' => 'Oreo 8.1',
            '28' => 'Pie 9.0',
            '29' => 'Android 10',
            '30' => 'Android 11',
            '31' => 'Android 12',
            '32' => 'Android 12 L',
            '33' => 'Android 13',
            '34' => 'Android 13 L',
            '35' => 'Android 14',
            '36' => 'Android 14 L',
            '37' => 'Android 15',
            '38' => 'Android 15 L',
            '39' => 'Android 16',
        ];

        // Add pagination and limits at the query level
        $userGroups = DB::table('user_activity_logs')
            ->join('users', 'user_activity_logs.user_id', '=', 'users.id')
            ->select('user_activity_logs.*', 'users.device_name', 'users.os_version')
            ->orderBy('user_activity_logs.created_at', 'desc')
            ->limit(500) // Limit to first 20 users
            ->get()
            ->groupBy('user_id');

        $processedData = [];

        foreach ($userGroups as $userId => $userLogs) {
            $userInfo = [
                'user_id' => $userId,
                'device_name' => $userLogs->first()->device_name ?? 'Unknown',
                'os_version' => $osVersions[$userLogs->first()->os_version] ?? 'Unknown OS',
                'logs' => []
            ];

            foreach ($userLogs as $logEntry) {
                $logData = json_decode($logEntry->log, true);

                if (!$logData) continue;

                // Reverse to show latest first
                $logData = array_reverse($logData);

                foreach ($logData as $index => $activity) {
                    // Limit to 50 rows per user
                    if ($index >= 50) {
                        break;
                    }

                    // Skip empty activities
                    if (empty($activity['activity']) && empty($activity['a'])) {
                        continue;
                    }

                    $startTime = '';
                    if (!empty($activity['start'])) {
                        try {
                            $startTime = Carbon::createFromTimestampMs($activity['start'])->format('Y-m-d h:i:s A');
                        } catch (Exception $e) {
                            $startTime = 'Invalid timestamp';
                        }
                    } else {
                        $startTime = "Created: " . $logEntry->created_at;
                    }

                    $endTime = '';
                    $duration = 0;
                    if (!empty($activity['end'])) {
                        try {
                            $endTime = Carbon::createFromTimestampMs($activity['end'])->format('Y-m-d h:i:s A');
                            $duration = round(($activity['end'] - ($activity['start'] ?? 0)) / 1000);
                        } catch (Exception $e) {
                            $endTime = 'Invalid timestamp';
                        }
                    }

                    $userInfo['logs'][] = [
                        'activity' => $activity['activity'] ?? $activity['a'] ?? 'Unknown',
                        'details' => $activity['details'] ?? '',
                        'start_time' => $startTime,
                        'end_time' => $endTime,
                        'duration' => $duration . ' sec',
                        'word_index' => $activity['wIndex'] ?? $activity['a'] ?? 'N/A',
                        'raw_start' => $activity['start'] ?? 0,
                        'raw_end' => $activity['end'] ?? 0
                    ];
                }
            }

            $processedData[] = $userInfo;
        }

        return view('admin/log/app_user_activity', compact('processedData'));
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





    public function sendMail($data){
        $result = Mail::send($data['template'], ['data' => $data], function ($mail) use ($data) {
            $mail->from($data['from'], $data['senderName']);
            $mail->replyTo($data['replyTo']);
            $mail->to($data['to']);
            $mail->subject($data['subject']);
        });

        dd($result);
    }

    public function testSendMail(Request $request){
        $mailTo = 'partho8181@gmail.com';
        $data = [
            'from'      => env('MAIL_FROM_ADDRESS'),
            'to'        => $mailTo,
            'replyTo'   => env('MAIL_FROM_ADDRESS'),
            'subject'   => 'Payment Successful',
            'msg'       => 'Subject: Payment Success
                            Dear Jany,
                            Your payment to Nany Article was successful. Here is your invoice.',
            'name'      => 'Nany Article',
            'senderName'    => 'Nany Article',
            'senderEmail'   => env('MAIL_FROM_ADDRESS'),

            'template'  => 'mailPages.test',
        ];

        $result = $this->sendMail($data);
        return $result;
    }





}
