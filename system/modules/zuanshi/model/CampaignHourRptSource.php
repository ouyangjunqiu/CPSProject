<?php
/**
 * Created by PhpStorm.
 * User: ouyangjunqiu
 * Date: 16/3/30
 * Time: 下午5:42
 */

namespace application\modules\zuanshi\model;


use cloud\core\model\Model;

class CampaignHourRptSource extends Model
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return CampaignHourRptSource the static model class
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
        return '{{zuanshi_campaign_h_rpt_source}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(

            array('nick,logsection,logdate,loghour,data,rptdata', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('nick,logsection,logdate,loghour,data,rptdata', 'safe', 'on'=>'search'),
        );
    }

    public static function fetchBudgetWarningCount($nick){
        $hour = date("H");
        $hour = (int)$hour;
        if($hour<=14){
            return array();
        }

        $rpt = self::model()->fetch("logdate=? AND logsection=? AND nick=?",array(date("Y-m-d"),2,$nick));
        if(empty($rpt)){
            return array();
        }

        $loghour = $rpt['loghour'];
        $data = json_decode($rpt["data"],true);
        $rptdata = json_decode($rpt["data"],true);

        if(empty($data)){
            return array();
        }

        $campaignRpts = array();
        foreach($rptdata as $rpt){
            $campaignRpts[$rpt["campaignId"]] = $rpt;
        }

        $result = array(
            "loghour"=>$loghour,
            "low"=>array("count"=>0,"list"=>array()),
            "max"=>array("count"=>0,"list"=>array())
        );
        $campaigns = array();
        foreach($data as $row){
            $campaigns[$row["campaignId"]] = $row;
            if(!empty($campaignRpts[$row["campaignId"]])){
                $rpt = $campaignRpts[$row["campaignId"]];
                $rate = @$rpt["charge"]/$row["dayBudget"];
                if($rate<0.5){
                    $result["low"]["count"]++;
                    $result["low"]["list"][] = array_merge($row,$rpt);
                }else if($rate>0.8){
                    $result["max"]["count"]++;
                    $result["max"]["list"][] = array_merge($row,$rpt);
                }
            }
        }
        return $result;
    }

    public static function fetchExpiredWarningCount($nick){
        $hour = date("H");
        $hour = (int)$hour;
        if($hour>14){
            return array();
        }

        $rpt = self::model()->fetch("logdate=? AND logsection=? AND nick=?",array(date("Y-m-d"),1,$nick));
        if(empty($rpt)){
            return array();
        }

        $loghour = $rpt['loghour'];
        $data = json_decode($rpt["data"],true);
        $rptdata = json_decode($rpt["data"],true);

        if(empty($data)){
            return array();
        }

        $result = array(
            'loghour'=>$loghour,
            "count"=>0,
            "list"=>array()
        );
        foreach($data as $row){

            $d1=strtotime(date("Y-m-d"));
            $d2=strtotime($row["endTime"]);
            $days=ceil(($d2-$d1)/3600/24);
            if($days<=15){
                $result["count"]++;
                $result["list"][] = array_merge($row,array("days"=>$days));
            }

        }
        return $result;


    }

}