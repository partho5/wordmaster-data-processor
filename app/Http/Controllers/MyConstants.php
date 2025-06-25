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


    /***************** THIS IS IMPORTANT TO KEEP IN MIND ******************
     * importance_level=90 ---- word smart 1,2
     * importance_level=85 ---- 330 high frequency words which were not in 80 or 90 lists
     * importance_level=80 ---- saifurs pani out of word smart 1,2 (So including 80,90 gives Saifurs words)
     * importance_level=75 ---- previous year question words out of above categories
     * importance_level=60 ---- derived words
     *
     * */


    public static $minImportanceLevelForMainWords = 70;


    //if you change value, also MUST change in user end (in android index.html   const payablePrice=)
    public static $amountToBePaid = 295; //Tk (Excluding payment charge)
    public static $paymentCharge = 5; //bKash send money charge 5 Tk



    /*
     * currently it's not being used
     * */
    //value for word_categories table
    public static $WORD_CATEGORIES = [

        'phrase'            => 19,
        'idiom'             => 20,


//        'BCS'               => 30,
//        'Bangladesh Bank'   => 35,
//        'All Gov\'t Banks'  => 40,
//        'Private Bank'      => 45,
//        'Word Smart 1'      => 50,
//        'Word Smart 2'      => 55,
//        'Saifurs Pani'      => 60,
//        'GRE'               => 65,
    ];

    public static $adminIds = [1,2,3,4,5,6];


}