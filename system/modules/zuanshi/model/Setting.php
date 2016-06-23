<?php

namespace application\modules\zuanshi\model;

use cloud\core\model\Model;

class Setting extends Model
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Setting the static model class
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
        return '{{zuanshi_setting}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(

            array('nick,campaignid,type,adzone,shops,select_shops,creatives,dmps', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('nick,campaignid,type,adzone,shops,select_shops,creatives,dmps', 'safe', 'on'=>'search'),
        );
    }


    public static function fetchDmpSettingByNick($nick){
        $setting = Setting::model()->fetch("nick=?",array($nick));
        if(empty($setting))
            return array();
        $dmps = json_decode($setting["dmps"]);
        if(empty($dmps))
            return array();

        $ret = array();
        foreach($dmps as $dmp){
            $ret[] = $dmp["targetValue"];
        }
        return $ret;
    }

}