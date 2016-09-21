<?php
/**
 * @file CustrptController.php
 * @author ouyangjunqiu
 * @version Created by 16/9/20 17:50
 */

namespace application\modules\ztc\controllers;


use application\modules\ztc\model\CustRpt;
use application\modules\ztc\model\CustRptSource;
use cloud\core\controllers\Controller;
use cloud\core\utils\Env;

class CustrptController extends Controller
{
    public function actionSource()
    {
        $logdate = date("Y-m-d");
        $nick = Env::getRequest("nick");
        $effectType = Env::getRequest("effectType");
        $effect = Env::getRequest("effect");
        $data = Env::getRequest("data");
        $effectType = ($effectType == "click" ? "click" : "impression");
        CustRptSource::model()->deleteAll("logdate=? AND nick=? AND effectType=? AND effect=?", array($logdate, $nick, $effectType, $effect));
        $model = new CustRptSource();
        $model->setAttributes(array(
            "logdate" => $logdate,
            "nick" => $nick,
            "effectType" => $effectType,
            "effect" => $effect,
            "data" => $data
        ));

        if ($model->save()) {

            $rpts = json_decode($data, true);
            foreach ($rpts as $rpt) {
                if (!empty($rpt["date"])) {
                    CustRpt::model()->deleteAll("logdate=? AND nick=? AND effectType=? AND effect=?", array($rpt["date"], $nick, $effectType, $effect));
                    $listModel = new CustRpt();
                    $listModel->setAttributes(array(
                        "logdate" => $rpt["date"],
                        "nick" => $nick,
                        "effectType" => $effectType,
                        "effect" => $effect,
                        "data" => \CJSON::encode($rpt)
                    ));
                    $listModel->save();
                }

            }
            $this->renderJson(array("isSuccess" => true, "data" => $model));
        } else {
            $this->renderJson(array("isSuccess" => false, "msg" => $model->getErrors()));
        }
    }

    public function actionHasget(){
        $nick = Env::getRequest("nick");
        $hasget = CustRptSource::model()->exists("log_date=? AND nick=?",array(date("Y-m-d"),$nick));
        $this->renderJson(array("isSuccess" => true,"hasget"=>$hasget));

    }


}