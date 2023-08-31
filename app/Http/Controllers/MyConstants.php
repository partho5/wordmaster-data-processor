<?php
/**
 * Created by PhpStorm.
 * User: parth
 * Date: 9/5/2020
 * Time: 11:43 PM
 */

namespace App\Http\Controllers;
use Config;


class MyConstants
{
    public $categoryMainWord = 5;
    public $categorySynonymOrAntonym = 6;

    public $hiddenWord = 10;
    public $softDeleted = 11;

    public $idiom = 20;
    public $phrasalVerb = 21;


    /*
     * importance_level=90 ---- word smart 1,2
     * importance_level=85 ---- 330 high frequency words which were not in 80 or 90 lists
     * importance_level=80 ---- saifurs pani out of word smart 1,2
     * importance_level=75 ---- previous year question words out of above categories
     * importance_level=60 ---- derived words
     *
     * */


    public static $minImportanceLevelForMainWords = 75;


    //if you change value, also MUST change in user end (in android index.html   const payablePrice=)
    public static $amountToBePaid = 150; //Tk (Excluding payment charge)
    public static $paymentCharge = 5; //bKash send money charge 5 Tk


    //value for word_categories table
    public static $WORD_CATEGORIES = [
        'BCS'               => 30,
        'Bangladesh Bank'   => 35,
        'All Gov\'t Banks'  => 40,
        'Private Bank'      => 45,
        'Word Smart 1'      => 50,
        'Word Smart 2'      => 55,
        'Saifurs Pani'      => 60,
        'GRE'               => 65,
    ];

    public static $adminIds = [1,2,3,4,5,6];


    public static $affiliatePostApproveMailSubject = "Your video / link has been reviewed";
    public static $affiliatePostApproveEmailTemplate = "We saw that you created a nice video. Below we have provided you an affiliate link which you will put in the description of your video. When someone buys from your link, you will get the revenue share.";

}