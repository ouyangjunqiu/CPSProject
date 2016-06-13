<?php
namespace application\modules\dmp\model;

use cloud\core\model\Model;


class AccountRptSource extends Model
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return AccountRptSource the static model class
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
        return '{{dmp_account_rpt_source}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('nick', 'length', 'max' => 128),
            array('date,userinfo,rpts', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('nick,date,userinfo,rpts', 'safe', 'on' => 'search'),
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