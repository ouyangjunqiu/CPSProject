<?php
/**
 * @file File.php
 * @author ouyangjunqiu
 * @version Created by 16/6/15 14:49
 */

namespace application\modules\file\model;

use cloud\core\model\Model;

class File extends Model{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return File the static model class
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
        return '{{files}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name,md5,type,size,ext,isimage,attachdir,attachname,attachment, target,log_date,log_time', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('name,md5,type,size,ext,isimage,attachdir,attachname,attachment, target,log_date,log_time', 'safe', 'on'=>'search'),
        );
    }

}