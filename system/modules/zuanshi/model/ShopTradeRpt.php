<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016-03-07
 * Time: 17:20
 */

namespace application\modules\zuanshi\model;


use cloud\core\model\Model;
use cloud\core\utils\ExtRangeDate;

class ShopTradeRpt extends Model
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ShopTradeRpt the static model class
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
        return '{{shop_trade_rpt}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(

            array('log_date,nick,userid,usernumid,shopid,shopname,payAmt,create_date', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('log_date,nick,userid,usernumid,shopid,shopname,payAmt,create_date', 'safe', 'on'=>'search'),
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