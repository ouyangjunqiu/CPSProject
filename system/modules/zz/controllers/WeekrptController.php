<?php
/**
 * @file WeekrptController.php
 * @author ouyangjunqiu
 * @version Created by 16/8/22 15:22
 */

namespace application\modules\zz\controllers;


use cloud\core\controllers\Controller;
use cloud\core\utils\Env;

class WeekrptController extends Controller
{
    public function actionIndex(){
        $nick = Env::getSession("nick","","zuanshi.weekrpt.index");
        $orderby = Env::getSession("orderby","charge","zuanshi.weekrpt.index");
        $date = Env::getSession("date",date("Y-m-d"),"zuanshi.weekrpt.index");

        $w  = date('w',strtotime($date));
        $now_start = date('Y-m-d',strtotime("$date -".($w ? $w - 1 : 6).' days')); //获取本周开始日期，如果$w是0，则表示周日，减去 6 天

        $begindate = date('Y-m-d',strtotime("$now_start -7 days"));  //上周开始日期
        $enddate = date('Y-m-d',strtotime("$begindate + 6 days"));  //上周结束日期

        $nick = trim($nick);


        $this->render("index",array("query"=>array(
            "nick"=>$nick,
            "orderby"=>$orderby,
            "date"=>$date,
            "begindate"=>$begindate,
            "enddate"=>$enddate
        )));

    }

}