<?php
namespace application\modules\zuanshi\utils;
/**
 * Created by PhpStorm.
 * User: ouyangjunqiu
 * Date: 16/3/30
 * Time: 下午5:52
 */
class HourUtil
{

    public static function format(){
        $hour = date("H",time());
        $hour = (int)$hour;
        if($hour>=9 && $hour<=12){
            return 1;
        }else if($hour>=14 && $hour<=18){
            return 2;
        }
        return 0;
    }

}