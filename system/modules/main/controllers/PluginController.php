<?php
/**
 * @file PluginController.php
 * @author ouyangjunqiu
 * @version Created by 16/5/6 11:33
 */

namespace application\modules\main\controllers;


use application\modules\main\model\Plugin;
use application\modules\main\model\PluginInstallLog;
use cloud\core\controllers\Controller;
use cloud\core\utils\Env;

class PluginController extends Controller
{

    public function actionLog(){
        $username = Env::getRequest('username');
        $version = Env::getRequest('version');
        $logdate = date("Y-m-d");

        PluginInstallLog::model()->deleteAll("logdate=? AND username=?",array($logdate,$username));
        $model = new PluginInstallLog();
        $model->setAttributes(array(
            "logdate"=>$logdate,
            "version"=>$version,
            "username"=>$username
        ));
        if($model->save()){
            $this->renderJson(array("isSuccess"=>true,"data"=>$model));
        }else{
            $this->renderJson(array("isSuccess"=>false,"msg"=>$model->getErrors()));
        }
    }

    public function actionVersion(){
        $version = Plugin::fetchVersion();
        $url = $this->createAbsoluteUrl("/file/default/down",array("md5"=>$version["file_md5"]));

        $url = urlencode($url);

        $xml = <<<EOT
<?xml version='1.0' encoding='UTF-8'?>
<gupdate xmlns='http://www.google.com/update2/response' protocol='2.0'>
  <app appid='chdimiojgajacjlbfndcbigklbhjbbja'>
    <updatecheck codebase='{$url}' version='{$version["version"]}' />
  </app>
</gupdate>
EOT;
        header("Content-type: text/xml;charset=UTF-8");
        echo $xml;

    }

}