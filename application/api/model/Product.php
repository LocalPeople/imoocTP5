<?php

namespace app\api\model;

class Product extends BaseModel
{
    protected $hidden=[
        'delete_time', 'main_img_id', 'pivot', 'from', 'category_id',
        'create_time', 'update_time'
    ];

    protected function getMainImgUrlAttr($value){
        return config('setting.image_prefix').$value;
    }
}
