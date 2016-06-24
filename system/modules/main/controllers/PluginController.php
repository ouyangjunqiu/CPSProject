<?php
/**
 * @file PluginController.php
 * @author ouyangjunqiu
 * @version Created by 16/5/6 11:33
 */

namespace application\modules\main\controllers;


use application\modules\main\model\Plugin;
use cloud\core\controllers\Controller;

class PluginController extends Controller
{

    public function actionSet(){
        $version = $_REQUEST["version"];
        $file_md5 = $_REQUEST["file_md5"];
        $model = new Plugin();
        $model->setAttributes(array(
            "version"=>$version,
            "file_md5"=>$file_md5
        ));

        if($model->save()){
            $this->renderJson(array("isSuccess"=>true,"data"=>$model));
        }else{
            $this->renderJson(array("isSuccess"=>false,"msg"=>$model->getErrors()));
        }
    }

    public function actionUpload(){
       $this->render("upload");
    }

}