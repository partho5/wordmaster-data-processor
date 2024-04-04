<?php

/**
 * Created by PhpStorm.
 * User: Partho
 * Date: 10/10/2023
 * Time: 12:42 AM
 */

namespace App\Http\Controllers\Processor\Email;

use Dacastro4\LaravelGmail\Facade\LaravelGmail;
use Dacastro4\LaravelGmail\Services\Message\Mail;
use Exception;
use Google\Client;
use Illuminate\Support\Facades\Log;

class GmailProcessor{

    public function getAccessToken($clientId, $clientSecret, $accessTokenJsonStr){
        $client = new Client();
        $client->setClientId($clientId);
        $client->setClientSecret($clientSecret);
        $client->setAccessType('offline'); // This is important to request a refresh token
        $client->setAccessToken($accessTokenJsonStr);


        // Check if the access token is expired
        if ($client->isAccessTokenExpired()) {
            // If expired, fetch a new access token using the refresh token
            $client->fetchAccessTokenWithRefreshToken();

        }

        // Get the new access token
        $accessToken = $client->getAccessToken(); //JSON object containing `access_token`, `refresh_token`, `scope` etc.

        return $accessToken;
    }//getAccessToken()




    public function sendEmail($data){
        if (
            isset($data['mailTo']) &&
            isset($data['fromEmail']) &&
            isset($data['subject']) &&
            isset($data['mailBodyHtmlContent'])
        ){
            $clientId = env('GOOGLE_CLIENT_ID');
            $clientSecret = env('GOOGLE_CLIENT_SECRET');
            $accessTokenJsonStr = env('GMAIL_OAUTH_CALLBACK_JSON');

            $accessToken = $this->getAccessToken($clientId, $clientSecret, $accessTokenJsonStr);
            LaravelGmail::setAccessToken($accessToken);


            $accessTokenInfo = LaravelGmail::getAccessToken();
            $accessToken = $accessTokenInfo['access_token'];
            Log::info('Access Token: ' . $accessToken);



            $mail = new Mail();

            $mail->to($data['mailTo'], $data['recipientName'] ?? null);
            $mail->from($data['fromEmail'], $data['fromName'] ?? null);
            $mail->subject($data['subject']);
            $mail->message($data['mailBodyHtmlContent']);

            // if cc and bcc not needed, set them same as main recipient, since they cannot be empty
            $mail->cc($data['mailTo']);
            $mail->bcc($data['mailTo']);


            try {
                $mail->send();
                return response()->json([
                    'message' => 'Email sent successfully'
                ], 200);
            } catch (Exception $exception) {
                Log::error('Email sending failed: ' . $exception->getMessage()); //saved in laravel.log

                return response()->json([
                    'error' => 'Email sending failed'
                ], 500);
            }
        }else{
            return response('One or more basic mail parameter(s) missing !', 400);
        }
    }//sendEmail()



}