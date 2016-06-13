<?php
namespace application\modules\dmp\controllers;
use cloud\core\controllers\Controller;
use cloud\core\utils\Env;
use application\modules\dmp\model\AccountRptSource;
use application\modules\main\model\Shop;


class RptController extends Controller
{

    public function actionSource(){
        $nick = Env::getRequest("nick");
        $userinfo = Env::getRequest("userinfo");
        $rpts = Env::getRequest("rpts");

        if(empty($rpts))
            $this->renderJson(array("isSuccess"=>false,"msg"=>"参数错误"));

        $model = new AccountRptSource();
        $model->setIsNewRecord(true);
        $model->setAttributes(array("nick"=>trim($nick),"userinfo"=>$userinfo,"rpts"=>$rpts,"date"=>date("Y-m-d")));
        if($model->save()){

//            $rpts = json_decode($rpts,true);
//            if(isset($rpts["data"]["rptAdvertiserDayList"]) && !empty($rpts["data"]["rptAdvertiserDayList"])){
//                foreach($rpts["data"]["rptAdvertiserDayList"] as $rpt){
//                    $date = $rpt["logDate"];
//                    AccountRpt::model()->deleteAll("log_date=? AND nick=?",array($date,$rpt["advertiserName"]));
//
//                    $listModel = new AccountRpt();
//                    $listModel->setAttributes(array(
//                        "advertiser_id"=>$rpt["advertiserId"],
//                        "nick"=> $rpt["advertiserName"],
//                        "ad_pv"=> $rpt["adPv"],
//                        "charge"=> $rpt["charge"],
//                        "click"=> $rpt["click"],
//                        "ctr"=> $rpt["ctr"],
//                        "log_date"=> $rpt["logDate"],
//                        "ecpc"=> $rpt["ecpc"],
//                        "ecpm"=> $rpt["ecpm"],
//                        "roi"=> $rpt["roi"],
//                        "roi7"=> $rpt["roi7"],
//                        "roi15"=> $rpt["roi15"],
//                        "extra"=>json_encode($rpt)
//                    ));
//                    $listModel->save();
//                }
//            }
            $this->renderJson(array("isSuccess"=>true,"data"=>$model));
        }else{
            $this->renderJson(array("isSuccess"=>false,"msg"=>$model->getErrors()));
        }
    }

    public function actionIndex(){

        $page = Env::getRequestWithSessionDefault("page",1,"main.default.index.page");
        $pageSize = Env::getRequestWithSessionDefault("page_size",20,"main.default.index.pagesize");
        $nick = Env::getRequestWithSessionDefault("nick","","main.default.index.nick");
        $pic = Env::getRequestWithSessionDefault("pic","","main.default.index.pic");

        $criteria = new \CDbCriteria();
        $criteria->addCondition("status='0'");
        if(!empty($nick)) {
            $criteria->addSearchCondition("nick",$nick);
        }
        if(!empty($pic)) {
            $criteria->addCondition("(zuanshi_pic LIKE '%{$pic}%' OR bigdata_pic LIKE '%{$pic}%' OR ztc_pic  LIKE '%{$pic}%')");
        }

        $count = Shop::model()->count($criteria);

        $criteria->offset = ($page-1)*$pageSize;
        $criteria->limit = $pageSize;

        $list = Shop::model()->fetchAll($criteria);
        $date = date("Y-m-d");
        foreach($list as &$row){
            $row["rpt"] = AccountRptSource::model()->fetch("nick='{$row["nick"]}' AND date='{$date}'");
//			$row["cases"] = ShopCase::model()->fetchAll("nick='{$row["nick"]}'");

        }


        $this->render("index",array("list"=>$list,"pager"=>array("count"=>$count,"page"=>$page,"page_size"=>$pageSize),"query"=>array("nick"=>$nick,"pic"=>$pic)));

    }


    public function actionHasget(){
        $nick = Env::getRequest("nick");
        $nick = trim($nick);
        $date = date("Y-m-d");
        $exists = AccountRptSource::model()->exists("nick='$nick' AND date='{$date}'");
        $this->renderJson(array("isSuccess"=>true,"data"=>array("hasget"=>$exists)));
    }


}