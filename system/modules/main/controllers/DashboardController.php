<?php
/**
 * 店铺总览
 */
namespace application\modules\main\controllers;

use cloud\core\controllers\Controller;
use application\modules\main\model\Shop;

class DashboardController extends Controller
{

    public function actionIndex(){
        $summary = Shop::summary();
        $detail["ztc"] = Shop::summaryByZtc();
        $detail["zuanshi"] = Shop::summaryByZuanshi();
        $this->render("index2",array("summary"=>$summary,"detail"=>$detail));

    }

//    public function actionIndex(){
//
//        $data["shoptotal"] = Shop::model()->count("status=?",array(0));
//        $data["stopshoptotal"] = Shop::model()->count("status=?",array(1));
//        $data["offshoptotal"] = Shop::model()->count("status=?",array(2));
//
//        $data["casetotal"] = ShopCase::summary();
//        $data["caseruntotal"] = ShopCaseRun::summaryAll();
//        $data["caseruntotal_ztc"] = ShopCaseRun::summaryZtc();
//        $data["caseruntotal_zuanshi"] = ShopCaseRun::summaryZuanshi();
//
//        $logs = Summary::model()->fetchAll("log_date>=? AND log_date<=?",array(date("Y-m-d",strtotime("-7 days")),date("Y-m-d",strtotime("-1 days"))));
//
//        $detail["ztc"] =  ShopCaseRun::detailZtc();
//        $detail["zuanshi"] =  ShopCaseRun::detailZuanshi();
//
//        $this->render("index",array("summary"=>$data,"detail"=>$detail,"logs"=>$logs));
//    }

}