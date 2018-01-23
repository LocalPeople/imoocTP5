<?php
/**
 * Created by PhpStorm.
 * User: Wen
 * Date: 2018/1/23
 * Time: 14:55
 */

namespace app\lib\exception;


class WxException extends BaseException
{
    public $code=400;
    public $msg='微信服务器接口调用失败';
    public $errorCode=999;
}