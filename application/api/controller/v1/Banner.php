<?php
/**
 * Created by PhpStorm.
 * User: Wen
 * Date: 2018/1/19
 * Time: 13:51
 */

namespace app\api\controller\v1;

use app\api\validate\IDMustBePositiveInt;

class Banner
{
    public function getBanner($id){
//        $data=[
//            'id'=>$id
//        ];
//
///*        $validate=new Validate([
//            'name'=>'require|max:10',
//            'email'=>'email'
//        ]);*/
//        $validate=new IDMustBePositiveInt();
//
//        $result=$validate->batch()->check($data);
////        var_dump($validate->getError());
//        if($result){
//
//        }
//        else{
//
//        }

        (new IDMustBePositiveInt())->goCheck();
    }
}