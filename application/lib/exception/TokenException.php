<?php
/**
 * Created by PhpStorm.
 * User: Wen
 * Date: 2018/1/24
 * Time: 8:33
 */

namespace app\lib\exception;


class TokenException extends BaseException
{
    public $code=401;
    public $msg='Token已过期或无效Token';
    public $errorCode=10001;
}