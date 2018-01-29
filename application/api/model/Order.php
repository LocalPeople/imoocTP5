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
}