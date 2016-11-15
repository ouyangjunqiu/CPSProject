<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015-12-03
 * Time: 11:49
 */

namespace application\modules\main\model;

use cloud\core\model\Model;

class ShopBudgetLog extends Model {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ShopBudgetLog the static model class
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
        return '{{shop_budget_log}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('logdate,nick,budget,ztc_budget,zuanshi_budget,tags', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('nick, budget,ztc_budget,zuanshi_budget,tags', 'safe', 'on'=>'search'),
        );
    }

}