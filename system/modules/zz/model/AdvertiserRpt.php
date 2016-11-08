<?php
namespace application\modules\zz\model;

use cloud\core\model\Model;


class AdvertiserRpt extends Model
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return AdvertiserRpt the static model class
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
        return '{{zuanshi_advertiser_rpt}}';
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

    /**
     * @param $values
     * @return array
     */
    private static function format($values)
    {
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
            "uv" => 0,
            "avgCharge" => 0,
            "days" => 0
        );
        $list = array();
        foreach($values as $r){
            $d = date("Ymd",strtotime($r["logdate"]));
            $row = \CJSON::decode($r["data"]);
            $list[$d] = $row;

            $total["days"]+=1;
            $total["adPv"]+=empty($row["adPv"])?0:$row["adPv"];
            $total["alipayInShopNum"]+=empty($row["alipayInShopNum"])?0:$row["alipayInShopNum"];
            $total["alipayInshopAmt"]+=empty($row["alipayInshopAmt"])?0:$row["alipayInshopAmt"];
            $total["cartNum"]+=empty($row["cartNum"])?0:$row["cartNum"];
            $total["charge"]+=empty($row["charge"])?0:$row["charge"];
            $total["click"]+=empty($row["click"])?0:$row["click"];
            $total["deepInshopUv"]+=empty($row["deepInshopUv"])?0:$row["deepInshopUv"];
            $total["dirShopColNum"]+=empty($row["dirShopColNum"])?0:$row["dirShopColNum"];
            $total["gmvInshopAmt"]+=empty($row["gmvInshopAmt"])?0:$row["gmvInshopAmt"];
            $total["gmvInshopNum"]+=empty($row["gmvInshopNum"])?0:$row["gmvInshopNum"];
            $total["inshopItemColNum"]+=empty($row["inshopItemColNum"])?0:$row["inshopItemColNum"];
            $total["uv"]+=empty($row["uv"])?0:$row["uv"];
        }

        $total["roi"] = empty($total["charge"])?0:@round($total["alipayInshopAmt"]/$total["charge"],2);
        $total["ctr"] = empty($total["adPv"])?0:@round($total["click"]/$total["adPv"],4);
        $total["ecpc"] = empty($total["click"])?0:@round($total["charge"]/$total["click"],2);
        $total["alipayInshopAmt"] = round($total["alipayInshopAmt"],2);
        $total["avgCharge"] = empty($total["days"])?0:@round($total["charge"]/$total["days"],2);
        return array("list"=>$list,"total"=>$total);
    }

    public static function fetchByNick($nick,$begin_date,$end_date,$effectType="click",$effect = 7){
        $source = self::model()->fetchAll("logdate>=? AND logdate<=? AND nick=? AND effectType=? AND effect=?",array($begin_date,$end_date,$nick,$effectType,$effect));
        return self::format($source);
    }

    public static function fetchAllByNick($nick,$begin_date,$end_date,$effectType = "click"){

        $source = self::model()->fetchAll("logdate>=? AND logdate<=? AND nick=? AND effectType=?",array($begin_date,$end_date,$nick,$effectType));
        $data = array();
        foreach($source as $row){
            $data[$effectType.$row["effect"]][] = $row;
        }

        $result = array();
        foreach($data as $k=>$values){
            $result[$k] = self::format($values);
        }

//
//        $result = array();
//        $e = [3,7,15];
//        foreach($e as $effect){
//            $result[$effectType.$effect] = self::fetchByNick($nick,$begin_date,$end_date,$effectType,$effect);
//        }

        return $result;
    }


}