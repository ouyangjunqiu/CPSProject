<?php
/**
 * Created by PhpStorm.
 * User: ouyangjunqiu
 * Date: 16/3/25
 * Time: 下午4:04
 */

namespace application\modules\zuanshi\controllers;


use application\modules\zuanshi\model\CampaignHourRptSource;
use cloud\core\controllers\Controller;
use cloud\core\utils\Env;
use application\modules\main\model\Shop;
use application\modules\zuanshi\model\AdvertiserHourRptSource;

class DashboardController extends Controller
{
    public function actionIndex(){
        $page = Env::getSession("page",1,"main.default.index");
        $pageSize = Env::getSession("page_size",PAGE_SIZE,"main.default.index");
        $q = Env::getSession("q","","main.default.index");

        $pic = Env::getSession("pic","","main.default.index");

        $criteria = new \CDbCriteria();
        $criteria->addCondition("status='0'");
        if(!empty($pic)) {
            $criteria->addCondition("(pic LIKE '%{$pic}%' OR zuanshi_pic LIKE '%{$pic}%' OR bigdata_pic LIKE '%{$pic}%' OR ztc_pic  LIKE '%{$pic}%')");
        }
        if(!empty($q)) {
            $criteria->addCondition("(shopcatname LIKE '%{$q}%' OR shoptype LIKE '%{$q}%' OR nick LIKE '%{$q}%' OR pic LIKE '%{$q}%' OR zuanshi_pic LIKE '%{$q}%' OR bigdata_pic LIKE '%{$q}%' OR ztc_pic  LIKE '%{$q}%')");
        }

        $count = Shop::model()->count($criteria);

        $criteria->offset = ($page-1)*$pageSize;
        $criteria->limit = $pageSize;

        $list = Shop::model()->fetchAll($criteria);

        $this->render("index",array(
            "list"=>$list,
            "pager"=>array(
                "count"=>$count,
                "page"=>$page,
                "page_size"=>$pageSize
            ),
            "query"=>array("q"=>$q,"pic"=>$pic)
        ));

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