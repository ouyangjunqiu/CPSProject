<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015-12-16
 * Time: 10:24
 */

namespace application\modules\main\model;


use cloud\core\model\Model;

class ShopCaseRunRptWeek extends Model
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ShopCaseRunRptWeek the static model class
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
        return '{{shop_case_run_rpt_week}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(

            array('nick,year,month,w,log_date, planid, plan_budget, caseid, casetype,luodiye,luodiye_alias,luodiye_type, begin_date, end_date, case_budget,case_actual_budget, runid, runtype,rundept, run_budget,remark ,cost, roi, budget_ok, rpt_ok', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('nick,year,month,w,log_date, planid, plan_budget, caseid, casetype,luodiye,luodiye_alias,luodiye_type, begin_date, end_date, case_budget,case_actual_budget, runid, runtype,rundept, run_budget,remark ,cost, roi, budget_ok, rpt_ok', 'safe', 'on'=>'search'),
        );
    }

    public static function fetchBaseInfoByNick($nick){
        $sql = <<<EOT
SELECT a.nick AS nick ,a.id AS planid, a.`budget` AS plan_budget, b.id AS caseid, b.`casetype` AS casetype ,b.actual_budget AS case_actual_budget,
b.`luodiye_alias` AS luodiye_alias,b.`luodiye` AS luodiye ,b.`luodiye_type` AS luodiye_type, b.`budget` AS case_budget,
c.id AS runid ,c.`dept` AS rundept, c.budget AS run_budget, c.remark AS remark
 FROM {{shop_plan}} AS a
 LEFT JOIN {{shop_case}} AS b ON a.`planid`=b.`planid`
 LEFT JOIN {{shop_case_run}} AS c ON b.`caseid`=c.`caseid`
WHERE a.`nick`="$nick" AND b.isstop='0 '
EOT;
        /**
         * @var \CDbCommand $command
         */
        $command = \Yii::app()->db->createCommand($sql);
        $list = $command->queryAll();
        return $list;

    }

    public static function fetchStopListByNick($nick){
        $sql = <<<EOT
SELECT a.nick AS nick ,a.id AS planid, a.`budget` AS plan_budget, b.id AS caseid, b.`casetype` AS casetype ,b.actual_budget AS case_actual_budget,
b.`luodiye_alias` AS luodiye_alias,b.`luodiye` AS luodiye ,b.`luodiye_type` AS luodiye_type, b.`budget` AS case_budget,
c.id AS runid ,c.`dept` AS rundept, c.budget AS run_budget, c.remark AS remark
 FROM {{shop_plan}} AS a
 LEFT JOIN {{shop_case}} AS b ON a.`planid`=b.`planid`
 LEFT JOIN {{shop_case_run}} AS c ON b.`caseid`=c.`caseid`
WHERE a.`nick`="$nick" AND b.isstop='1 '
EOT;
        /**
         * @var \CDbCommand $command
         */
        $command = \Yii::app()->db->createCommand($sql);
        $list = $command->queryAll();
        return $list;
    }

    public static function fetchLastWeekByCaseId($caseid){

        $list = self::model()->fetchAll("year=? AND w=? AND caseid=?",array(date("Y"),date("W",strtotime("-1 week")),$caseid));
        $result = array();
        foreach($list as $row){
            $result[$row["rundept"]] = $row;
        }

        return $result;

    }
}