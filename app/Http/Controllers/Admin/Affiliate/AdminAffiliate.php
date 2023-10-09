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
        $clientId = env('GOOGLE_CLIENT_ID');
        $clientSecret = env('GOOGLE_CLIENT_SECRET');
        $accessTokenJsonStr = env('GMAIL_OAUTH_CALLBACK_JSON');

        $gmailProcessor = new GmailProcessor();
        $accessToken = $gmailProcessor->getAccessToken($clientId, $clientSecret, $accessTokenJsonStr);
        LaravelGmail::setAccessToken($accessToken);


        $mail = new Mail();

        // Set the recipient's email and name (optional)
        $toEmail = $data['mailTo'];
        $toName = $data['userName'];
        $mail->to($toEmail, $toName);

        // Set the sender's email and name (optional)
        $fromEmail = $data['fromEmail'];
        $fromName = $data['fromName'];
        $mail->from($fromEmail, $fromName);

        // Set the email subject
        $subject = 'Dear '.$toName;
        $mail->subject($subject);


        // Set the email body
        $htmlContent = view('mailPages.approve_post_mail', ['data' => $data])->render();
        $mail->message($htmlContent);


        // if cc and bcc not needed, set them same as main recipient, since they cannot be empty
        $mail->cc($toEmail);
        $mail->bcc($toEmail);


        try {
            $mail->send();
        } catch (Exception $exception) {
            return $exception;
        }
    }//sendPostApprovalMail()




    public function saveAffiliateToken($userId, $affiliateToken){
        $person = new AffiliatePersons();
        $person->user_id = $userId;
        $person->reference_token = $affiliateToken;
        $person->created_at = Carbon::now();
        $person->updated_at = Carbon::now();
        $person->save();
    }



    public function forgeAffiliateToken($userId){
        $allowedCharactersInToken = "abcdefghkjpqrstuvwxyz"; //in affiliate token we don't want all alphanumeric characters but want selected characters
        $string = $this->library->generateRandomString(4, $allowedCharactersInToken);
        $token = substr($string, 0, 2).$userId.substr($string, 2);
        return $token;
    }


    /**
     * always returns same link for a given $userId
    */
    public function createAffiliateLink($userId){
        $row = AffiliatePersons::where('user_id', $userId)->select('reference_token')->get();
        if(count($row) > 0){
            $token = $row[0]->reference_token;
            return 'https://'.env('BASE_DOMAIN').'?p='.$token;
        }else{
            //reference_token is not saved for this affiliate $userId
            $token = $this->forgeAffiliateToken($userId);
            $this->saveAffiliateToken($userId, $token);

            $this->createAffiliateLink($userId);
        }

        return "ERROR occured. Please contact support !"; //very unlikely case. token should have been existed.
    }


}
