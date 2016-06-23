<?php

namespace application\modules\zuanshi\model;

use cloud\core\model\Model;

class Dmp extends Model
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Dmp the static model class
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
        return '{{zuanshi_dmp}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(

            array('logdate,nick,data,logtime', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('logdate,nick,data,logtime', 'safe', 'on'=>'search'),
        );
    }

    public static function fetchByNick($nick){
        $dmp = self::model()->fetch("logdate>=? AND nick=? ORDER BY id DESC",array(date("Y-m-d",strtotime("-7 days")),$nick));
        $data = json_decode($dmp["data"]);
        return empty($data["dmpCrowds"])?array():$data["dmpCrowds"];
    }

}