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
        return preg_replace("/,+/",",",$str);
    }

}