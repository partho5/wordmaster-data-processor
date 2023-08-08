<?php

namespace App\Http\Controllers;

use App\Models\AffiliatePosts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AffiliateController extends Controller
{
    /* Affiliates are partners. The word 'affiliate' and 'affiliate' has been used interchangeably */

    function __construct(){
        $this->middleware('auth')->except(['showAffiliateLandingPage']);
    }

    public function showAffiliateLandingPage(Request $request){
        return view('affiliate/landing-page');
    }

    public function showAffiliateHome(Request $request){

        $affiliateId = 423;
        $enc = (new UserIdEncodeDecode())->encodeNumberToString($affiliateId);
        $dec = (new UserIdEncodeDecode())->decodeStringToNumber($enc);
        echo $affiliateId.' > '.$enc.' < '.$dec."<br>";
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
