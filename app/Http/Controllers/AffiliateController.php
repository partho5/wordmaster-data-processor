<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\Affiliate\AdminAffiliate;
use App\Http\Controllers\Contents\VariousData;
use App\Models\AffiliatePosts;
use App\Models\User;
use App\Models\VisitorLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AffiliateController extends Controller
{
    /* Affiliates are partners. The word 'affiliate' and 'affiliate' has been used interchangeably */

    function __construct(){
        $this->middleware('auth')->except(['showAffiliateLandingPage', 'showTermsOfService']);
    }

    public function showAffiliateLandingPage(Request $request){
        return view('affiliate/landing-page');
    }

    public function showSubmitNewPost(){

        $userId = Auth::id();
        //$userId=0; //test
        $row = AffiliatePosts::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->select('post_link')
            ->get()
            ->first();
        $postLink = null;
        if(!is_null($row)){
            $postLink = $row['post_link'];
        }


        $adminEmail = config('values.adminEmail');

        return view('affiliate/index', compact('postLink', 'adminEmail'));
    }



    public function showAffiliateDashboard(){
        $userId = Auth::id();

        $adminAffiliate = new AdminAffiliate();
        $affiliateCode = $adminAffiliate->queryAffiliateToken($userId);

        $affiliateCode = "adoct3";

        if(is_null($affiliateCode)){
            $affiliateCode = $adminAffiliate->generateAffiliateToken($userId);
            $success = $adminAffiliate->saveAffiliateToken($userId, $affiliateCode);
            if(! $success){
                return "Error occurred. Please <a href='" . url()->current() . "'>Reload page</a>";
            }
        }


        if(! is_null($affiliateCode)){
            $logs = VisitorLog::where('referred_by', $affiliateCode)
                ->where('url', 'LIKE', '%play.google.com%')
                //->select('device_token', 'client', 'id', 'url')
                ->orderBy('id', 'desc')
                ->limit(500)
                ->get();

            $logs = $logs->unique('device_token')->values();
            if(count($logs) > 0){
                foreach ($logs as $i=>$log){
                    $userAgent = $log->client;
                    $clientInfo =  $this->extractFromUserAgent($userAgent);
                    //return $clientInfo;
                    $androidVersionCode = @$clientInfo['version'];
                    $buildName = @$clientInfo['build'];
                    $ip = @$clientInfo['ip'];

                    //echo "$androidVersion $buildName $ip <br>";

                    $variousData = new VariousData();
                    $apiLevel = $variousData->androidVersionToApiLevel($androidVersionCode);


                    //fetch from users by     ip,build,api level,log created_at time smaller than users created_at time and time diff 24 hours iff 1+ rows found

                    $users = User::where('device_name', 'LIKE', '%'.$buildName.'%')
                        ->where('os_version', 'LIKE', '%'.$apiLevel.'%')
                        ->where('meta', 'LIKE', '%ip='.$ip.'%')
                        ->where('created_at', '>', $log->created_at) //device registration must have taken place later than app download
                        ->get();

                    echo "[$i]";
                    if(count($users) == 0){
                        echo "<p style='color: #c93a00'>$buildName and $androidVersionCode -> $apiLevel ip=$ip | visit : $log->created_at not found in users table.</p>";
                    }else{
                        if(count($users) >= 1){
                            foreach ($users as $user){
                                $userIp = $user->meta;
                                echo $user->id." : downloaded at ".$log->created_at.", device_token=".($log->device_token). " | logIp=$ip vs userIp=$userIp | $buildName and $androidVersionCode -> $apiLevel . device registered at ".($user->created_at)." <br> ";
                            }
                            echo "<br><hr><br>";
                        }
                        //echo "<p style='color: #00aa11'>".count($users)." users having same device+ip+api Level. users.id=".($users[0]->id)." </p> <br>";
                    }
                }
            }



            //return;
            //return $logs;
        }




        $adminAffiliate = new AdminAffiliate();
        $adminAffiliate->affiliateLinkOf($userId);


        return view('affiliate/dashboard');
    }


    public function savePostLink(Request $request){
        $userId = Auth::id();
        $postLink = $request->postLink;
        if(!is_null($postLink)){
            $row = AffiliatePosts::firstOrNew([
                'user_id'   => $userId,
                'post_link' => $postLink
            ]);
            $result = $row->save();
            echo $result;
        }else{
            echo 'post link null';
        }
    }



    public function showMyAffiliateLink(){
        $userId = Auth::id();
        $affiliateLinkJob = (new AdminAffiliate)->affiliateLinkOf($userId);
        $affiliateLinkAdmission = $affiliateLinkJob . '&target=admission';

        return view('affiliate/my-affiliate-link', compact('affiliateLinkJob', 'affiliateLinkAdmission'));
    }



    public function showTermsOfService(){
        return view('affiliate.terms_of_service');
    }

    /* not implemented yet */
    public function extractFromUserAgent($userAgent){
        /*
         * Testing purpose
         * */
        //$userAgent = 'Mozilla/5.0 (Linux; Android 12; CPH2269 Build/SP1A.210812.016; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/103.0.5060.129 Mobile Safari/537.36 [FB_IAB/FB4A;FBAV/393.0.0.35.106;';
        //$userAgent = "Mozilla/5.0 (Linux; Android 8.1.0; TECNO B1p) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.110 Mobile Safari/537.36  -screenSize=";



        /*
         * extracts only android version number
         * */
        //$patternAndroidVersion = '/Android\s([0-9]+);/';


        /*
         * First sub group ([0-9]+) gives android version number , and second sub group gives builb name , third subgroup gives IP.
         *   [^-]*  says "not hyphen", it is important because ip starts with '-'
         * */

        $patternBuild = '/Android\s?(\d+(?:\.\d+)*);\s?(.*?)\s?(?:Build|\))(?:.*-ip=([\d.]+))?/';






        //-----------------------
        /*
        $filePath = storage_path()."/app/visitor_log_user_agents.json";
        $dataArray = json_decode(file_get_contents($filePath), true);
        foreach ($dataArray as $client){
            $userAgent = $client['client'];

            if (preg_match($patternBuild, $userAgent, $matches)) {
                //dd($matches);
                $androidVersionNumber = $matches[1];
                $build = $matches[2];
                echo "<p>vCode=<b>$androidVersionNumber</b> buildName=<b>$build</b> <span style='color: #00970e'>$userAgent</span> </p>";
            } else {
                echo "No match found for <span style='color:red'>$userAgent</span>";
            }
        }
        */
        //-----------------------



        if (preg_match($patternBuild, $userAgent, $matches)) {
            //dd($matches);

            $clientInfo = [];

            if(isset($matches[1])){
                $clientInfo['version'] = $matches[1];
            }
            if(isset($matches[2])){
                $clientInfo['build'] = $matches[2];
            }
            if(isset($matches[3])){
                $clientInfo['ip'] = $matches[3];
            }


            return $clientInfo;
        }
        return null;
    }




}


class UserIdEncodeDecode{
    /* We didn't use abcdef... rather used random letters to look it pretty random string. don't use any vowel here. That can randomly produce unpleasant words. */
    private $numberToAlphabetCode = [
        0=>'k',
        1=>'j',
        2=>'z',
        3=>'p',
        4=>'d',
        5=>'t',
        6=>'f',
        7=>'v',
        8=>'h',
        9=>'m',
    ];

    public function encodeNumberToString($number){
        $arr = str_split($number);
        $string = "";
        foreach ($arr as $element){
            $string = $string.$this->numberToAlphabetCode[$element];
        }
        return $string;
    }

    public function decodeStringToNumber($string){
        $arr = str_split($string);
        $number = "";
        foreach ($arr as $element){
            $position = array_search($element, $this->numberToAlphabetCode);
            if($position === false){
                return null;
            }
            $number = $number.$position;
        }
        return $number;
    }
}
