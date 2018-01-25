<?php
/**
 * Created by PhpStorm.
 * User: Wen
 * Date: 2018/1/23
 * Time: 13:50
 */

namespace app\api\model;


class User extends BaseModel
{
    public function address(){
        return $this->hasOne('UserAddress', 'user_id', 'id');
    }

    public static function getByOpenID($openid){
        return self::where('openid', '=', $openid)->find();
    }
}