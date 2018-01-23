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
}