<?php
/**
 * Created by PhpStorm.
 * User: Wen
 * Date: 2018/1/26
 * Time: 16:58
 */

namespace app\api\controller;


use app\lib\enum\ScopeEnum;
use think\Controller;
use app\api\service\Token as TokenService;

class BaseController extends Controller
{
    protected function beforePrimaryScope()
    {
        $scope = TokenService::getCurrentTokenVar('scope');
        if ($scope >= ScopeEnum::User) {
            return true;
        } else {
            throw new \Exception('权限受限');
        }
    }

    protected function checkExclusiveScope(){
        $scope=TokenService::getCurrentTokenVar('scope');
        if($scope==ScopeEnum::User){
            return true;
        }
        else{
            throw new \Exception('权限受限');
        }
    }
}