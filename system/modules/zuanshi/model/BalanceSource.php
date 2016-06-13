<?php
/**
 * Created by PhpStorm.
 * User: ouyangjunqiu
 * Date: 16/3/30
 * Time: 下午5:34
 */

namespace application\modules\zuanshi\model;


use cloud\core\model\Model;

class BalanceSource extends Model
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return BalanceSource the static model class
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
        return '{{zuanshi_balance_source}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(

            array('nick,logdate,loghour,data', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('nick,logdate,loghour,data', 'safe', 'on'=>'search'),
        );
    }

}