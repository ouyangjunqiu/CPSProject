<?php
/**
 * Created by PhpStorm.
 * User: ouyangjunqiu
 * Date: 16/4/14
 * Time: 上午11:54
 */

namespace application\modules\zz\controllers;

use application\modules\zz\model\DestWeekRpt;
use cloud\core\controllers\Controller;
use cloud\core\utils\Env;
use cloud\core\utils\Sorter;

class DestrptController extends Controller
{
    public function actionWeek(){
        $nick = Env::getRequest("nick");
        $orderby = Env::getQueryDefault("orderby","charge");
        $date = Env::getQueryDefault("date",date("Y-m-d"));
        $destType = Env::getQueryDefault("destType",128);
        $w  = date('w',strtotime($date));
        $now_start = date('Y-m-d',strtotime("$date -".($w ? $w - 1 : 6).' days')); //获取本周开始日期，如果$w是0，则表示周日，减去 6 天

        $begindate = date('Y-m-d',strtotime("$now_start -7 days"));  //上周开始日期
        $enddate = date('Y-m-d',strtotime("$begindate + 6 days"));  //上周结束日期

        $nick = trim($nick);
        $source = DestWeekRpt::model()->fetch("begindate=? AND enddate=? AND nick=?",array($begindate,$enddate,$nick));
        if(!empty($source)) {
            $data = \CJSON::decode($source["data"]);

            $list = array();
            foreach($data as $row){
                if($row["destType"] == $destType){
                    $list[] =  $row;
                }
            }

            if(!empty($list) && !empty($orderby)) {
                Sorter::sort($list,$orderby);
            }

            if(count($list)>10){
                $list = array_slice($list,0,10);
            }

            $this->renderJson(array(
                "isSuccess"=>true,
                "data"=>$list,
                "query"=>array(
                    "nick"=>$nick,
                    "begindate"=>$begindate,
                    "enddate"=>$enddate,
                    "orderby"=>$orderby,
                    "destType"=>$destType
                )
            ));

        }else{
            $this->renderJson(array(
                "isSuccess"=>false,
                "data"=>array(),
                "query"=>array(
                    "nick"=>$nick,
                    "begindate"=>$begindate,
                    "enddate"=>$enddate,
                    "orderby"=>$orderby,
                    "destType"=>$destType
                )
            ));
        }

     }

}