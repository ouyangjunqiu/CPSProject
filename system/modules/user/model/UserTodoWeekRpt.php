<?php
/**
 * @file UserLoginShopLog.php
 * @author ouyangjunqiu
 * @version Created by 16/6/7 15:33
 */

namespace application\modules\user\model;


use cloud\core\model\Model;

class UserTodoWeekRpt extends Model
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return UserTodoWeekRpt the static model class
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
        return '{{users_todo_w_rpt}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('username,c,c0,c1,c2', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('username,c,c0,c1,c2', 'safe', 'on'=>'search'),
        );
    }
}