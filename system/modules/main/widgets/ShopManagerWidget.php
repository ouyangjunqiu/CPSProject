<?php
namespace application\modules\main\widgets;
use application\modules\main\model\ShopBudget;
use application\modules\main\model\ShopContact;
use application\modules\ztc\model\CustWeekRpt;
use application\modules\zz\model\AdvertiserWeekRpt;
use CWidget;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015-12-19
 * Time: 11:01
 */
class ShopManagerWidget extends CWidget
{
    public $shop;

    public function run(){
        $contact = ShopContact::fetchByNick($this->shop["nick"]);
        $row = array_merge($this->shop,$contact);
        $budget = ShopBudget::model()->fetch("nick=?",array($this->shop["nick"]));
        if(empty($budget)){
            $budget = array(
                "ztc_budget"=>0,
                "zuanshi_budget"=>0,
                "tags"=>""
            );
        }
        $row = array_merge($row,$budget);

        $date = date("Y-m-d");
        $w  = date('w',strtotime($date));
        $now_start = date('Y-m-d',strtotime("$date -".($w ? $w - 1 : 6).' days')); //获取本周开始日期，如果$w是0，则表示周日，减去 6 天

        $begindate = date('Y-m-d',strtotime("$now_start -7 days"));  //上周开始日期
        $enddate = date('Y-m-d',strtotime("$begindate + 6 days"));  //上周结束日期

        $source = AdvertiserWeekRpt::model()->fetch("begindate=? AND enddate=? AND nick=?",array($begindate,$enddate,$this->shop["nick"]));

        $rpt = array();
        if(!empty($source) && isset($source["data"])){
            $rpt = \CJSON::decode($source["data"]);
        }

        $ztcSource = CustWeekRpt::model()->fetch("begindate=? AND enddate=? AND nick=?",array($begindate,$enddate,$this->shop["nick"]));

        $ztc = array();
        if(!empty($ztcSource) && isset($ztcSource["data"])){
            $ztc = \CJSON::decode($ztcSource["data"]);
        }
        return $this->render("application.modules.main.widgets.views.shop",array("row"=>$row,"rpt"=>$rpt,"ztc"=>$ztc));
    }

}