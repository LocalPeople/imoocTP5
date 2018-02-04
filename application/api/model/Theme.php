<?php
/**
 * Created by PhpStorm.
 * User: Wen
 * Date: 2018/1/22
 * Time: 11:27
 */

namespace app\api\model;


class Theme extends BaseModel
{
    protected $hidden=[
        'delete_time', 'update_time', 'topic_img_id', 'head_img_id'
    ];

    public function topImg(){
        return $this->belongsTo('Image', 'topic_img_id', 'id');
    }

    public function headImg(){
        return $this->belongsTo('Image', 'head_img_id', 'id');
    }

    public function products(){
        //多对多关联查询（附加多对多关联表）
        return $this->belongsToMany('Product', 'theme_product', 'product_id', 'theme_id');
    }
}