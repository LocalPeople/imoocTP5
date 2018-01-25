<?php
/**
 * Created by PhpStorm.
 * User: Wen
 * Date: 2018/1/23
 * Time: 9:15
 */

namespace app\api\controller\v1;


use app\api\validate\CountValidate;
use app\api\model\Product as ProductModel;
use app\api\validate\IDMustBePositiveInt;
use app\lib\exception\ProductNotExistException;

class Product
{
    public function getRecent($count = 15)
    {
        (new CountValidate())->goCheck();

        $products = ProductModel::getMostRecent($count);
        if ($products->isEmpty()) {
            throw new ProductNotExistException();
        }
        //设置database.php->'resultset_type'='collection'
        //collection类拥有hidden函数
        $products = $products->hidden(['summary']);
        return $products;
    }

    public function getAllInCategory($id)
    {
        (new IDMustBePositiveInt())->goCheck();

        $products = ProductModel::getProductsByCategoryID($id);
        if ($products->isEmpty()) {
            throw new ProductNotExistException();
        }
        return $products;
    }

    public function getOne($id){
        (new IDMustBePositiveInt())->goCheck();

        $product=ProductModel::getProductDetail($id);
        if (!$product) {
            throw new ProductNotExistException();
        }
        return $product;
    }

    public function deleteOne($id){

    }
}