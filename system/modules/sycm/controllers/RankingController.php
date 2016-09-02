<?php
/**
 * @file RankingController.php
 * @author ouyangjunqiu
 * @version Created by 16/9/2 15:52
 */

namespace application\modules\sycm\controllers;

use application\modules\main\model\ShopRanking;
use cloud\core\controllers\Controller;
use cloud\core\utils\Env;

class RankingController extends Controller
{

    public function actionSource(){
        $nick = Env::getRequest("nick");
        $data = Env::getRequest("data");
        $logdate = date("Y-m-d");

        ShopRanking::model()->deleteAll("logdate=? AND nick=?",array($logdate,$nick));

        $model = new ShopRanking();
        $model->setAttributes(array(
            "nick"=>$nick,
            "data"=>$data,
            "logdate"=>$logdate
        ));
        if($model->save()){
            $this->renderJson(array("isSuccess"=>true,"data"=>$model));
        }else{
            $this->renderJson(array("isSuccess"=>false,"msg"=>$model->getErrors()));
        }

    }
}