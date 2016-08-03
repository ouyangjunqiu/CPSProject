<?php
namespace application\modules\zz\model;

use cloud\core\model\Model;


class AdvertiserRptSource extends Model
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return AdvertiserRptSource the static model class
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
        return '{{zuanshi_advertiser_rpt_source}}';
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

    public static function fetchByNick($nick,$effectType = "click",$effect = 7){
        $logdate = date("Y-m-d");
        $row = self::model()->fetch("logdate=? AND nick=? AND effectType=? AND effect=?",array($logdate,$nick,$effectType,$effect));
        if(empty($row)){
            return array("list"=>array(),"total"=>array());
        }
        $source = \CJSON::decode($row["data"]);
        $total = array(
            "adPv"=> 0,
            "alipayInShopNum" => 0,
            "alipayInshopAmt" => 0,
            "avgAccessPageNum" => 0,
            "avgAccessTime" => 0,
            "cartNum" => 0,
            "charge"=> 0,
            "click" => 0,
            "ctr" => 0,
            "cvr" => 0,
            "deepInshopUv" => 0,
            "dirShopColNum" => 0,
            "ecpc" => 0,
            "ecpm" => 0,
            "gmvInshopAmt" => 0,
            "gmvInshopNum" => 0,
            "inshopItemColNum" => 0,
            "roi" => 0,
            "uv" => 0
        );
        $list = array();
        foreach($source as $row){
            $d = date("Ymd",strtotime($row["logDate"]));
            $list[$d] = $row;
            $total["adPv"]+=$row["adPv"];
            $total["alipayInShopNum"]+=$row["alipayInShopNum"];
            $total["alipayInshopAmt"]+=$row["alipayInshopAmt"];
            $total["cartNum"]+=$row["cartNum"];
            $total["charge"]+=$row["charge"];
            $total["click"]+=$row["click"];
            $total["deepInshopUv"]+=$row["deepInshopUv"];
            $total["dirShopColNum"]+=$row["dirShopColNum"];
            $total["gmvInshopAmt"]+=$row["gmvInshopAmt"];
            $total["gmvInshopNum"]+=$row["gmvInshopNum"];
            $total["inshopItemColNum"]+=$row["inshopItemColNum"];
            $total["uv"]+=$row["uv"];
        }

        $total["roi"] = empty($total["charge"])?0:round(@$total["alipayInshopAmt"]/$total["charge"],2);
        $total["ctr"] = empty($total["adPv"])?0:round(@$total["click"]/$total["adPv"],4);
        $total["ecpc"] = empty($total["click"])?0:round(@$total["charge"]/$total["click"],2);

        return array("list"=>$list,"total"=>$total);

    }

    public static function fetchAllByNick($nick,$effectType = "click"){
        $logdate = date("Y-m-d");
        $count = self::model()->count("logdate=? AND nick=? AND effectType=?",array($logdate,$nick,$effectType));
        if($count<=0){
            return false;
        }

        $result = array();
        $e = [3,7,15];
        foreach($e as $effect){
            $result[$effectType.$effect] = self::fetchByNick($nick,$effectType,$effect);
        }

        return $result;
    }


}