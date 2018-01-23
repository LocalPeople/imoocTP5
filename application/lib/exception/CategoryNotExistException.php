<?php
/**
 * Created by PhpStorm.
 * User: Wen
 * Date: 2018/1/23
 * Time: 10:51
 */

namespace app\lib\exception;


class CategoryNotExistException extends BaseException
{
    public $code=404;
    public $msg='指定类目不存在，请检查参数';
    public $errorCode=50000;
}