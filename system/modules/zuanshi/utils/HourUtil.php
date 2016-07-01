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
        if($hour>=8 && $hour<=14){
            return 1;
        }else if($hour>=14 && $hour<=23){
            return 2;
        }
        return 0;
    }

}