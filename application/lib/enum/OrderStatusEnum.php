<?php
/**
 * Created by PhpStorm.
 * User: Wen
 * Date: 2018/1/30
 * Time: 11:35
 */

namespace app\lib\enum;


class OrderStatusEnum
{
    const UNPAID=1;
    const PAID=2;
    const DELIVERED=3;
    const PAID_BUT_OUT_OF=4;
}