<?php
/**
 * @file RptController.php
 * @author ouyangjunqiu
 * @version Created by 2016/9/22 09:57
 */

namespace application\modules\tool\controllers;


use cloud\core\controllers\Controller;
use cloud\core\utils\Env;
use cloud\core\utils\ExtRangeDate;

class RptController extends Controller
{
    public function actionIndex(){
        $nick = Env::getQueryDefault("nick","");
        $rangeDate = ExtRangeDate::range(30);
        $beginDate = Env::getQueryDefault("begin_date",$rangeDate->startDate);
        $endDate = Env::getQueryDefault("end_date",$rangeDate->endDate);
        $dateList = array();
        for($i = strtotime($beginDate);$i<=strtotime($endDate);$i = strtotime("+1 days",$i)){
            $dateList[] = date("Ymd",$i);
        }

        $this->render("index",array("query"=>array("nick"=>$nick,"begin_date"=>$beginDate,"end_date"=>$endDate,"date_list"=>$dateList)));
    }

}