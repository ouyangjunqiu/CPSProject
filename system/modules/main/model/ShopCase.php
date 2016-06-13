<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015-11-19
 * Time: 17:01
 */

namespace application\modules\main\model;


use cloud\core\model\Model;

class ShopCase extends Model {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ShopCase the static model class
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
        return '{{shop_case}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('caseid','unique'),
            array('planid,nick,luodiye,luodiye_type,luodiye_alias, casetype, budget,actual_budget,  submituser, submitdate, isstop, stopdate ', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('planid,nick,luodiye,luodiye_alias,luodiye_type, casetype, budget, actual_budget, submituser, submitdate, isstop, stopdate', 'safe', 'on'=>'search'),
        );
    }

    public static function fetchIndexListByPlanId($planid){
        $list = ShopCase::model()->fetchAll("planid='{$planid}' AND isstop='0'");
        foreach($list as &$row){
            $row["rpt"] = ShopCaseRunRptWeek::fetchLastWeekByCaseId($row["id"]);
        }
        return $list;
    }

    public static function makeListByPlanId($planid){

        $list = self::model()->fetchAll("planid='$planid'");
        $ret = array();
        foreach($list as $row){
            $ret[$row["casetype"]][] = $row;
        }

        return $ret;
    }

    public static function summary(){
        $sql = "SELECT COUNT(*) AS c FROM {{shop_case}} AS a LEFT JOIN {{shop}} AS b ON a.nick=b.nick WHERE a.isstop=0 AND b.status=0";
        $command = \Yii::app()->db->createCommand($sql);
        return $command->queryScalar();
    }


}