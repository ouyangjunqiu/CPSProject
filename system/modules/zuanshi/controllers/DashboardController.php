<?php
/**
 * Created by PhpStorm.
 * User: ouyangjunqiu
 * Date: 16/3/25
 * Time: 下午4:04
 */

namespace application\modules\zuanshi\controllers;


use application\modules\main\utils\ShopSearch;
use application\modules\zuanshi\model\CampaignHourRptSource;
use cloud\core\controllers\Controller;
use cloud\core\utils\Env;
use application\modules\zuanshi\model\AdvertiserHourRptSource;

class DashboardController extends Controller
{
    public function actionIndex(){
        //$data = ShopSearch::openlist();
        //$this->render("index",$data);
        $this->redirect(array("/zz/advertiserhour/index"));
    }

    public function actionGetbynick(){
        $nick = Env::getQueryDefault("nick","");

        $rpt = AdvertiserHourRptSource::fetchSummaryByNick($nick);
        if(empty($rpt)){
            $this->renderJson(array("isSuccess"=>false,"data"=>array("list"=>array())));
            return;
        }

        $this->renderJson(array("isSuccess"=>true,"data"=>$rpt));
        return;

    }

    public function actionGetcampaignbudgetwarning(){
        $nick = Env::getQueryDefault("nick","");

        $rpt = CampaignHourRptSource::fetchBudgetWarningCount($nick);

        if(empty($rpt)){
            $this->renderJson(array("isSuccess"=>false,"data"=>array("list"=>array())));
            return;
        }

        $this->renderJson(array("isSuccess"=>true,"data"=>$rpt));
        return;
    }

}