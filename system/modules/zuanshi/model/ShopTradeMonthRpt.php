<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016-03-07
 * Time: 17:20
 */

namespace application\modules\zuanshi\model;


use cloud\core\model\Model;
use cloud\core\utils\ExtRangeDate;

class ShopTradeMonthRpt extends Model
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ShopTradeMonthRpt the static model class
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
        return '{{shop_trade_m_rpt}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(

            array('logyear,logmonth,nick,shopname,amt,logdate', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('logyear,logmonth,nick,shopname,amt,logdate', 'safe', 'on'=>'search'),
        );
    }

}