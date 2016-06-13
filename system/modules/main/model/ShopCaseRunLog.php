<?php

namespace application\modules\main\model;

use cloud\core\model\Model;

class ShopCaseRunLog extends Model
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ShopCaseRunLog the static model class
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
        return '{{shop_case_run_log}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(

            array('nick,log_date, planid, plan_budget, caseid, casetype,luodiye,luodiye_alias,luodiye_type,case_actual_budget, case_budget, runid, runtype,rundept, run_budget,remark ', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('nick,log_date, planid, plan_budget, caseid, casetype,luodiye,luodiye_alias, case_budget, runid, runtype,rundept, run_budget,remark', 'safe', 'on'=>'search'),
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
WHERE a.`nick`="$nick" AND b.isstop = 0
EOT;
        /**
         * @var \CDbCommand $command
         */
        $command = \Yii::app()->db->createCommand($sql);
        $list = $command->queryAll();
        return $list;

    }
}