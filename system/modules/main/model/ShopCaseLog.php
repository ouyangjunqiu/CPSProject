<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015-11-19
 * Time: 17:01
 */

namespace application\modules\main\model;


use cloud\core\model\Model;

class ShopCaseLog extends Model {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ShopCaseLog the static model class
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
        return '{{shop_case_log}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('caseid,planid,nick,luodiye,luodiye_type,luodiye_alias, casetype, budget,actual_budget,  submituser, submitdate,log_date ', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('planid,nick,luodiye,luodiye_alias,luodiye_type, casetype, budget, actual_budget, submituser, submitdate,log_date', 'safe', 'on'=>'search'),
        );
    }

}