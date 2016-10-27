<?php
/**
 * @file RptController.php
 * @author ouyangjunqiu
 * @version Created by 2016/9/22 09:57
 */

namespace application\modules\tool\controllers;


use application\modules\main\utils\StringUtil;
use cloud\core\controllers\Controller;
use cloud\core\utils\Env;
use cloud\core\utils\ExtRangeDate;

class DataController extends Controller
{
    public function actionIndex(){

        $dataType = array(
            "钻展定向报表",
            "钻展创意报表",
            "钻展资源位报表",
            "钻展定向资源位",
            "类目-店铺-人群类型报表",
            "定向名-类目",
            "类目-人群类型报表",
            "类目-定向报表",
            "类目-店铺-定向渠道报表",
            "类目-定向渠道",
            "类目-店铺-站内/站外报表",
            "类目-站内/站外报表",
            "类目-资源位",
            "类目-店铺-消耗/营收比例",
            "类目-消耗/营收比例",
            "类目-店铺-定向类型 点击单价层次",
            "类目-店铺-资源位类别 点击单价层次",
            "类目-店铺-资源位类别 展现成本层次",
            "类目-资源位类别 点击单价层次",
            "类目-资源位类别 展现成本层次",
            "类目-资源位类别",
            "创意报表 尺寸-文案风格-主文案",
            "创意报表 主文案-尺寸",
            "创意报表 文案风格-尺寸",
            "尺寸-创意报表"
        );


        $this->render("index",array("query"=>array("beginDate"=>date("Y-m-d",strtotime("-18 days")),"endDate"=>date("Y-m-d",strtotime("-3 days")),"dataType"=>$dataType)));
    }

    public function actionDown(){
        $param["TableType"] = Env::getRequest("dataType");
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

        $client = new swoole_client(SWOOLE_SOCK_TCP);
        if (!$client->connect('127.0.0.1', 55555, -1))
        {
            $this->renderJson(array("msg"=>"connect failed. Error: {$client->errCode}\n"));
        }
        $client->send(json_encode($param));
        echo $client->recv();
        $client->close();

    }

}