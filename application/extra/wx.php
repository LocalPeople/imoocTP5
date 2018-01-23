<?php
/**
 * Created by PhpStorm.
 * User: Wen
 * Date: 2018/1/23
 * Time: 14:06
 */
return [
    'app_id'=>'',
    'app_secret'=>'',
    'login_url'=>'https://api.weixin.qq.com/sns/jscode2session?'.
        'appid=%s&secret=%s&js_code=%s&grant_type=authorization_code'
];