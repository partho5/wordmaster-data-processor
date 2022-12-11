<?php

namespace App\Http\Controllers;

use App\Models\ChatAdmins;
use App\Models\ChatUsers;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

class ChatController extends Controller
{
    public function __construct(){
        $this->middleware('auth')->except('insertMsgFromUser', 'fetchChatData');
    }

    private $connectAdminId_DEFAULT = 4;

    public function insertMsgFromUser(Request $request){
        //return $request->all();
        $deviceId = $request->did;
        $msg = $request->msg;
        $user = User::where('device_id', $deviceId)->get();

        if( count($user) > 0 ){
            //user id for this device id exists
            $userId = $user[0]->id;
        }else{
            //user id for this device NOT exist. so create user. remember about $fillable before inserting method
            $user = new User();
            $user->device_id = $deviceId;
            $user->created_at = Carbon::now();
            $user->save();

            $userId = $user->id;
        }
        //return $userId;


        $userMsg  = new ChatUsers();
        $userMsg->from_user_id = $userId;
        $userMsg->to_admin_id = $this->connectAdminId_DEFAULT;
        $userMsg->msg = $msg;
        $userMsg->save();

        $data = [
            'status' => 200,
            'userId' => $userId
        ];

        return response()->json($data);
    }


    function insertMsgFromAdmin(Request $request){
        //return $request->all();
        if( in_array(Auth::id(), MyConstants::$adminIds) ){
            $adminMsg = new ChatAdmins();
            $adminMsg->from_admin_id = Auth::id();
            $adminMsg->to_user_id = $request->user_id;
            $adminMsg->msg = $request->msg;
            $adminMsg->save();
        }else{
            return response("Only admin can access this", 401);
        }
    }


    /*
     * list of all users who messaged ever
     * */
    function showUsersList(Request $request){
        if( in_array(Auth::id(), MyConstants::$adminIds) ){
            //request from admins

            $users = DB::table('chat_users as cu')
                ->select('cu.*', 'u.device_id', 'u.device_name', 'u.os_version')
                ->join('users as u', 'cu.from_user_id', '=', 'u.id')
                ->get()->groupBy('device_id');

            //return $users;

            return view('admin/chat_list', compact(
                'users'
            ));
        }else{
            //not admin. cannt access this page
            return response("Only admin can access this", 401);
        }
        //return $request->all();
    }


    /*
     * chat with single user
     * */
    function showChatPage(Request $request){
        //return $request->all();
        if( in_array(Auth::id(), MyConstants::$adminIds) ){
            $user = User::where('device_id', $request->device_id)->get();
            if( count($user) > 0 ){
                $userId = $user[0]->id;
                $chat = $this->fetchChatDataForUid($userId);
                //array_reverse($chat) will reverse the collection

                return view('admin/chat_with_user', compact(
                    'chat'
                ));

            }
        }else{
            //unauthorized request
            return response("Only admin can access this", 401);
        }
    }

    function fetchChatDataForUid($userId){
        $userMsg = ChatUsers::where('from_user_id', $userId)->get();
        $adminMsg = ChatAdmins::where('to_user_id', $userId)->get();
        $chat = $userMsg->concat($adminMsg);

        $chat = array_values(Arr::sort($chat, function ($value) {
            return $value['created_at'];
        }));

        return $chat;
    }

    function fetchChatData(Request $request){
        $userId = $request->userId;
        $chat = $this->fetchChatDataForUid($userId);
        return $chat;
    }

}
