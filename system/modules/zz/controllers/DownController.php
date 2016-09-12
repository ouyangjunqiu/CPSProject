<?php
/**
 * Created by PhpStorm.
 * User: ouyangjunqiu
 * Date: 16/3/29
 * Time: 上午11:11
 */

namespace application\modules\zz\controllers;


use application\modules\main\utils\ShopSearch;
use application\modules\zuanshi\model\ShopTradeRpt;
use application\modules\zz\model\AdvertiserRpt;
use cloud\core\controllers\Controller;
use cloud\core\utils\Env;
use cloud\core\utils\ExtRangeDate;
use cloud\core\utils\File;

class DownController extends Controller
{
    public function actionAdvertiserrpt(){
        $nick = Env::getSession("nick","","zuanshi.rpt.index");
        $rangeDate = ExtRangeDate::range(30);
        $beginDate = Env::getSession("begin_date",$rangeDate->startDate,"zuanshi.rpt.index");
        $endDate = Env::getSession("end_date",$rangeDate->endDate,"zuanshi.rpt.index");

        $rpts = AdvertiserRpt::fetchAllByNick($nick,$beginDate,$endDate,"click");
        $click3rpt = $rpts["click3"]["list"];
        $click7rpt = $rpts["click7"]["list"];
        $click15rpt = $rpts["click15"]["list"];

        $data[] = array(
            "日期",
            "展现",
            "点击",
            "点击率(%)",
            "消耗(元)",
            "点击单价(元)",
            "3天回报率",
            "7天回报率",
            "15天回报率",
            "3天转化金额(元)",
            "7天转化金额(元)",
            "15天转化金额(元)",
            "3天订单数",
            "7天订单数",
            "15天订单数",
            "3天加购物车数",
            "7天加购物车数",
            "15天加购物车数",
            "店铺收藏数",
            "宝贝收藏数",
            "访客数",
            "店铺收藏率(%)",
            "宝贝收藏率(%)",
            "客单价(元)",
            "支付转化率(%)"
        );

        foreach($click3rpt as $i=>$row){
            $data[] = array(
                $row["logDate"],
                $row["adPv"],
                $row["click"],
                $row["ctr"]*100,
                $row["charge"],
                $row["ecpc"],
                round($row["roi"],2),
                round($click7rpt[$i]["roi"],2),
                round($click15rpt[$i]["roi"],2),
                $row["alipayInshopAmt"],
                $click7rpt[$i]["alipayInshopAmt"],
                $click15rpt[$i]["alipayInshopAmt"],
                $row["alipayInShopNum"],
                $click7rpt[$i]["alipayInShopNum"],
                $click15rpt[$i]["alipayInShopNum"],
                isset($row["cartNum"])?$row["cartNum"]:"-",
                isset($click7rpt[$i]["cartNum"])?$click7rpt[$i]["cartNum"]:"-",
                isset($click15rpt[$i]["cartNum"])?$click15rpt[$i]["cartNum"]:"-",
                $row["dirShopColNum"],
                $row["inshopItemColNum"],
                $row["uv"],
                round(@($row["dirShopColNum"]/$row["uv"]*100),2),
                round(@($row["inshopItemColNum"]/$row["uv"]*100),2),
                round(@($click7rpt[$i]["alipayInshopAmt"]/$click7rpt[$i]["alipayInShopNum"]),2),
                round(@($click7rpt[$i]["alipayInShopNum"]/$click7rpt[$i]["uv"]*100),2)
            );
        }

        File::exportExcel("{$nick}-{$beginDate}至{$endDate}报表",$data);

    }

    public function actionSummary(){


        $defaultDate = ExtRangeDate::range(7);

        $startdate = Env::getSession("startdate",$defaultDate->startDate,"zuanshi.rpt.summary");
        $enddate = Env::getSession("enddate",$defaultDate->endDate,"zuanshi.rpt.summary");


        $shops = ShopSearch::openlist();

        foreach($shops["list"] as &$row){

            $row["rpt"] = AdvertiserRpt::fetchAllByNick($row["nick"],$startdate,$enddate,"click");

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
                "三天转化金额",
                "三天转化ROI",
                "七天转化金额",
                "七天转化ROI",
                "营业额"
            )
        );

        foreach($shops["list"] as $row){
            $data[] = array(
                $row["nick"],
                $row["shopcatname"],
                $row["pic"],
                $row["ztc_pic"],
                $row["zuanshi_pic"],
                $row["bigdata_pic"],
                empty($row["rpt"]["click3"]["total"])?"-":@$row["rpt"]["click3"]["total"]["adPv"],
                empty($row["rpt"]["click3"]["total"])?"-":@$row["rpt"]["click3"]["total"]["click"],
                empty($row["rpt"]["click3"]["total"])?"-":@$row["rpt"]["click3"]["total"]["charge"],
                empty($row["rpt"]["click3"]["total"])?"-":@$row["rpt"]["click3"]["total"]["alipayInshopAmt"],
                empty($row["rpt"]["click3"]["total"])?"-":@$row["rpt"]["click3"]["total"]["roi"],
                empty($row["rpt"]["click7"]["total"])?"-":@$row["rpt"]["click7"]["total"]["alipayInshopAmt"],
                empty($row["rpt"]["click7"]["total"])?"-":@$row["rpt"]["click7"]["total"]["roi"],
                $row["tradeRpt"]["total_pay_amt"]
            );
        }

        File::exportExcel("钻展统计报表{$startdate}至{$enddate}",$data);
    }


}