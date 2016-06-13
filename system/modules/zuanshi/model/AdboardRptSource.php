<?php
/**
 * Created by PhpStorm.
 * User: ouyangjunqiu
 * Date: 16/4/14
 * Time: 上午11:45
 */

namespace application\modules\zuanshi\model;


use cloud\core\model\Model;
use cloud\core\utils\Cache;

class AdboardRptSource extends Model
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return AdboardRptSource the static model class
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
        return '{{zuanshi_adboard_rpt_source}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('logdate,nick,offset,data', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, logdate,nick,offset,data', 'safe', 'on' => 'search'),
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

    public static function fetchAllSummaryByCache($nick){
        try {
            $key = "sys.cache.adboard.summary." . md5($nick);
            if (Cache::check()) {
                $data = Cache::get($key);
                if ($data !== false)
                    return \CJSON::decode($data);
            }

            $data = self::fetchAllSummaryByNick($nick);
            if (empty($data)) {
                return array();
            }

            if (Cache::check()) {
                Cache::set($key, \CJSON::encode($data), 3000);
            }
            return $data;
        }catch(\Exception $e){
            return array();
        }
    }

    /**
     * 获取统计后的创意报表数据
     * @param $nick
     * @return array
     */
    public static function fetchAllSummaryByNick($nick){
        $logdate = date("Y-m-d");

        $sources = AdboardRptSource::model()->fetchAll("logdate=? AND nick=? ORDER BY offset ASC",array($logdate,$nick));
        $list = array();
        $i = 0;
        foreach($sources as $row) {
            $rpts = json_decode($row["data"],true);

            if(isset($rpts["rptAdboardDayList"])) {
                foreach ($rpts["rptAdboardDayList"] as $rpt) {
                    $list[$rpt["adboardId"]][] = $rpt;
                    $i++;
                }
            }

            if($i>5000){
                break;
            }
        }



        $data = array();
        foreach($list as $adboardId => $rpts){
            $summary = array(
                "charge" => 0,
                "click" => 0,
                "adPv" => 0,
                "clickUv" => 0,
                "dirShopColNum" => 0,
                "inshopItemColNum" => 0,
                "pay"=>0,
                "pay7"=>0,
                "pay15"=>0,
                "alipayInShopNum" => 0,
                "alipayInShopNum7" => 0,
                "alipayInShopNum15" => 0,
            );
            foreach($rpts as $rpt){
                $summary["adboardId"] = $rpt["adboardId"];
                $summary["adboardName"] = $rpt["adboardName"];
                $summary["imagePath"] = $rpt["adboardDO"]["imagePath"];
                $summary["charge"] += $rpt["charge"];
                $summary["click"] += $rpt["click"];
                $summary["adPv"] += $rpt["adPv"];
                $summary["clickUv"] += $rpt["clickUv"];
                $summary["dirShopColNum"] += $rpt["dirShopColNum"];
                $summary["inshopItemColNum"] += $rpt["inshopItemColNum"];
                $summary["alipayInShopNum"] += $rpt["alipayInShopNum"];
                $summary["alipayInShopNum7"] += $rpt["alipayInShopNum7"];
                $summary["alipayInShopNum15"] += $rpt["alipayInShopNum15"];

                $summary["pay"] += $rpt["charge"] * $rpt["roi"];
                $summary["pay7"] += $rpt["charge"] * $rpt["roi7"];
                $summary["pay15"] += $rpt["charge"] * $rpt["roi15"];

            }
            $data[] = array_merge($summary,array(
                "ctr" => round(@($summary["click"]/$summary["adPv"]),4)*100,
                "cpc" => round(@($summary["charge"]/$summary["click"]),2),
                "roi" => round(@($summary["pay"]/$summary["charge"]),2),
                "roi7" => round(@($summary["pay7"]/$summary["charge"]),2),
                "roi15"=>round(@($summary["pay15"]/$summary["charge"]),2),
            ));

        }
        return $data;
    }

}