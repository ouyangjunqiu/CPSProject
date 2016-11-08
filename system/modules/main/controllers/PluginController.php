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
use cloud\core\utils\File;
use application\modules\file\model\File AS FileModel;
use cloud\core\utils\MimeType;

class PluginController extends Controller
{

    public function actionLog(){
        $username = Env::getRequest('username');
        $version = Env::getRequest('version');
        $logdate = date("Y-m-d");

        PluginInstallLog::model()->deleteAll("logdate<=? AND username=?",array($logdate,$username));
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

    public function actionFile(){
        $version = Plugin::fetchVersion();

        $attach = FileModel::model()->fetch("md5=?",array($version["file_md5"]));
        if(!empty($attach)){
            $file = File::readFile($attach["target"]);
            $mimeType = MimeType::get($attach["ext"]);
            header("Content-Type: $mimeType");//告诉浏览器输出内容类型，必须
            header('Content-Encoding: none');//内容不加密，gzip等，可选
            header("Content-Transfer-Encoding: binary" );//文件传输方式是二进制，可选
            header("Content-Length: ".$attach["size"]);//告诉浏览器文件大小，可选

            header('Content-Disposition: attachment; filename="' . $attach["name"] . '"');
            echo $file;
        }else{
            $this->error("你访问的文件不存在!",$this->createUrl("/main/default/index"));
            return;
        }
    }

    public function actionVersion(){
        $version = Plugin::fetchVersion();
        $url = $this->createAbsoluteUrl("/main/plugin/file");

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