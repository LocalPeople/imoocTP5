<?php

namespace app\api\model;

class Image extends BaseModel
{
    protected $hidden=['id', 'from', 'delete_time', 'update_time'];

    //tp5模型读取器方法定义
    public function getUrlAttr($value, $data){
        return $this->prefixImgUrl($value, $data);
    }
}
