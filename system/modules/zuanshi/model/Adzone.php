<?php

namespace application\modules\zuanshi\model;

use cloud\core\model\Model;

class Adzone extends Model
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Adzone the static model class
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
        return '{{zuanshi_adzone}}';
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
            array('adzoneLevel,adzoneName,adzoneSize,adzoneSizeList,adzoneUrl,type,log_date', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('adzoneId,adzoneLevel,adzoneName,adzoneSize,adzoneSizeList,adzoneUrl,type,log_date', 'safe', 'on'=>'search'),
        );
    }

    public static function fetchAllBySelect(){
        $selectData = array();
        $list = self::model()->fetchAll();
        foreach($list as $row){
            $selectData[] = array("id"=>$row["adzoneId"].":".$row["type"],"text"=>$row["adzoneName"]);
        }

        return json_encode($selectData);

    }

}