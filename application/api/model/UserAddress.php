<?php
/**
 * Created by PhpStorm.
 * User: Wen
 * Date: 2018/1/25
 * Time: 15:18
 */

namespace app\api\model;


class UserAddress extends BaseModel
{
    protected $hidden = ['id', 'delete_time', 'user_id'];
}