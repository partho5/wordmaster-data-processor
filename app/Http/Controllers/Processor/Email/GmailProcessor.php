<?php

/**
 * Created by PhpStorm.
 * User: Partho
 * Date: 10/10/2023
 * Time: 12:42 AM
 */

namespace App\Http\Controllers\Processor\Email;

use Google\Client;

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



}