<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/22
 * Time: 14:16
 */

namespace app\api\model;


class ThirdApp extends BaseModel
{
    public static function check($ac, $se){
        return self::where('app_id', '=', $ac)
            ->where('app_secret', '=', $se)
            ->find();
    }
}