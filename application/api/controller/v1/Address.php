<?php
/**
 * Created by PhpStorm.
 * User: Wen
 * Date: 2018/1/24
 * Time: 14:31
 */

namespace app\api\controller\v1;


use app\api\model\User as UserModel;
use app\api\service\Token as TokenService;
use app\api\validate\AddressNew;
use app\lib\exception\SuccessMessage;
use think\Exception;
use app\api\controller\BaseController;

class Address extends BaseController
{
    protected $beforeActionList=[
        'beforePrimaryScope'=>['only'=>'createOrUpdateAddress']
    ];

    //创建或更新特定用户的地址信息
    public function createOrUpdateAddress(){
        $validate=new AddressNew();
        $validate->goCheck();

        //TODO:根据Token获取uid
        $uid=TokenService::getCurrentUid();
        //TODO:根据uid来查找用户数据，判断用户是否存在，如果不存在抛出异常
        $user=UserModel::get($uid);
        if(!$user){
            throw new Exception('用户不存在');
        }
        //TODO:获取用户从客户端提交来的地址信息
        $dataArray=$validate->getDataByRule(input('post.'));
        //TODO:根据用户地址信息是否存在，从而判断是添加地址还是更新地址
        $userAddress=$user->address;
        if(!$userAddress){
            $user->address()->save($dataArray);//新增用户地址记录
        }
        else{
            $user->address->save($dataArray);//更新用户地址记录
        }
        return json(new SuccessMessage(), 201);
    }
}