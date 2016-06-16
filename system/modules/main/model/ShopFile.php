<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015-11-19
 * Time: 17:01
 */

namespace application\modules\main\model;


use cloud\core\model\Model;

class ShopFile extends Model {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ShopFile the static model class
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
        return '{{shop_file}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('nick,file_md5,file_name,creator,logdate, logtime', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('nick,file_md5,file_name,creator,logdate, logtime', 'safe', 'on'=>'search'),
        );
    }

}