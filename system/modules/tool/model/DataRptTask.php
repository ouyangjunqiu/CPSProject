<?php
namespace application\modules\tool\model;
use cloud\core\model\Model;

/**
 * @file DataRptTask.php
 * @author ouyangjunqiu
 * @version Created by 16/9/12 15:52
 */
class DataRptTask extends Model
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return DataRptTask the static model class
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
        return '{{zuanshi_bigdata_rpt_task}}';
    }


    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('logdate,taskid,params,result,code', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('logdate,taskid,params,result,code', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'cid' => 'Cid',
            'parent_cid' => 'Parent Cid',
            'name' => 'Name',
            'is_parent' => 'Is Parent',
            'status' => 'Status',
            'sort_order' => 'Sort Order',
        );
    }

}