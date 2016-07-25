<?php
/**
 * Created by PhpStorm.
 * User: ouyangjunqiu
 * Date: 16/3/29
 * Time: 上午11:11
 */

namespace application\modules\zuanshi\controllers;


use cloud\core\controllers\Controller;
use cloud\core\utils\Env;
use cloud\core\utils\ExtRangeDate;
use cloud\core\utils\File;
use application\modules\main\model\Shop;
use application\modules\zuanshi\model\AccountRpt;
use application\modules\zuanshi\model\AdboardRptSource;
use application\modules\zuanshi\model\ShopTradeRpt;

class DownController extends Controller
{
    public function actionMore(){
        $nick = Env::getSession("nick","","zuanshi.rpt.index");
        $rangeDate = ExtRangeDate::range(30);
        $beginDate = Env::getSession("begin_date",$rangeDate->startDate,"zuanshi.rpt.index");
        $endDate = Env::getSession("end_date",$rangeDate->endDate,"zuanshi.rpt.index");

        $list = AccountRpt::model()->fetchAll("log_date>=? AND log_date<=? AND nick=?",array($beginDate,$endDate,$nick));

        foreach($list as &$rpt){
            $extra = json_decode($rpt["extra"],true);
            $rpt["extra"] = $extra;
        }

        $data = array();

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

        foreach($list as $row){
            $extra = $row["extra"];
            $data[] = array(
                $row["log_date"],
                $row["ad_pv"],
                $row["click"],
                $row["ctr"]*100,
                $row["charge"],
                $row["ecpc"],
                $row["roi"],
                $row["roi7"],
                $row["roi15"],
                $row["roi"]*$row["charge"],
                $row["roi7"]*$row["charge"],
                $row["roi15"]*$row["charge"],
                $extra["alipayInShopNum"],
                $extra["alipayInShopNum7"],
                $extra["alipayInShopNum15"],
                isset($extra["cartNum3"])?$extra["cartNum3"]:"-",
                isset($extra["cartNum7"])?$extra["cartNum7"]:"-",
                isset($extra["cartNum15"])?$extra["cartNum15"]:"-",
                $extra["dirShopColNum"],
                $extra["inshopItemColNum"],
                $extra["clickUv"],
                round(@($extra["dirShopColNum"]/$extra["clickUv"]*100),2),
                round(@($extra["inshopItemColNum"]/$extra["clickUv"]*100),2),
                round(@($row["roi7"]*$row["charge"]/$extra["alipayInShopNum7"]),2),
                round(@($extra["alipayInShopNum7"]/$extra["clickUv"]*100),2)
            );
        }

        File::exportExcel("{$nick}-{$beginDate}至{$endDate}报表",$data);
    }

    public function actionSummary(){

        $q = Env::getSession("q","","main.default.index");
        $pic = Env::getSession("pic","","main.default.index");

        $defaultDate = ExtRangeDate::range(7);

        $startdate = Env::getSession("startdate",$defaultDate->startDate,"zuanshi.rpt.summary");
        $enddate = Env::getSession("enddate",$defaultDate->endDate,"zuanshi.rpt.summary");

        $criteria = new \CDbCriteria();
        $criteria->addCondition("status='0'");
        if(!empty($q)) {
            $criteria->addCondition("(shopcatname LIKE '%{$q}%' OR shoptype LIKE '%{$q}%' OR nick LIKE '%{$q}%' OR pic LIKE '%{$q}%' OR zuanshi_pic LIKE '%{$q}%' OR bigdata_pic LIKE '%{$q}%' OR ztc_pic  LIKE '%{$q}%')");
        }

        if(!empty($pic)) {
            $criteria->addCondition("(pic LIKE '%{$pic}%' OR zuanshi_pic LIKE '%{$pic}%' OR bigdata_pic LIKE '%{$pic}%' OR ztc_pic  LIKE '%{$pic}%')");
        }

        $list = Shop::model()->fetchAll($criteria);

        foreach($list as &$rpt){

            $rpt["rpt"] = AccountRpt::summaryByNick($startdate,$enddate,$rpt["nick"]);

            $rpt["tradeRpt"] = ShopTradeRpt::summaryByNick($startdate,$enddate,$rpt["shopname"]);
        }

        $data = array(
            array(
                "店铺名",
                "主营行业",
                "运营对接人",
                "直通车负责人",
                "钻展负责人",
                "大数据负责人",
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

        foreach($list as $row){
            $data[] = array(
                $row["nick"],
                $row["shopcatname"],
                $row["pic"],
                $row["ztc_pic"],
                $row["zuanshi_pic"],
                $row["bigdata_pic"],
                $row["rpt"]["ad_pv"],
                $row["rpt"]["click"],
                $row["rpt"]["charge"],
                $row["rpt"]["pay"],
                round(@($row["rpt"]["pay"]/$row["rpt"]["charge"]),2),
                $row["rpt"]["pay7"],
                round(@($row["rpt"]["pay7"]/$row["rpt"]["charge"]),2),
                $row["tradeRpt"]["total_pay_amt"]
            );
        }

        File::exportExcel("钻展统计报表{$startdate}至{$enddate}",$data);
    }

    public function actionAdboard(){
        $nick = Env::getQueryDefault("nick","");
        $data = array();

        $data[] = array(
            "创意编号",
            "创意名称",
            "创意链接",
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
            "店铺收藏数",
            "宝贝收藏数",
            "访客数",
            "店铺收藏率(%)",
            "宝贝收藏率(%)",
            "客单价(元)",
            "支付转化率(%)"
        );

        $list = AdboardRptSource::fetchAllSummaryByCache($nick);
        foreach($list as $row){
            $data[] = array(
                $row["adboardId"],
                $row["adboardName"],
                $row["imagePath"],
                $row["adPv"],
                $row["click"],
                $row["ctr"],
                $row["charge"],
                $row["cpc"],
                $row["roi"],
                $row["roi7"],
                $row["roi15"],
                $row["roi"]*$row["charge"],
                $row["roi7"]*$row["charge"],
                $row["roi15"]*$row["charge"],
                $row["alipayInShopNum"],
                $row["alipayInShopNum7"],
                $row["alipayInShopNum15"],
                $row["dirShopColNum"],
                $row["inshopItemColNum"],
                $row["clickUv"],
                round(@($row["dirShopColNum"]/$row["clickUv"]*100),2),
                round(@($row["inshopItemColNum"]/$row["clickUv"]*100),2),
                round(@($row["roi7"]*$row["charge"]/$row["alipayInShopNum7"]),2),
                round(@($row["alipayInShopNum7"]/$row["clickUv"]*100),2)
            );
        }
        File::exportExcel("{$nick}-创意分析报表",$data);

    }

}