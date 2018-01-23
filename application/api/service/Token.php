<?php
/**
 * Created by PhpStorm.
 * User: Wen
 * Date: 2018/1/23
 * Time: 16:16
 */

namespace app\api\service;


class Token
{
     public static function generateToken(){
         $randChars=getRandChars(32);
         $timeStamp=$_SERVER['REQUEST_TIME_FLOAT'];
         $salt=config('secure.token_salt');
         return md5($randChars.$timeStamp.$salt);
     }
}