<?php
/**
 * @file RptController.php
 * @author ouyangjunqiu
 * @version Created by 2016/9/22 09:57
 */

namespace application\modules\tool\controllers;

use application\modules\tool\model\DataRptTask;
use cloud\core\controllers\Controller;
use cloud\core\utils\Env;

class DataController extends Controller
{
    public function actionIndex(){

        $dataType = array(
            1=>"钻展定向报表",
            2=>"钻展创意报表",
            3=>"钻展资源位报表",
            4=>"钻展定向资源位",
            5=>"类目-店铺-人群类型报表",
            6=>"定向名-类目",
            7=>"类目-人群类型报表",
            8=>"类目-定向报表",
            9=>"类目-店铺-定向渠道报表",
            10=>"类目-定向渠道",
            11=>"类目-店铺-站内/站外报表",
            12=>"类目-站内/站外报表",
            13=>"类目-资源位",
            14=>"类目-店铺-消耗/营收比例",
            15=>"类目-消耗/营收比例",
            16=>"类目-店铺-定向类型 点击单价层次",
            17=>"类目-店铺-资源位类别 点击单价层次",
            18=>"类目-店铺-资源位类别 展现成本层次",
            19=>"类目-资源位类别 点击单价层次",
            20=>"类目-资源位类别 展现成本层次",
            21=>"类目-资源位类别",
            22=>"创意报表 尺寸-文案风格-主文案",
            23=>"创意报表 主文案-尺寸",
            24=>"创意报表 文案风格-尺寸",
            25=>"尺寸-创意报表"
        );


        $this->render("index",array("query"=>array("beginDate"=>date("Y-m-d",strtotime("-18 days")),"endDate"=>date("Y-m-d",strtotime("-3 days")),"dataType"=>$dataType)));
    }

    public function actionDown(){
        $param["TableType"] = Env::getRequest("datatype");
        $param["Begin_Time"] = Env::getRequest("begin_time");
        $param["End_Time"] = Env::getRequest("end_time");
        $categoryname = Env::getRequest("categoryname");
        if(!empty($categoryname)){
            $param["Categoryname"] = explode(",",$categoryname);
        }
        $shopname = Env::getRequest("Shopname");
        if(!empty($shopname)) {
            $param["Shopname"] = explode(",",$shopname);
        }

        $param["TaskId"] = time().rand(1,999999);

        $pakage[] = $param;

        $model = new DataRptTask();
        $model->setAttributes(array(
            "logdate"=>date("Y-m-d"),
            "taskid"=>$param["TaskId"],
            "params"=>json_encode($pakage),
            "code"=>0,
            "result"=>""
        ));

        if(!$model->save()){
            $this->renderJson(array("isSuccess"=>false,"msg"=>$model->getErrors()));
        }else{
            $this->renderJson(array("isSuccess"=>true,"data"=>$model));
        }

    }

    public function actionGetfile(){
        $target = Env::getRequest("file");
        $file = file_get_contents($target);
        header("Content-Type: application/octet-stream");//告诉浏览器输出内容类型，必须
        header('Content-Encoding: none');//内容不加密，gzip等，可选
        header("Content-Transfer-Encoding: binary" );//文件传输方式是二进制，可选

        header('Content-Disposition: attachment; filename="' . date("Ymd") . '.xlsx"');
        echo $file;


    }

}