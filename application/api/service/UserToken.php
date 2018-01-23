<?php
/**
 * Created by PhpStorm.
 * User: Wen
 * Date: 2018/1/23
 * Time: 13:51
 */

namespace app\api\service;


use app\lib\exception\WxException;
use think\Exception;
use app\api\model\User as UserModel;

class UserToken extends Token
{
    protected $code;
    protected $wxAppID;
    protected $wxAppSecret;
    protected $wxLoginUrl;

    function __construct($code)
    {
        $this->code = $code;
        $this->wxAppID = config('wx.app_id');
        $this->wxAppSecret = config('wx.app_secret');
        $this->wxLoginUrl = sprintf(config('wx.login_url'), $this->wxAppID, $this->wxAppSecret, $this->code);
    }

    public function get()
    {
        //TODO:处理微信api返回内容
        $result = curl_get($this->wxLoginUrl);
        $wxResult = json_decode($result, true);
        if (empty($wxResult)) {
            throw new Exception('获取session_key及openID时异常，微信内部错误');
        } else {
            $loginFail = array_key_exists('errcode', $wxResult);
            if ($loginFail) {
                $this->processLoginError($wxResult);
            } else {

            }
        }
    }

    private function grantToken($wxResult)
    {
        $openid=$wxResult['openid'];
        $user=UserModel::getByOpenID($openid);
        if($user){
            $uid=$user->id;
        }
        else{
            $uid=$this->newUser($openid);
        }
        $cachedValue=$this->prepareCachedValue($wxResult, $uid);
    }

    private function saveToCache($cachedValue){
        $key=self::generateToken();
        $value=json_encode($cachedValue);
        $expire_in=config('setting.token_expire_in');

        $request=cache($key, $value, $expire_in);
    }

    private function prepareCachedValue($wxResult, $uid){
        $cachedValue=$wxResult;
        $cachedValue['uid']=$uid;
        $cachedValue['scope']=16;
        return $cachedValue;
    }

    private function newUser($openid){
        $user=UserModel::create([
            'openid'=>$openid
        ]);
        return $user->id;
    }

    private function processLoginError($wxResult)
    {
        throw new WxException([
            'msg' => $wxResult['errmsg'],
            'errorCode' => $wxResult['errcode']
        ]);
    }
}