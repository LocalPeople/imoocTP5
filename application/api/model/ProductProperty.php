<?php
/**
 * Created by PhpStorm.
 * User: Wen
 * Date: 2018/1/24
 * Time: 10:18
 */

namespace app\api\model;


class ProductProperty extends BaseModel
{
    protected $hidden=['product_id', 'delete_time', 'update_time'];
}