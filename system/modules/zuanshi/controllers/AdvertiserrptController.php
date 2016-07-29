<?php
/**
 * @file AdvertiserrptController.php
 * @author ouyangjunqiu
 * @version Created by 16/7/28 15:46
 */

namespace application\modules\zuanshi\controllers;


use application\modules\main\model\Shop;
use application\modules\zuanshi\model\AdvertiserRpt;
use application\modules\zuanshi\model\AdvertiserRptSource;
use cloud\core\controllers\Controller;
use cloud\core\utils\Env;

class AdvertiserrptController extends Controller
{
    public function actionSource(){
        $logdate = date("Y-m-d");
        $nick = Env::getRequest("nick");
        $effectType = Env::getRequest("effectType");
        $effect = Env::getRequest("effect");
        $data = Env::getRequest("data");
        $effectType = ($effectType=="click"?"click":"impression");
        AdvertiserRptSource::model()->deleteAll("logdate=? AND nick=? AND effectType=? AND effect=?",array($logdate,$nick,$effectType,$effect));
        $model = new AdvertiserRptSource();
        $model->setAttributes(array(
            "logdate" => $logdate,
            "nick" => $nick,
            "effectType" => $effectType,
            "effect" => $effect,
            "data" => $data
        ));

        if($model->save()) {

            $rpts = json_decode($data, true);
            foreach($rpts as $rpt){
                if(!empty($rpt["logDate"])){
                    AdvertiserRpt::model()->deleteAll("logdate=? AND nick=? AND effectType=? AND effect=?",array($rpt["logDate"],$nick,$effectType,$effect));
                    $listModel = new AdvertiserRpt();
                    $listModel->setAttributes(array(
                        "logdate" => $rpt["logDate"],
                        "nick" => $nick,
                        "effectType" => $effectType,
                        "effect" => $effect,
                        "data" => \CJSON::encode($rpt)
                    ));
                    $listModel->save();
                }

            }
            $this->renderJson(array("isSuccess"=>true,"data"=>$model));
        }else{
            $this->renderJson(array("isSuccess"=>false,"msg"=>$model->getErrors()));
        }

    }

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
        $data = AdvertiserRptSource::fetchAllByNick($nick);
        $this->renderJson(array("isSuccess"=>true,"data"=>$data));
    }

}