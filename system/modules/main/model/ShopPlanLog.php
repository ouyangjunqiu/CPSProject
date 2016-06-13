<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015-12-03
 * Time: 11:49
 */

namespace application\modules\main\model;

use cloud\core\model\Model;

class ShopPlanLog extends Model {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ShopPlanLog the static model class
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
        return '{{shop_plan_log}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(

            array('planid,nick, budget,log_date,ztc_budget,zuanshi_budget', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('planid,nick, budget,log_date,ztc_budget,zuanshi_budget', 'safe', 'on'=>'search'),
        );
    }

}