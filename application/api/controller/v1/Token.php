<?php
/**
 * Created by PhpStorm.
 * User: Wen
 * Date: 2018/1/23
 * Time: 13:32
 */

namespace app\api\controller\v1;


use app\api\service\AppToken;
use app\api\service\UserToken;
use app\api\validate\AppTokenGet;
use app\api\validate\TokenGet;
use app\lib\exception\ParameterException;
use app\api\service\Token as TokenService;

class Token
{
    public function getToken($code=''){
        (new TokenGet())->goCheck();

        $ut=new UserToken($code);
        $token=$ut->get();
        return [
            'token'=>$token
        ];
    }

    public function getAppToken($ac, $se){
        (new AppTokenGet())->goCheck();

        $app=new AppToken();
        $token=$app->get($ac, $se);
        return [
            'token'=>$token
        ];
    }

    public function verify($token=''){
        if(!$token){
            throw new ParameterException([
                'msg'=>'token不能为空'
            ]);
        }

        $isValid=TokenService::verify($token);
        return [
            'isValid'=>$isValid
        ];
    }
}