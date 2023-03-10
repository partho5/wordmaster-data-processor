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
