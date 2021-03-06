<?php
namespace application\modules\zuanshi\model;

use cloud\core\model\Model;

/**
 * This is the model class for table "{{_account_rpt}}".
 *
 * The followings are the available columns in table '{{_account_rpt}}':
 * @property integer $id
 * @property string $advertiser_id
 * @property string $nick
 * @property integer $ad_pv
 * @property integer $ecpm
 * @property integer $charge
 * @property integer $ecpc
 * @property integer $click
 * @property integer $ctr
 * @property string $log_date
 */
class AccountRpt2 extends Model
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return AccountRpt2 the static model class
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
        return '{{zuanshi_account_rpt_2}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('ad_pv, click', 'numerical', 'integerOnly' => true),
            array('advertiser_id', 'length', 'max' => 20),
            array('nick', 'length', 'max' => 250),
            array('ecpm, charge, ecpc, ctr, roi,roi7,roi15', 'length', 'max' => 10),
            array('log_date,extra', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, advertiser_id, nick, ad_pv, ecpm, charge, ecpc, click, ctr, log_date, roi,roi7,roi15,extra', 'safe', 'on' => 'search'),
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

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'advertiser_id' => '广告主ID',
            'nick' => '广告主名',
            'ad_pv' => '展现量',
            'ecpm' => '千次展现成本',
            'charge' => '消耗',
            'ecpc' => '点击单价',
            'click' => '点击量',
            'ctr' => '点击率',
            'log_date' => '记录日期',
        );
    }

}