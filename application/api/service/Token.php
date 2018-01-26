<?php
/**
 * Created by PhpStorm.
 * User: Wen
 * Date: 2018/1/23
 * Time: 16:16
 */

namespace app\api\service;


use app\lib\exception\TokenException;
use think\Cache;
use think\Request;
use app\lib\enum\ScopeEnum;

class Token
{
    public static function generateToken()
    {
        $randChars = getRandChars(32);
        $timeStamp = $_SERVER['REQUEST_TIME_FLOAT'];
        $salt = config('secure.token_salt');
        return md5($randChars . $timeStamp . $salt);
    }

    public static function getCurrentTokenVar($key)
    {
        $token = Request::instance()->header('token');
        $vars = Cache::get($token);
        if (!$vars) {
            throw new TokenException();
        }
        if (!is_array($vars)) {
            $vars = json_decode($vars, true);
        }
        if (array_key_exists($key, $vars)) {
            return $vars[$key];
        }
        throw new \Exception('尝试获取的Token并不存在');
    }

    public static function getCurrentUid()
    {
        return self::getCurrentTokenVar('uid');
    }
}