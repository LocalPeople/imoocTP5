<?php
/**
 * Created by PhpStorm.
 * User: Wen
 * Date: 2018/1/23
 * Time: 10:39
 */

namespace app\api\controller\v1;

use app\api\model\Category as CategoryModel;
use app\lib\exception\CategoryNotExistException;


class Category
{
    public function getAllCategory(){
        $category=CategoryModel::all([], 'img');
        if($category->isEmpty()){
            throw new CategoryNotExistException();
        }
        return $category;
    }
}