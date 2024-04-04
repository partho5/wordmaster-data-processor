<?php
/**
 * Created by PhpStorm.
 * User: Partho
 * Date: 10/17/2023
 * Time: 2:06 AM
 */

namespace App\Http\Controllers\Contents;


class VariousData{

    private $versionApiMap = [
        '5.0'       => 21,

        '5.1'       => 22,
        '5.1.1'     => 22,

        '6.0'       => 23,
        '6.0.1'     => 23,

        '7.0'       => 24,
        '7.1.1'     => 25,
        '7.1.2'     => 25,

        '8.0.0'     => 26,
        '8.1.0'     => 27,

        '9'         => 28,
        '10'        => 29,
        '11'        => 30,

        '12'        => 31,
        '12L'       => 32,

        '13'        => 33,
        '14'        => 34,
    ];


    public function androidVersionToApiLevel($version){
        return $this->versionApiMap[$version];
    }
}