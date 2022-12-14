<?php

namespace App\Http\Controllers;

use App\Models\CouponCodes;
use App\Models\UserPayment;
use Illuminate\Http\Request;
use Carbon\Carbon;

class UserPaymentController extends Controller
{
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
                ->where('paid_amount', '>=', MyConstants::$amountToBePaid-$couponValue )
                ->whereNull('verified_at') //i.e. this trxId is not used before
                ->get();
            if(count($query) == 1){
                $isValid = 1;

                UserPayment::where('auth_token', $trxId)->update(['user_id'=>$userId, 'verified_at'=>Carbon::now(), 'coupon_code'=>$request->coupon ]);
                CouponCodes::where('code', $request->coupon)->update(['used_at'=>Carbon::now(), 'used_by'=>$userId]);
            }
        }

        return response()->json([
            'valid' => $isValid
        ],200);
    }

}
