<?php
/**
 * @file StringUtil.php
 * @author ouyangjunqiu
 * @version Created by 16/9/6 17:17
 */

namespace application\modules\main\utils;


class StringUtil
{
    public static function tagFormat($str){
        if(empty($str)){
            return $str;
        }
        $str = trim($str);
        $str = str_replace(" ",",",$str);
        $str = str_replace("，",",",$str);
        $str = str_replace("、",",",$str);

        return preg_replace("/,+/",",",$str);
    }

    public static function daysFormat($days){
        if($days>=-7 && $days<=7){
            if($days == 0){
                return "今天";
            }else if($days == -1){
                return "昨天";
            }else if($days == 1){
                return "明天";
            }else if($days<0){
                return abs($days)."天前";
            }else{
                return abs($days)."天后";
            }
        }else{
            $timestamp = strtotime(date("Y-m-d"));
            return date("Y-m-d",strtotime("$days days",$timestamp));
        }
    }

}