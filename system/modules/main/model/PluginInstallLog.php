<?php
/**
 * @file PluginInstallLog.php
 * @author ouyangjunqiu
 * @version Created by 16/9/5 14:34
 */

namespace application\modules\main\model;


use cloud\core\model\Model;

class PluginInstallLog extends Model
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PluginInstallLog the static model class
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
        return '{{plugin_install_log}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(

            array('version,logdate,username', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('version,logdate,username', 'safe', 'on'=>'search'),
        );
    }

}