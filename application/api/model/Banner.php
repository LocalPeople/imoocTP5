<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/19
 * Time: 20:36
 */

namespace app\api\model;


class Banner extends BaseModel
{
    protected $hidden = ['update_time', 'delete_time'];

    public function items()
    {
        return $this->hasMany('BannerItem', 'banner_id', 'id');
    }

    public static function getBannerByID($id)
    {
        //TODO:根据Banner ID号获取Banner信息
//        $result=Db::query('select * from banner_item where banner_id=?', [$id]);
//        $result=Db::table('banner_item')->where('banner_id', '=', $id)->select();
//        return $result;

        //tp5内置关联表查询
        return self::with(['items', 'items.img'])->find($id);
    }
}