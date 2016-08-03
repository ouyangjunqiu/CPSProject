<?php
/**
 * Created by PhpStorm.
 * User: ouyangjunqiu
 * Date: 16/3/30
 * Time: 下午5:42
 */

namespace application\modules\zz\model;


use application\modules\main\model\ShopBudget;
use cloud\core\model\Model;
use cloud\core\utils\Math;

class AdvertiserHourRptSource extends Model
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return AdvertiserHourRptSource the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{zuanshi_advertiser_h_source_v2}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(

            array('nick,logdate,loghour,account_data,yesterday_data,data', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('nick,logdate,loghour,account_data,yesterday_data,data', 'safe', 'on'=>'search'),
        );
    }

    public static function fetchSummaryByNick($nick){

        $rpt = self::model()->fetch("logdate=? AND nick=?",array(date("Y-m-d"),$nick));
        if(empty($rpt)){
            return array();
        }

        $plan = ShopBudget::model()->fetch("nick=?", array($nick));
        $accountData = json_decode($rpt["account_data"],true);
        $accountData["zuanshi_budget"] = empty($plan)?0:@$plan["zuanshi_budget"];
        $yesterdayData = json_decode($rpt["yesterday_data"],true);
        $todayData = json_decode($rpt["data"],true);

        $accountData["warning"] = false;
        if($accountData["balance"]<$accountData["dayBudget"]||$accountData["balance"]<300||($accountData["zuanshi_budget"]>0 && $accountData["balance"]<$accountData["zuanshi_budget"])){
            $accountData["warning"] = true;
        }

        $curHour = 0;
        if(isset($todayData["list"])){
            foreach($todayData["list"] as $r){
                if($r["hourId"]>$curHour)
                    $curHour = $r["hourId"];
            }
        }

        $todayTotal = $todayData["total"];
        $todayTotal["ctrStr"] = round($todayTotal["ctr"]*100,2);

        $yesterhourData = array(
            "charge" => 0,
            "click" =>0,
            "adPv" => 0,

        );
        if(isset($yesterdayData["list"])){
            foreach($yesterdayData["list"] as $r){
                if($r["hourId"]<=$curHour) {
                    $yesterhourData["charge"]+=$r["charge"];
                    $yesterhourData["click"]+=$r["click"];
                    $yesterhourData["adPv"]+=$r["adPv"];
                }
            }
        }

        $yesterhourData["cpc"] = round(@($yesterhourData["charge"]/$yesterhourData["click"]),2);
        $yesterhourData["ctr"] = round(@($yesterhourData["click"]/$yesterhourData["adPv"]),4);

        $yesterhourData["ctrStr"] = round($yesterhourData["ctr"]*100,2);

        $yesterhourData["chargeGrowth"] = Math::growth($yesterhourData["charge"],$todayTotal["charge"]);
        $yesterhourData["cpcGrowth"] = Math::growth($yesterhourData["cpc"],$todayTotal["cpc"]);
        $yesterhourData["ctrGrowth"] = Math::growth($yesterhourData["ctr"],$todayTotal["ctr"]);

        $yesterdayTotal = $yesterdayData["total"];
        if($accountData["zuanshi_budget"]>0){
            $yesterdayTotal["chargeRate"] = round(@($todayTotal["charge"]/$accountData["zuanshi_budget"]*100),2);
        }else{
            $yesterdayTotal["chargeRate"] = round(@($todayTotal["charge"]/$accountData["dayBudget"]*100),2);
        }

        $yesterdayTotal["ctrStr"] = round($yesterdayTotal["ctr"]*100,2);
        $yesterdayTotal["cpcGrowth"] = Math::growth($yesterdayTotal["cpc"],$todayTotal["cpc"]);
        $yesterdayTotal["ctrGrowth"] = Math::growth($yesterdayTotal["ctr"],$todayTotal["ctr"]);

        return array(
            "loghour" => $rpt["loghour"],
            "cur_hour" => $curHour,
            "account"=> $accountData,
            "today" => $todayTotal,
            "yesterday" => $yesterdayTotal,
            "cur_yesterday" => $yesterhourData
        );
    }

//    public static function fetchListByNick($nick){
//        $hour = date("H");
//        $hour = (int)$hour;
//        $logsection = 1;
//        if($hour>=14){
//            $logsection = 2;
//        }
//
//        $rpt = self::model()->fetch("logdate=? AND logsection=? AND nick=?",array(date("Y-m-d"),$logsection,$nick));
//        if(empty($rpt)){
//            return array();
//        }
//
//        $accountData = json_decode($rpt["accountdata"],true);
//        $yesterdayData = json_decode($rpt["yesterdaydata"],true);
//        $todayData = json_decode($rpt["todaydata"],true);
//
//        $curHour = 0;
//        $rptToday = array();
//        if(isset($todayData["rptAdvertiserHourList"])){
//            foreach($todayData["rptAdvertiserHourList"] as $r){
//                if($r["hourId"]>$curHour) $curHour = $r["hourId"];
//                $rptToday[$r["hourId"]] = $r;
//            }
//        }
//
//        $rptYesterday = array();
//        if(isset($yesterdayData["rptAdvertiserHourList"])){
//            foreach($yesterdayData["rptAdvertiserHourList"] as $r){
//                $rptYesterday[$r["hourId"]] = $r;
//            }
//        }
//
//        return array(
//            "loghour" => $rpt["loghour"],
//            "cur_hour" => $curHour,
//            "account"=> $accountData,
//            "today" => $todayData,
//            "yesterday" => $yesterdayData,
//            "today_rpt_list" => $rptToday,
//            "yesterday_rpt_list" => $rptYesterday
//        );
//    }

}