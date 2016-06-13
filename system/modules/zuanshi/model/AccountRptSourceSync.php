<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015-12-15
 * Time: 10:27
 */

namespace application\modules\zuanshi\model;

use cloud\core\model\Model;

class AccountRptSourceSync extends Model
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return AccountRptSourceSync the static model class
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
        return '{{zuanshi_account_rpt_source_sync}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(

            array('source_id', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id,source_id', 'safe', 'on' => 'search'),
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