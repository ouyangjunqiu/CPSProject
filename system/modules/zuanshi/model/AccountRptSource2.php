<?php
namespace application\modules\zuanshi\model;

use cloud\core\model\Model;


class AccountRptSource2 extends Model
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return AccountRptSource2 the static model class
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
        return '{{zuanshi_account_rpt_source_2}}';
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
            array('id, advertiser_id, nick, ad_pv, ecpm, charge, ecpc, click, ctr, log_date', 'safe', 'on' => 'search'),
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