<?php
/**
 * Created by PhpStorm.
 * User: Wen
 * Date: 2018/1/19
 * Time: 13:51
 */

namespace app\api\controller\v1;

use app\api\validate\IDMustBePositiveInt;
use app\api\model\Banner as BannerModel;
use app\lib\exception\BannerMissException;

class Banner
{
    public function getBanner($id){

        (new IDMustBePositiveInt())->goCheck();

        $banner=BannerModel::getBannerByID($id);
        //隐藏模型字段
//        $banner->hidden(['update_time', 'delete_time']);

        //基于ORM获取数据
//        $banner=BannerModel::get($id);

        //tp5内置关联表查询
//        $banner=BannerModel::with(['items', 'items.img'])->find();

        if(!$banner){
            throw new BannerMissException();
        }
        return $banner;
    }
}