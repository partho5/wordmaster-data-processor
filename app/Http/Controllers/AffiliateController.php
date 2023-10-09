<?php

namespace App\Http\Controllers;

use App\Models\AffiliatePosts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AffiliateController extends Controller
{
    /* Affiliates are partners. The word 'affiliate' and 'affiliate' has been used interchangeably */

    function __construct(){
        $this->middleware('auth')->except(['showAffiliateLandingPage', 'showTermsOfService']);
    }

    public function showAffiliateLandingPage(Request $request){
        return view('affiliate/landing-page');
    }

    public function showAffiliateHome(Request $request){

        $affiliateId = 423;
        $enc = (new UserIdEncodeDecode())->encodeNumberToString($affiliateId);
        $dec = (new UserIdEncodeDecode())->decodeStringToNumber($enc);
        //echo $affiliateId.' > '.$enc.' < '.$dec."<br>";
        if(is_null($dec)){
            echo "invalid arg for decodeStringToNumber()";
        }

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



    public function showTermsOfService(){
        return view('affiliate.terms_of_service');
    }

    /* not implemented yet */
    public function extractFromClient(){
        $userAgent = 'Mozilla/5.0 (Linux; Android 12; CPH2269 Build/SP1A.210812.016; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/103.0.5060.129 Mobile Safari/537.36 [FB_IAB/FB4A;FBAV/393.0.0.35.106;';

        //$userAgent = "Mozilla/5.0 (Linux; Android 8.1.0; TECNO B1p) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.110 Mobile Safari/537.36 -ip=197.239.13.114 -screenSize=";

        //$patternAndroidVersion = '/Android\s([0-9]+);/'; //extracts only android version number
        $patternBuild = '/Android\s?(\d+(?:\.\d+)*);\s?(.*?)\s?(?:Build|\))/'; //first sub group ([0-9]+) gives android version number and second sub group gives builb name



        //-----------------------
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
        //-----------------------


        if (preg_match($patternBuild, $userAgent, $matches)) {
            //dd($matches);
            $androidVersionNumber = $matches[1];
            $build = $matches[2];
            echo 'vCode=<b>'.$androidVersionNumber.'</b> buildName=<b>'.$build.'</b>';
        } else {
            echo "No match found.";
        }


        return;
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
