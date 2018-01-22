<?php
/**
 * Created by PhpStorm.
 * User: Wen
 * Date: 2018/1/22
 * Time: 11:54
 */

namespace app\api\validate;


class IDCollection extends MyValidate
{
    protected $rule=[
        'ids'=>'require|checkIds'
    ];

    protected $message=[
        'ids'=>'ids必须是以逗号分隔的多个正整数'
    ];

    protected function checkIds($value){
        $values=explode(',', $value);
        if(empty($values)){
            return false;
        }
        foreach($values as $id){
            if(!$this->isPositiveInteger($id)){
                return false;
            }
        }
        return true;
    }
}