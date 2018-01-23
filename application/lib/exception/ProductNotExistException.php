<?php
/**
 * Created by PhpStorm.
 * User: Wen
 * Date: 2018/1/23
 * Time: 9:44
 */

namespace app\lib\exception;


class ProductNotExistException extends BaseException
{
    public $code=404;
    public $msg='指定商品不存在，请检查参数';
    public $errorCode=20000;
}