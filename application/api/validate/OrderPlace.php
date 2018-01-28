<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/27
 * Time: 11:44
 */

namespace app\api\validate;


use app\lib\exception\ParameterException;

class OrderPlace extends MyValidate
{
    protected $rule=[
        'products'=>'checkProducts'
    ];

    protected $singleRule=[
        'product_id'=>'require|isPositiveInteger',
        'count'=>'require|isPositiveInteger'
    ];

    protected function checkProducts($products){
        if(!is_array($products)){
            throw new ParameterException([
                'msg'=>'商品参数不正确'
            ]);
        }
        if(empty($products)){
            throw new ParameterException([
                'msg'=>'商品列表不能为空'
            ]);
        }

        foreach($products as $product){
            $this->checkProduct($product);
        }
        return true;
    }

    protected function checkProduct($product){
        $validate=new MyValidate($this->singleRule);
        $result=$validate->check($product);
        if(!$result){
            throw new ParameterException([
                'msg'=>'商品列表参数错误'
            ]);
        }
    }
}