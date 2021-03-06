<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016-03-07
 * Time: 17:20
 */

namespace application\modules\sycm\model;


use cloud\core\model\Model;
use cloud\core\utils\ExtRangeDate;

class ShopUvRpt extends Model
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ShopUvRpt the static model class
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
        return '{{shop_uv_rpt}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(

            array('log_date,nick,userid,usernumid,shopid,shopname,uv,create_date', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('log_date,nick,userid,usernumid,shopid,shopname,uv,create_date', 'safe', 'on'=>'search'),
        );
    }

    public static function fetchAllByLast15Days($nick){
        $rangeDate = ExtRangeDate::range(16);
        $list = self::model()->fetchAll("log_date>=? AND log_date<=? AND shopname=?",array($rangeDate->startDate,$rangeDate->endDate,$nick));
        $result = array("total_pay_amt"=>0);
        foreach($list as $row){
            $result[$row["log_date"]] = $row;
            $result["total_pay_amt"] += $row["payAmt"];
        }
        return $result;
    }

    public static function fetchAllByShopname($shopname,$days=16){
        $rangeDate = ExtRangeDate::range($days);
        $source = self::model()->fetchAll("log_date>=? AND log_date<=? AND shopname=?",array($rangeDate->startDate,$rangeDate->endDate,$shopname));
        $total = array(
            "payAmt"=>0
        );
        $list = array();
        foreach($source as $row){
            $d = date("Ymd",strtotime($row["log_date"]));
            $list[$d] = $row;
            $total["payAmt"] += $row["payAmt"];
        }
        return array("list"=>$list,"total"=>$total);

    }

    /**
     * @param $startdate
     * @param $enddate
     * @param $nick
     * @return array
     */
    public static function fetchAllByNickV2($startdate,$enddate,$nick){

        $source = self::model()->fetchAll("log_date>=? AND log_date<=? AND nick=?",array($startdate,$enddate,$nick));
        $total = array(
            "payAmt"=>0
        );
        $list = array();
        foreach($source as $row){
            $d = date("Ymd",strtotime($row["log_date"]));
            $list[$d] = $row;
            $total["payAmt"] += $row["payAmt"];
        }
        return array("list"=>$list,"total"=>$total);

    }

    public static function summaryLastWeekByNick($nick){
        $rangeDate = ExtRangeDate::lastWeek();
        $list = self::model()->fetchAll("log_date>=? AND log_date<=? AND shopname=?",array($rangeDate->startDate,$rangeDate->endDate,$nick));
        $result = array("total_pay_amt"=>0);
        foreach($list as $row){
            //$result[$row["log_date"]] = $row;
            $result["total_pay_amt"] += $row["payAmt"];
        }
        return $result;
    }

    public static function summaryWeekByNick($nick){
        $rangeDate = ExtRangeDate::week();
        $list = self::model()->fetchAll("log_date>=? AND log_date<=? AND shopname=?",array($rangeDate->startDate,$rangeDate->endDate,$nick));
        $result = array("total_pay_amt"=>0);
        foreach($list as $row){
            //$result[$row["log_date"]] = $row;
            $result["total_pay_amt"] += $row["payAmt"];
        }
        return $result;
    }

    public static function summaryByNick($startdate,$enddate,$nick){
        $list = self::model()->fetchAll("log_date>=? AND log_date<=? AND shopname=?",array($startdate,$enddate,$nick));
        $result = array("total_pay_amt"=>0);
        foreach($list as $row){
            //$result[$row["log_date"]] = $row;
            $result["total_pay_amt"] += $row["payAmt"];
        }
        return $result;
    }

}