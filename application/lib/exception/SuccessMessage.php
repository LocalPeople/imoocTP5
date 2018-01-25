<?php
/**
 * Created by PhpStorm.
 * User: Wen
 * Date: 2018/1/25
 * Time: 11:18
 */

namespace app\lib\exception;


class SuccessMessage extends BaseException
{
    public $code=201;
    public $msg='OK';
    public $errorCode=0;
}