<?php

namespace application\modules\main\model;

use cloud\core\model\Model;

class Summary extends Model
{

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Summary the static model class
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
        return '{{summary}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(

            array('log_date,shoptotal, casetotal,caseruntotal, caseruntotal_ztc, caseruntotal_zuanshi ', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('log_date,shoptotal, casetotal,caseruntotal, caseruntotal_ztc, caseruntotal_zuanshi', 'safe', 'on' => 'search'),
        );
    }

}