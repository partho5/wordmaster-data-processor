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








    function saveAppLog(Request $request){
        //return $request->log;
        $log = $request->log;
        $userId = $request->userId;
        $meta = $request->meta;
        $versionCode = $request->versionCode;
        $oneSignalId = @$request->oneSignalId; //for previous versions of app, this key may not exist
        $meta = $meta.",vCode=".$versionCode;
        //$logJson = json_decode($log, true);
        //return $logJson;
        UserActivityLog::create([
        	'user_id'		=> $userId,
            'log'   		=> $log,
            'meta'  		=> $meta,
        ]);

        User::where('id', $userId)->update([
            'onesignal_id'  => @$oneSignalId
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
