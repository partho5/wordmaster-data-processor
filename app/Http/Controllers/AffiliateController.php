<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AffiliateController extends Controller
{
    public function showPartnerHome(Request $request){
        return view('affiliate/index');
    }
}
