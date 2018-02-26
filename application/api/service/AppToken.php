<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/22
 * Time: 14:11
 */

namespace app\api\service;


use app\api\model\ThirdApp;
use app\lib\exception\TokenException;

class AppToken extends Token
{
    public function get($ac, $se){
        $app=ThirdApp::check($ac, $se);
        if(!$app){
            throw new TokenException([
                'msg'=>'授权失败',
                'errorCode'=>10004
            ]);
        }
        else{
            $scope=$app->scope;
            $uid=$app->id;
            $value=[
                'scope'=>$scope,
                'uid'=>$uid
            ];
            $token=$this->saveToCache($value);
            return $token;
        }
    }

    private function saveToCache($value){
        $token=self::generateToken();
        $expire_in=config('setting.token_expire_in');

        $request=cache($token, json_encode($value), $expire_in);
        if(!$request){
            throw new TokenException([
                'msg'=>'服务器缓存异常',
                'errorCode'=>10005
            ]);
        }
        return $token;
    }
}