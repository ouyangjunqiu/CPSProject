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

}