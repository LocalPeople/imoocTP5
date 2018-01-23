<?php

namespace app\api\controller\v1;

use app\api\validate\IDCollection;
use app\api\validate\IDMustBePositiveInt;
use app\lib\exception\ThemeMissException;
use think\Controller;
use app\api\model\Theme as ThemeModel;

class Theme extends Controller
{
    public function getSimpleList($ids = '')
    {
        (new IDCollection())->goCheck();

        $ids = explode(',', $ids);
        $result = ThemeModel::with(['topImg', 'headImg'])->select($ids);
        if ($result->isEmpty()) {
            return new ThemeMissException();
        }
        return $result;
    }

    public function getComplexOne($id)
    {
        (new IDMustBePositiveInt())->goCheck();

        $result = ThemeModel::with(['products', 'topImg', 'headImg'])->find($id);
        if (!$result) {
            return new ThemeMissException();
        }
        return $result;
    }
}
