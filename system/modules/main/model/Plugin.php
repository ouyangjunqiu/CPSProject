<?php

namespace application\modules\main\model;

use cloud\core\model\Model;

class Plugin extends Model {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Plugin the static model class
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
        return '{{plugin}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(

            array('version,file_md5', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('version,file_md5', 'safe', 'on'=>'search'),
        );
    }

    public static function fetchVersion(){
        $tool = self::model()->fetch("ORDER BY id DESC");
        if(empty($tool)){
            return array(
                "version"=>"1.0.0",
                "file_md5"=>"",
            );
        }
        return $tool;
    }

}