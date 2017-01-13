<?php
/**
 * Created by PhpStorm.
 * User: ouyangjunqiu
 * Date: 16/4/14
 * Time: 上午11:45
 */

namespace application\modules\zz\model;

use cloud\core\model\Model;

class AdboardRptHistory extends Model
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return AdboardRptHistory the static model class
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
        return '{{zuanshi_adboard_rpt_history_v2}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('logdate,nick,effectType,effect,offset,data', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('logdate,nick,effectType,effect,offset,data', 'safe', 'on' => 'search'),
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
     * @param $begindate
     * @param $enddate
     * @param $nick
     * @param string $effectType
     * @param int $effect
     * @return array
     */
    public static function fetchAllSummaryByNick($begindate, $enddate, $nick, $effectType = "click", $effect = 3)
    {

        $sources = self::model()->fetchAll("logdate>=? AND logdate<=? AND nick=? AND effectType=? AND effect=?", array($begindate, $enddate, $nick, $effectType, $effect));
        $list = array();
        foreach ($sources as $row) {
            $rpts = json_decode($row["data"], true);

            if (isset($rpts["result"])) {
                foreach ($rpts["result"] as $rpt) {
                    $list[$rpt["adboardId"]][] = $rpt;
                }
            }
        }


        $data = array();
        foreach ($list as $adboardId => $rpts) {
            $summary = array(
                "charge" => 0,
                "click" => 0,
                "adPv" => 0,
                "uv" => 0,
                "cartNum" => 0,
                "dirShopColNum" => 0,
                "inshopItemColNum" => 0,
                "alipayInshopAmt" => 0,
                "alipayInShopNum" => 0
            );
            foreach ($rpts as $rpt) {
                $summary["adboardId"] = $rpt["adboardId"];
                $summary["adboardName"] = $rpt["adboardName"];
                $summary["charge"] += $rpt["charge"];
                $summary["click"] += $rpt["click"];
                $summary["adPv"] += $rpt["adPv"];
                $summary["uv"] += $rpt["uv"];
                $summary["dirShopColNum"] += $rpt["dirShopColNum"];
                $summary["inshopItemColNum"] += $rpt["inshopItemColNum"];
                $summary["alipayInShopNum"] += $rpt["alipayInShopNum"];
                $summary["alipayInshopAmt"] += $rpt["alipayInshopAmt"];
                $summary["cartNum"] += $rpt["cartNum"];

            }
            if ($summary["adPv"] > 0 && $summary["click"] > 0 && $summary["charge"] > 0) {
                $data[] = array_merge($summary, array(
                    "ctr" => round(@($summary["click"] / $summary["adPv"]), 4) * 100,
                    "ecpc" => round(@($summary["charge"] / $summary["click"]), 2),
                    "roi" => round(@($summary["alipayInshopAmt"] / $summary["charge"]), 2),
                    "ecpm" => round(@($summary["charge"] / $summary["adPv"] * 1000), 2)
                ));
            }

        }
        return $data;
    }

    public static function fetchAllByNick($begindate, $enddate, $nick, $effectType = "click", $effect = 3)
    {
        $sources = self::model()->fetchAll("logdate>=? AND logdate<=? AND nick=? AND effectType=? AND effect=?", array($begindate, $enddate, $nick, $effectType, $effect));
        $list = array();
        foreach ($sources as $row) {
            $rpts = json_decode($row["data"], true);

            if (isset($rpts["result"]) && count($rpts["result"])>0) {
                foreach ($rpts["result"] as $rpt) {
                    $list[] = $rpt;
                }
            }
        }
        return $list;

    }
}