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
        1 => "钻展定向报表",
        2 => "钻展创意报表",
        3 => "钻展资源位报表",
        4 => "钻展定向资源位",
        5 => "类目-店铺-人群类型报表",
        6 => "定向名-类目",
        7 => "类目-人群类型报表",
        8 => "类目-定向报表",
        9 => "类目-店铺-定向渠道报表",
        10 => "类目-定向渠道",
        11 => "类目-店铺-站内/站外报表",
        12 => "类目-站内/站外报表",
        13 => "类目-资源位",
        14 => "类目-店铺-消耗/营收比例",
        15 => "类目-消耗/营收比例",
        16 => "类目-店铺-定向类型 点击单价层次",
        17 => "类目-店铺-资源位类别 点击单价层次",
        18 => "类目-店铺-资源位类别 展现成本层次",
        19 => "类目-资源位类别 点击单价层次",
        20 => "类目-资源位类别 展现成本层次",
        21 => "类目-资源位类别",
        22 => "创意报表 尺寸-文案风格-主文案",
        23 => "创意报表 主文案-尺寸",
        24 => "创意报表 文案风格-尺寸",
        25 => "尺寸-创意报表"
    );

    public static $categoryTaskType = array(

        "11、类目定向数据" => array(

            "1100" => "1100、类目-钻展定向源数据",
            "1101" => "1101、类目-店铺-定向类型 透视表报表",
            "1102" => "1102、类目-定向类目 透视表",
            "1103" => "1103、类目-定向类型 透视表",
            "1104" => "1104、类目-定向 透视表",
            "1105" => "1105、类目-店铺-定向渠道 透视表",
            "1106" => "1106、类目-定向渠道 透视表",
            "1107" => "1107、类目-店铺-定向类型(点击单价层次) 透视表"

        ),
        "12、类目资源位数据" => array(

            "1200" => "1200、类目-钻展资源位",
            "1201" => "1201、类目-资源位名称 透视表",
            "1202" => "1202、类目-店铺-资源位类别 透视表",
            "1203" => "1203、类目-资源位类别 透视表",
            "1204" => "1204、类目-店铺-资源位类别(点击单价层次) 透视表",
            "1205" => "1205、类目-店铺-资源位类别(展现成本层次) 透视表",
            "1206" => "1206、类目-资源位类别(点击单价层次) 透视表",
            "1207" => "1207、类目-资源位类别(展现成本层次) 透视表",
            "1208" => "1208、类目-资源位类别  透视表"

        ),
        "13、类目创意数据" => array(

            "1300" => "1300、类目-钻展创意表",
            "1301" => "1301、创意报表 尺寸-文案风格-主文案 透视表",
            "1302" => "1302、创意报表 主文案-尺寸 透视表",
            "1303" => "1303、创意报表 文案风格-尺寸 透视表",
            "1304" => "1304、尺寸-创意报表 透视表"

        ),
        "14、类目定向资源位数据" => array(

            "1400" => "1400、类目-钻展定向资源位",
            "1401" => "1401、类目-定向类别-资源位类别 透视表",
            "1402" => "1402、类目-定向渠道-资源位类别 透视表",
            "1403" => "1403、类目-资源位类别-定向类别 透视表"

        ),

        "15、类目营业数据" => array(

            "1501" => "1501、类目-店铺-消耗/营收比例",
            "1502" => "1502、类目-消耗/营收比例",
            "1503" => "1503、类目-成交/营收比例"

        ),
    );


    public static $shopTaskType = array(
        "21、店铺定向数据" => array(

            "2100" => "2100、店铺-钻展定向源数据",
            "2101" => "2101、店铺-定向透视表",
            "2102" => "2102、店铺-定向-时间 透视表",
            "2103" => "2103、店铺-时间-定向 透视表",
            "2104" => "2104、店铺-定向类别 透视表",
            "2105" => "2105、店铺-定向渠道 透视表",

        ),
        "22、店铺资源位数据" => array(

            "2200" => "2200、店铺-钻展资源位",
            "2201" => "2201、店铺-资源位日报",
            "2202" => "2202、店铺-资源位-时间 透视表",
            "2203" => "2203、店铺-时间-资源位 透视表",
            "2204" => "2204、店铺-资源位类别 透视表"

        ),
        "23、店铺创意数据" => array(

            "2300" => "2300、店铺-钻展创意表",
            "2301" => "2301、店铺-创意日报",
            "2302" => "2302、店铺-尺寸-创意 透视表",
            "2303" => "2303、店铺-主文案-尺寸 透视表",
            "2304" => "2304、店铺-风格-尺寸 透视表",
            "2305" => "2305、店铺-主文案-风格 透视表"

        ),

        "24、店铺定向资源位数据" => array(

            "2400" => "2400、店铺-钻展定向资源位",
            "2401" => "2401、店铺-定向资源位透视表",
            "2402" => "2402、店铺-定向类别-资源位类别 透视表",
            "2403" => "2403、店铺-定向渠道-资源位类别 透视表",
            "2404" => "2404、店铺-资源位类别-定向类别 透视表"

        ),

        "25、店铺钻展投放&营业数据" => array(

            "2501" => "2501、店铺-钻展日报",
            "2502" => "2502、店铺-消耗/营收比例",
            "2503" => "2503、店铺-成交/营收比例"

        ),

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