<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015-12-03
 * Time: 11:56
 */

namespace application\modules\main\model;

use cloud\core\model\Model;

class ShopCaseRunType extends Model
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ShopCaseRunType the static model class
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
        return '{{shop_case_run_type}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(

            array('dept,runtype', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('dept,runtype', 'safe', 'on'=>'search'),
        );
    }

    public static function makeSelect2Json(){
        $list = self::model()->findAll();
        $result = array();
        foreach($list as $row){
            $result[$row["dept"]][] = array("id"=>$row["dept"].":".$row["runtype"],"text"=>$row["runtype"]);
        }

        $arr = array();
        foreach($result as $k=>$values){
            $arr[] = array("text"=>$k,"children"=>$values);
        }
        return json_encode($arr);
    }

}