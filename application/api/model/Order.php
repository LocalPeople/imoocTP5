<?php
/**
 * Created by PhpStorm.
 * User: Wen
 * Date: 2018/1/29
 * Time: 11:17
 */

namespace app\api\model;


class Order extends BaseModel
{
    protected $hidden=['user_id', 'delete_time', 'update_time'];
    protected $autoWriteTimestamp=true;

    public function getSnapItemsAttr($value){
        if(empty($value)){
            return null;
        }
        return json_decode($value);
    }

    public function getSnapAddressAttr($value){
        if(empty($value)){
            return null;
        }
        return json_decode($value);
    }

    public static function getSummaryByUser($uid, $page, $size){
        return self::where('user_id', '=', $uid)
            ->order('create_time', 'desc')
            ->paginate($size, true, ['page'=>$page]);
    }

    public static function getSummary($page, $size){
        return self::order('create_time', 'desc')
            ->paginate($size, true, ['page'=>$page]);
    }
}