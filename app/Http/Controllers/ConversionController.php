<?php

namespace App\Http\Controllers;

use App\Helpers\ConversionHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ConversionController extends Controller
{
    public function purchaseComplete(Request $request){
        $accessToken = env('FB_CAPI_TOKEN');
        $pixelId = env('FB_PIXEL_ID');

        $payload = [
            'event_name' => 'PurchaseComplete',
            'event_time' => time(),
            'event_id' => $request->event_id,
            'user_data' => [
                'client_ip_address' => $request->ip(),
                'client_user_agent' => $request->header('User-Agent'),
            ],
            'custom_data' => [
                'value' => $request->value,
                'currency' => $request->currency,
                'platform' => $request->platform
            ]
        ];

        // Optionally include fbclid if present
        if ($request->filled('fbclid')) {
            $payload['user_data']['fbclid'] = $request->input('fbclid');
        }

        $response = Http::post("https://graph.facebook.com/v19.0/{$pixelId}/events", [
            'data' => [$payload],
            'access_token' => $accessToken
        ]);

        try{
            ConversionHelper::saveConversionLog([
                'event_id' => $request->event_id,
                'value' => $request->value,
                'currency' => $request->currency,
                'platform' => $request->platform,
                'ip' => $request->ip(),
                'user_agent' => $request->header('User-Agent'),
                'fbclid' => $request->input('fbclid'),
            ]);
        }catch(\Exception $e){}

        return response()->json([
            'status' => 'ok',
            'fb_response' => $response->json()
        ]);
    }
}
