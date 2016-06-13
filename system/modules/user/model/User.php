<?php
namespace application\modules\user\model;
use cloud\core\model\Model;

/**
 * @file User.php
 * @author ouyangjunqiu
 * @version Created by 16/5/18 08:51
 */
class User extends Model
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return User the static model class
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
        return '{{users}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('uid','unique'),
            array('uid,loginno,name,email,telephone,deptname', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('uid,loginno,name,email,telephone,deptname', 'safe', 'on'=>'search'),
        );
    }

}