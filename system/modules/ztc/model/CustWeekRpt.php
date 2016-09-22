<?php
/**
 * @file DmpDestWeekRpt.php
 * @author ouyangjunqiu
 * @version Created by 16/8/22 14:32
 */

namespace application\modules\ztc\model;


use cloud\core\model\Model;

class CustWeekRpt extends Model
{

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return CustWeekRpt the static model class
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
        return '{{ztc_cust_w_rpt}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('begindate,enddate,nick,data', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('begindate,enddate,nick,data', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
    }

}