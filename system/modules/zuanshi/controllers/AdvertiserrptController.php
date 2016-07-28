<?php
/**
 * @file AdvertiserrptController.php
 * @author ouyangjunqiu
 * @version Created by 16/7/28 15:46
 */

namespace application\modules\zuanshi\controllers;


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

}