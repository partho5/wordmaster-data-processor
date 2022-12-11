<?php

namespace App\Http\Controllers;

use App\Models\BottomPopups;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NotificationController extends Controller
{

    function showCreateNotification(){
        return view('admin/create_notification');
    }

    function doCreateNotification(Request $request){
        
        // $data = BottomPopups::create([
        //     'details_content'   => $request->htmlContent,
        //     'positive_btn'      => $request->positiveBtnText,
        //     'positive_btn_link' => $request->positiveBtnLink,
        //     'negative_btn'      => $request->negativeBtnText,
        //     'self_dismiss_time' => $request->selfDismissAfter,
        //     'valid_till'        => $request->validTill,
        //     'repeat_interval'   => $request->repeatInterval,
        //     'extras'            => $request->extras,
        //     'created_at'        => Carbon::now(),
        //     'updated_at'        => Carbon::now()
        // ]);


        


        $hour = date('H');//24 hour format
        if(true || $hour%2 == 7 || $hour%2 == 10){
            //this is dummy data
            $data = BottomPopups::create([
                'details_content'   => "-",
                'positive_btn'      => "-",
                'positive_btn_link' => "-",
                'negative_btn'      => "0",
                'self_dismiss_time' => "10",
                'valid_till'        => "2022-08-24 13:01:00",
                'repeat_interval'   => 10,
                'extras'            => $request->extras, //"{\"type\":\"wake\"}",
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now()
            ]);

            $this->sendPushNotification($data);
        }

        
        //$this->sendPushNotification($data);

    }


    function checkAvailability(Request $request){
        
        $data = [
            'id'                => 123,
            'latestVersionCode' => 1,
            'extras'            => ["type"=>"dailyCheck"]
        ];

        $this->sendPushNotification($data);

        //return response()->json($data);
    }


    function sendPushNotification($data) {
        
        $content = array(
                "en" => 'Click to open',
                );

            $fields = array(
                'app_id' => env('oneSignalAppId'),
                'included_segments' => array('All'),
                'data' => $data,
                'large_icon' =>"ic_launcher_round.png",
                'contents' => $content
            );

            

            $fields = json_encode($fields);
            //print("\nJSON sent:\n");
            print($fields);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
                                                       'Authorization: Basic '.env('oneSignalRestApiKey')));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, FALSE);
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);    

            $response = curl_exec($ch);
            curl_close($ch);

            return $response;
    }



}
