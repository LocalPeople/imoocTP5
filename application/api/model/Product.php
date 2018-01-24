<?php

namespace app\api\model;

class Product extends BaseModel
{
    protected $hidden = [
        'delete_time', 'main_img_id', 'pivot', 'from', 'category_id',
        'create_time', 'update_time'
    ];

    protected function getMainImgUrlAttr($value)
    {
        return config('setting.image_prefix') . $value;
    }

    public function detailImgs(){
        return $this->hasmany('ProductImage', 'product_id', 'id');
    }

    public function properties(){
        return $this->hasMany('ProductProperty', 'product_id', 'id');
    }

    public static function getMostRecent($count)
    {
        $products=self::limit($count)->order('create_time', 'desc')->select();
        return $products;
    }

    public static function getProductsByCategoryID($id){
        return self::where('category_id', '=', $id)->select();
    }

    public static function getProductDetail($id){
//        return self::with(['detailImgs', 'detailImgs.imgUrl', 'properties'])->find($id);
        return self::with([
            'detailImgs'=>function($query){
                $query->with(['imgUrl'])->order('order', 'asc');
            }
        ])->with(['properties'])->find($id);
    }
}
