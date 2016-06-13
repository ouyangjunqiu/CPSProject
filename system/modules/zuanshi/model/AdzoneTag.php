<?php

namespace application\modules\zuanshi\model;

use cloud\core\model\Model;

class AdzoneTag extends Model
{
    public static $TAGS = array(
        "常用",
        "PC",
        "无线",
        "站内",
        "站外",
        "推荐"
    );
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return AdzoneTag the static model class
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
        return '{{zuanshi_adzone_tags}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(

            array("adzoneId",'unique'),
            array('tags', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('adzoneId,tags', 'safe', 'on'=>'search'),
        );
    }



}