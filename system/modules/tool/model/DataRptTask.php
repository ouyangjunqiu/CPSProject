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
    public static $dataType = array(
        1=>"钻展定向报表",
        2=>"钻展创意报表",
        3=>"钻展资源位报表",
        4=>"钻展定向资源位",
        5=>"类目-店铺-人群类型报表",
        6=>"定向名-类目",
        7=>"类目-人群类型报表",
        8=>"类目-定向报表",
        9=>"类目-店铺-定向渠道报表",
        10=>"类目-定向渠道",
        11=>"类目-店铺-站内/站外报表",
        12=>"类目-站内/站外报表",
        13=>"类目-资源位",
        14=>"类目-店铺-消耗/营收比例",
        15=>"类目-消耗/营收比例",
        16=>"类目-店铺-定向类型 点击单价层次",
        17=>"类目-店铺-资源位类别 点击单价层次",
        18=>"类目-店铺-资源位类别 展现成本层次",
        19=>"类目-资源位类别 点击单价层次",
        20=>"类目-资源位类别 展现成本层次",
        21=>"类目-资源位类别",
        22=>"创意报表 尺寸-文案风格-主文案",
        23=>"创意报表 主文案-尺寸",
        24=>"创意报表 文案风格-尺寸",
        25=>"尺寸-创意报表"
    );
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
            array('logdate,taskid,params,result,code,createtime,runtime', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('logdate,taskid,params,result,code,createtime,runtime', 'safe', 'on' => 'search'),
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