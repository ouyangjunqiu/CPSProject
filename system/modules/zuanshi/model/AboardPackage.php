<?php
/**
 * @file AboardPackage.php
 * @author ouyangjunqiu
 * @version Created by 16/8/4 16:09
 */

namespace application\modules\zuanshi\model;

use cloud\core\model\Model;

class AboardPackage extends Model
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return AboardPackage the static model class
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
        return '{{zuanshi_aboard_package}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('adboardId,nick,logdate,data', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('adboardId,nick,logdate,data', 'safe', 'on' => 'search'),
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