<?php

namespace application\modules\main\model;

use cloud\core\model\Model;

class ShopMonthRpt extends Model
{

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ShopMonthRpt the static model class
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
        return '{{shop_m_rpt}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(

            array('year,month,data', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('year,month,data', 'safe', 'on' => 'search'),
        );
    }

}