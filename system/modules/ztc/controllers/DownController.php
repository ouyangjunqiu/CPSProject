<?php
/**
 * Created by PhpStorm.
 * User: ouyangjunqiu
 * Date: 16/3/29
 * Time: 上午11:11
 */

namespace application\modules\ztc\controllers;


use application\modules\main\utils\ShopSearch;
use application\modules\ztc\model\CustRpt;
use application\modules\zuanshi\model\ShopTradeRpt;
use cloud\core\controllers\Controller;
use cloud\core\utils\Env;
use cloud\core\utils\ExtRangeDate;
use cloud\core\utils\File;

class DownController extends Controller
{

    public function actionSummary(){


        $defaultDate = ExtRangeDate::range(7);

        $startdate = Env::getSession("startdate",$defaultDate->startDate,"zuanshi.rpt.summary");
        $enddate = Env::getSession("enddate",$defaultDate->endDate,"zuanshi.rpt.summary");


        $list = ShopSearch::openAll();

        foreach($list as &$row){

            $row["rpt"] = CustRpt::fetchByNick($row["nick"],$startdate,$enddate,"click",15);

            $row["tradeRpt"] = ShopTradeRpt::summaryByNick($startdate,$enddate,$row["shopname"]);
        }


        $data = array(
            array(
                "店铺名",
                "主营行业",
                "运营顾问",
                "直通车顾问",
                "钻展顾问",
                "数据顾问",
                "展现",
                "点击",
                "消耗",
                "转化金额",
                "转化ROI",
                "全店营业额"
            )
        );

        foreach($list as $row){
            $data[] = array(
                $row["nick"],
                $row["shopcatname"],
                $row["pic"],
                $row["ztc_pic"],
                $row["zuanshi_pic"],
                $row["bigdata_pic"],
                empty($row["rpt"]["total"])?"-":@$row["rpt"]["total"]["impressions"],
                empty($row["rpt"]["total"])?"-":@$row["rpt"]["total"]["click"],
                empty($row["rpt"]["total"])?"-":@$row["rpt"]["total"]["cost"],
                empty($row["rpt"]["total"])?"-":@$row["rpt"]["total"]["pay"],
                empty($row["rpt"]["total"])?"-":@$row["rpt"]["total"]["roi"],
                $row["tradeRpt"]["total_pay_amt"]
            );
        }

        File::exportExcel("直通车统计报表{$startdate}至{$enddate}",$data);
    }


}