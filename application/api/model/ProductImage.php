<?php
/**
 * Created by PhpStorm.
 * User: Wen
 * Date: 2018/1/24
 * Time: 10:15
 */

namespace app\api\model;


class ProductImage extends BaseModel
{
    protected $hidden=['img_id', 'delete_time', 'product_id'];

    public function imgUrl(){
        return $this->belongsTo('Image', 'img_id', 'id');
    }
}