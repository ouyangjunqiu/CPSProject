<?php
namespace application\modules\ztc\model;

use cloud\core\model\Model;


class CustRpt extends Model
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return CustRpt the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{ztc_cust_rpt}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('nick', 'length', 'max' => 128),
            array('logdate,effectType,effect,data', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('nick,logdate,effectType,effect,data', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
    }

    public static function fetchByNick($nick,$begin_date,$end_date,$effectType="click",$effect = 7){
        $source = self::model()->fetchAll("logdate>=? AND logdate<=? AND nick=? AND effectType=? AND effect=?",array($begin_date,$end_date,$nick,$effectType,$effect));
        $total = array(
            "impressions"=> 0,
            "paycount" => 0,
            "pay" => 0,
            "carttotal" => 0,
            "cost"=> 0,
            "click" => 0,
            "ctr" => 0,
            "ci" => 0,
            "ppc" => 0,
            "favcount" => 0,
            "roi" => 0,
            "fi" => 0
        );
        $list = array();
        foreach($source as $r){
            $d = date("Ymd",strtotime($r["logdate"]));
            $row = \CJSON::decode($r["data"]);
            $list[$d] = $row;

            $total["impressions"]+=$row["impressions"];
            $total["paycount"]+=$row["paycount"];
            $total["pay"]+=$row["pay"];
            $total["carttotal"]+=$row["carttotal"];
            $total["cost"]+=$row["cost"];
            $total["click"]+=$row["click"];

            $total["favcount"]+=$row["favcount"];
        }

        $total["roi"] = empty($total["cost"])?"0":@round($total["pay"]/$total["cost"],2);
        $total["ctr"] = empty($total["impressions"])?"0":@round($total["click"]/$total["impressions"]*100,2);
        $total["ppc"] = empty($total["click"])?"0":@round($total["cost"]/$total["click"],2);
        $total["fi"] = empty($total["click"])?"0":@round($total["favcount"]/$total["click"]*100,2);
        $total["ci"] = empty($total["click"])?"0":@round($total["paycount"]/$total["click"]*100,2);

        return array("list"=>$list,"total"=>$total);

    }

    public static function fetchAllByNick($nick,$begin_date,$end_date,$effectType = "click"){

        $result = array();
        $e = [3,7,15];
        foreach($e as $effect){
            $result[$effectType.$effect] = self::fetchByNick($nick,$begin_date,$end_date,$effectType,$effect);
        }

        return $result;
    }


}