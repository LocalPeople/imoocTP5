<?php
/**
 * Created by PhpStorm.
 * User: Wen
 * Date: 2018/1/23
 * Time: 10:39
 */

namespace app\api\model;


class Category extends BaseModel
{
    protected $hidden=['delete_time', 'create_time', 'update_time'];

    public function Img(){
        return $this->belongsTo('Image', 'topic_img_id', 'id');
    }
}