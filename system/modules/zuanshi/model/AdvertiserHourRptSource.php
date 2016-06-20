<?php
/**
 * Created by PhpStorm.
 * User: ouyangjunqiu
 * Date: 16/3/30
 * Time: 下午5:42
 */

namespace application\modules\zuanshi\model;


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
        return '{{zuanshi_advertiser_h_rpt_source}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(

            array('nick,logsection,logdate,loghour,accountdata,yesterdaydata,todaydata', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('nick,logsection,logdate,loghour,accountdata,yesterdaydata,todaydata', 'safe', 'on'=>'search'),
        );
    }

    public static function fetchSummaryByNick($nick){
        $hour = date("H");
        $hour = (int)$hour;
        $logsection = 1;
        if($hour>=14){
            $logsection = 2;
        }

        $rpt = self::model()->fetch("logdate=? AND logsection=? AND nick=?",array(date("Y-m-d"),$logsection,$nick));
        if(empty($rpt)){
            return array();
        }

        $plan = ShopBudget::model()->fetch("nick=?", array($nick));
        $accountData = json_decode($rpt["accountdata"],true);
        $accountData["zuanshi_budget"] = empty($plan)?0:@$plan["zuanshi_budget"];
        $yesterdayData = json_decode($rpt["yesterdaydata"],true);
        $todayData = json_decode($rpt["todaydata"],true);

        $accountData["warning"] = false;
        if($accountData["balance"]<$accountData["dayBudget"]||$accountData["balance"]<300||($accountData["zuanshi_budget"]>0 && $accountData["balance"]<$accountData["zuanshi_budget"])){
            $accountData["warning"] = true;
        }

        $curHour = 0;
        if(isset($todayData["rptAdvertiserHourList"])){
            foreach($todayData["rptAdvertiserHourList"] as $r){
                if($r["hourId"]>$curHour) $curHour = $r["hourId"];
            }
        }

        $todayData["ctrStr"] = round($todayData["ctr"]*100,2);

        $yesterhourData = array(
            "totalCharge" => 0,
            "totalClick" =>0,
            "totalPv" => 0,

        );
        if(isset($yesterdayData["rptAdvertiserHourList"])){
            foreach($yesterdayData["rptAdvertiserHourList"] as $r){
                if($r["hourId"]<=$curHour) {
                    $yesterhourData["totalCharge"]+=$r["charge"];
                    $yesterhourData["totalClick"]+=$r["click"];
                    $yesterhourData["totalPv"]+=$r["adPv"];
                }
            }
        }

        $yesterhourData["cpc"] = round(@($yesterhourData["totalCharge"]/$yesterhourData["totalClick"]),2);
        $yesterhourData["ctr"] = round(@($yesterhourData["totalClick"]/$yesterhourData["totalPv"]),4);

        $yesterhourData["ctrStr"] = round($yesterhourData["ctr"]*100,2);

        $yesterhourData["chargeGrowth"] = Math::growth($yesterhourData["totalCharge"],$todayData["totalCharge"]);
        $yesterhourData["cpcGrowth"] = Math::growth($yesterhourData["cpc"],$todayData["cpc"]);
        $yesterhourData["ctrGrowth"] = Math::growth($yesterhourData["ctr"],$todayData["ctr"]);

        if($accountData["zuanshi_budget"]>0){
            $yesterdayData["chargeRate"] = round(@($todayData["totalCharge"]/$accountData["zuanshi_budget"]*100),2);
        }else{
            $yesterdayData["chargeRate"] = round(@($todayData["totalCharge"]/$accountData["dayBudget"]*100),2);
        }

        $yesterdayData["ctrStr"] = round($yesterdayData["ctr"]*100,2);
        $yesterdayData["cpcGrowth"] = Math::growth($yesterdayData["cpc"],$todayData["cpc"]);
        $yesterdayData["ctrGrowth"] = Math::growth($yesterdayData["ctr"],$todayData["ctr"]);

        return array(
            "loghour" => $rpt["loghour"],
            "cur_hour" => $curHour,
            "account"=> $accountData,
            "today" => $todayData,
            "yesterday" => $yesterdayData,
            "cur_yesterday" => $yesterhourData
        );
    }

    public static function fetchListByNick($nick){
        $hour = date("H");
        $hour = (int)$hour;
        $logsection = 1;
        if($hour>=14){
            $logsection = 2;
        }

        $rpt = self::model()->fetch("logdate=? AND logsection=? AND nick=?",array(date("Y-m-d"),$logsection,$nick));
        if(empty($rpt)){
            return array();
        }

        $accountData = json_decode($rpt["accountdata"],true);
        $yesterdayData = json_decode($rpt["yesterdaydata"],true);
        $todayData = json_decode($rpt["todaydata"],true);

        $curHour = 0;
        $rptToday = array();
        if(isset($todayData["rptAdvertiserHourList"])){
            foreach($todayData["rptAdvertiserHourList"] as $r){
                if($r["hourId"]>$curHour) $curHour = $r["hourId"];
                $rptToday[$r["hourId"]] = $r;
            }
        }

        $rptYesterday = array();
        if(isset($yesterdayData["rptAdvertiserHourList"])){
            foreach($yesterdayData["rptAdvertiserHourList"] as $r){
                $rptYesterday[$r["hourId"]] = $r;
            }
        }

        return array(
            "loghour" => $rpt["loghour"],
            "cur_hour" => $curHour,
            "account"=> $accountData,
            "today" => $todayData,
            "yesterday" => $yesterdayData,
            "today_rpt_list" => $rptToday,
            "yesterday_rpt_list" => $rptYesterday
        );
    }

}