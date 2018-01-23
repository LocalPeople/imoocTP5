<?php

namespace app\api\model;

class Product extends BaseModel
{
    protected $hidden = [
        'delete_time', 'main_img_id', 'pivot', 'from', 'category_id',
        'create_time', 'update_time'
    ];

    protected function getMainImgUrlAttr($value)
    {
        return config('setting.image_prefix') . $value;
    }

    public static function getMostRecent($count)
    {
        $products=self::limit($count)->order('create_time desc')->select();
        return $products;
    }

    public static function getProductsByCategoryID($id){
        return self::where('category_id', '=', $id)->select();
    }
}
