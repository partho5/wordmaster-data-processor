<?php

namespace App\Http\Controllers;

use App\Models\CouponCodes;
use App\Models\UserPayment;
use Illuminate\Http\Request;
use Carbon\Carbon;

class UserPaymentController extends Controller
{

    //when bkash sms arrives, payment app inserts that trxId using this function
    public function insertPayment(Request $request){
        //return $request->all();
        $authKey = $request->authKey;
        if($authKey == "onlyMyDeviceAccepted623"){
            $paymentData = json_decode( $request->data );
            //return $paymentData;
            foreach ($paymentData as $json){
                UserPayment::updateOrCreate([
                    'auth_token'     => $json->authToken
                ], [
                    'payment_method' => $json->method,
                    'paid_amount'    => $json->paidAmount,
                    'paid_at'        => $json->paidAt,
                    'payer_mobile'   => $json->payerMobile,
                    'meta'           => $json->meta
                ]);
            }
            return response()->json([
                'msg'   => 'success'
            ],200);
        }else{
            return response()->json([
                'msg' => 'Unuthorized'
            ],403);
        }
    }



    public function verifyCoupon(Request $request){
        //return $request->all();
        $row = CouponCodes::where('code', $request->coupon)->get();
        $msg = '';
        if(count($row)>0){
            //return $row;
            //validity check
            if($row[0]->valid_till <= Carbon::now()){
                $msg = "Validity expired";
            }else{
                $msg = 'valid';
            }

            //this block should remain after validity check block
            if(! is_null($row[0]->used_at)){
                //if expired and also used, the expiry msg will be overwritten by this msg
                $msg = "This code is already used";
            }
        }else{
            //not exist
            $msg = 'Invalid code. Please make sure that you wrote it correct';
        }
        $data['msg'] = $msg;
        if($msg=='valid'){
            $couponValue = $row[0]->amount;
            $data['value'] = $couponValue;
            $amountToPay = MyConstants::$amountToBePaid-$couponValue;
            $data['amountToPay'] = $amountToPay;
        }

        return $data;
    }

    public function showPurchaseComplete(Request $request){
        return view('payment/payment_success');
    }



    /* when user submits TrxID from payment page, TrxID is verified bu this function */
    public function verifyPayment(Request $request){
        $isValid = 0;

        $userId = $request->userId;
        $trxId = $request->trxId;

        $couponValue = 0;
        if($request->has('coupon')){
            $coupon = $this->verifyCoupon($request);
            if($coupon['msg'] == 'valid'){
                $couponValue = $coupon['value'];
            }
        }



        if($userId && $trxId){
            $query = UserPayment::where('auth_token', $trxId)
                ->where('paid_amount', '>=', MyConstants::$amountToBePaid - MyConstants::$paymentCharge - $couponValue) //we will bear the payment charge
                ->whereNull('verified_at') //i.e. this trxId is not used before
                ->get();
            if(count($query) >= 1){
                //TrxID exists but not verified by any user yet
                $isValid = 1;

                //now set: that user has verified with that TrxID
                UserPayment::where('auth_token', $trxId)
                    ->update(['user_id'=>$userId, 'verified_at'=>Carbon::now(), 'coupon_code'=>$request->coupon ]);
                CouponCodes::where('code', $request->coupon)
                    ->update(['used_at'=>Carbon::now(), 'used_by'=>$userId]);
            }else{
                /* ************* tentative ************** */
                /* As payment verification based on my android phone is not guaranteed to work always. so if user pays and in that moment my verification doesn't work, to avoid such case insert whatever TrxId user tried. as request arrives here means he entered a 10 chars TrxId, so most likely it's valid suggesting he made a payment */
                $isValid = 1;

                $payment = new UserPayment();
                $payment->user_id = $userId;
                $payment->payment_method = 'NOT SURE';
                $payment->paid_at = date('Y-m-d H:i:s');
                $payment->auth_token = $trxId;
                $payment->verified_at = date('Y-m-d H:i:s');
                $payment->save();
            }
        }


        return response()->json([
            'isValid' => $isValid
        ],200)
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
    }


    public function verifyPaymentIssueReport(){
        return "<div style='font-size: 3em; padding: 16px'>Job Vocabulary তে Payment সংক্রান্ত সমস্যা হলে ইমেইল করুন : <br><br>Click on &nbsp;<a href=\"mailto:" . env('ADMIN_EMAIL') . "\">" . env('ADMIN_EMAIL') . "</a></div>";
    }



    public function showBuyApp(Request $request){
        $paymentStatus = $request->status; // this status is set in buy_app.blade.php
        if(isset($paymentStatus)){
            $redirectUrl = '/purchase-complete?status=' . $request->status . '&userId=' . $request->userId;

            // Only append fbclid if it exists in the request
            if($request->has('fbclid') && !empty($request->fbclid)) {
                $redirectUrl .= '&fbclid=' . $request->fbclid;
            }

            return redirect()->to($redirectUrl);
        }

        $appPrice = MyConstants::$amountToBePaid;
        $paymentCharge = MyConstants::$paymentCharge;

        $versionCode = $request->version;
        if( !isset($versionCode) ){
            //for older version. Override app price.
            //$appPrice = 195;
        }

        $netAmountToPay = $appPrice - MyConstants::$paymentCharge;

        return view('payment/buy_app', compact('appPrice', 'paymentCharge', 'netAmountToPay'));
    }


    public function verificationStatus(Request $request){
        //return $request->all();
        $query = UserPayment::where('user_id', $request->userId)
            ->whereNotNull('verified_at')
            ->get();

        $isVerified = 0;
        if(count($query)  == 1){
            $isVerified = 1;
        }

        // debug
        if(in_array($request->userId, [1739, 1110])){
            // developer devices, Realme=1793
            $isVerified = 0;
        }

        return response()->json([
            'isVerified'    => $isVerified
        ], 200);
    }



}
