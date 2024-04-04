<?php

/**
 * Created by PhpStorm.
 * User: Partho
 * Date: 10/10/2023
 * Time: 12:37 AM
 */

namespace App\Http\Controllers\Admin\Affiliate;


use App\Http\Controllers\Library;
use App\Http\Controllers\Processor\Email\GmailProcessor;
use App\Models\AffiliatePersons;
use Carbon\Carbon;
use Dacastro4\LaravelGmail\Facade\LaravelGmail;
use Dacastro4\LaravelGmail\Services\Message\Mail;
use Exception;


class AdminAffiliate{

    private $library;

    function __construct(){
        $this->library = new Library();
    }

    public function sendPostApprovalMail($data){
        //if more custom logic needed, perform here
        $gmailProcessor = new GmailProcessor();
        $gmailProcessor->sendEmail($data);
    }//sendPostApprovalMail()




    public function saveAffiliateToken($userId, $affiliateToken){
        $person = new AffiliatePersons();
        $person->user_id = $userId;
        $person->reference_token = $affiliateToken;
        $person->created_at = Carbon::now();
        $person->updated_at = Carbon::now();
        $success = $person->save();

        return $success;
    }


    public function queryAffiliateToken($userId){
        $row = AffiliatePersons::where('user_id', $userId)->select('reference_token')->get();
        if(count($row) > 0){
            return $token = $row[0]->reference_token;
        }
        return null;
    }



    public function generateAffiliateToken($userId){
        $allowedCharactersInToken = "abcdefghkjpqrstuvwxyz"; //in affiliate token we don't want all alphanumeric characters but want selected characters
        $string = $this->library->generateRandomString(4, $allowedCharactersInToken);
        $token = substr($string, 0, 2).$userId.substr($string, 2);
        return $token;
    }


    /**
     * always returns same link for a given $userId
    */
    public function affiliateLinkOf($userId){
        $token = $this->queryAffiliateToken($userId);
        if($token){
            return 'https://'.env('BASE_DOMAIN').'?p='.$token; // env('BASE_DOMAIN') needed if want to get base domain in the content sent as email. because $_SERVER['REMOTE_ADDR'] will return public IP of recipient
        }
        return null;
    }


}
