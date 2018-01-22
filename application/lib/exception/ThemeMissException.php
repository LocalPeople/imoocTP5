<?php
/**
 * Created by PhpStorm.
 * User: Wen
 * Date: 2018/1/22
 * Time: 13:51
 */

namespace app\lib\exception;


class ThemeMissException extends BaseException
{
    protected $code=404;
    protected $message='指定主题不存在，请检查主题ID';
    protected $errorCode=30000;
}