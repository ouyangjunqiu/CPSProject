<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015-12-03
 * Time: 11:49
 */

namespace application\modules\main\model;

use cloud\core\model\Model;
use cloud\core\utils\Cache;

class ShopPlan extends Model {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ShopPlan the static model class
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
        return '{{shop_plan}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('nick','unique'),

            array('planid, budget,ztc_budget,zuanshi_budget', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('planid,nick, budget,ztc_budget,zuanshi_budget', 'safe', 'on'=>'search'),
        );
    }

    public static function makeCaseListByPlanId($planid){
        $plan = self::model()->find("planid='$planid'");
        $plan["cases"] = ShopCase::makeListByPlanId($planid);
        return $plan;
    }

    public static function fetchRunPlanByNick($nick){
        try {
            $key = "sys.cache." . md5($nick);
            if (Cache::check()) {
                $plan = Cache::get($key);
                if ($plan !== false)
                    return \CJSON::decode($plan);
            }

            $plan = self::model()->fetch("nick='$nick'");
            if (!empty($plan)) {
                $plan["cases"] = ShopCase::fetchIndexListByPlanId($plan["planid"]);
            }
            if (Cache::check()) {
                Cache::set($key, \CJSON::encode($plan), 3000);
            }
            return $plan;
        }catch (\Exception $e){

            $plan = self::model()->fetch("nick='$nick'");
            if (!empty($plan)) {
                $plan["cases"] = ShopCase::fetchIndexListByPlanId($plan["planid"]);
            }
            return $plan;
        }
    }

}