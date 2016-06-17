<?php

namespace application\modules\main\model;

use cloud\core\model\Model;

class SummaryDetailForZuanshi extends Model
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return SummaryDetailForZuanshi the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{summary_detail_zuanshi}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(

            array('log_date,pic,shoptotal,casetotal ', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('log_date,pic,shoptotal,casetotal', 'safe', 'on' => 'search'),
        );
    }

    public static function cal(){
        $list = ShopCaseRun::detailZuanshi();
        foreach($list as $row){
            self::model()->deleteAll("log_date=? AND pic=?",array(date("Y-m-d"),$row["pic"]));
            $model = new self();
            $row["log_date"] = date("Y-m-d");
            $model->setAttributes($row);
            $model->save();
        }
    }

}