<?php
/**
 * @file AboardpackageController.php
 * @author ouyangjunqiu
 * @version Created by 16/8/4 16:08
 */

namespace application\modules\zuanshi\controllers;


use application\modules\zuanshi\model\AboardPackage;
use cloud\core\controllers\Controller;
use cloud\core\utils\Env;

class AboardpackageController extends Controller
{
    public function actionSource(){

        $nick = Env::getRequest("nick");
        $data = Env::getRequest("data");
        $list = \CJSON::decode($data);
        if(is_array($list)){
            foreach($list as $row){
                $id = $row["adboard"]["adboardId"];
                if(!empty($id)){
                    $attr = array(
                        "nick"=>$nick,
                        "adboardId"=>$id,
                        "logdate"=>date("Y-m-d"),
                        "data"=>\CJSON::encode($row)
                    );
                    AboardPackage::model()->deleteAll("adboardId=?",array($id));

                    $model = new AboardPackage();
                    $model->setAttributes($attr);
                    $model->save();
                }
            }
        }

        return $this->renderJson(array("isSuccess"=>true));

    }

}