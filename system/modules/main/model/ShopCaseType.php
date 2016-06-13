<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015-12-03
 * Time: 11:51
 */

namespace application\modules\main\model;

use cloud\core\model\Model;

class ShopCaseType extends Model
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Shop the static model class
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
        return '{{shop_case_type}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(

            array('value', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('value', 'safe', 'on'=>'search'),
        );
    }

    public static function makeSelect2Json(){
        $list = self::model()->fetchAll();
        $result = array();
        foreach($list as $row){
            $result[] = array("id"=>$row["value"],"text"=>$row["value"]);
        }
        return json_encode($result);
    }

}