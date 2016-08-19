<?php
/**
 * Created by PhpStorm.
 * User: ouyangjunqiu
 * Date: 16/4/14
 * Time: 上午11:45
 */

namespace application\modules\zz\model;

use cloud\core\model\Model;

class DestE15Rpt extends Model
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return DestE15Rpt the static model class
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
        return '{{zuanshi_dest_d_e15_rpt}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('logdate,nick,campaignId,campaignName,transId,transName,targetId,targetName,destType,adPv,alipayInShopNum,alipayInshopAmt,avgAccessPageNum,avgAccessTime,cartNum,charge,click,ctr,cvr,deepInshopUv,dirShopColNum,ecpc,ecpm,gmvInshopAmt,gmvInshopNum,inshopItemColNum,roi,uv', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('logdate,nick,campaignId,campaignName,transId,transName,targetId,targetName,destType,adPv,alipayInShopNum,alipayInshopAmt,avgAccessPageNum,avgAccessTime,cartNum,charge,click,ctr,cvr,deepInshopUv,dirShopColNum,ecpc,ecpm,gmvInshopAmt,gmvInshopNum,inshopItemColNum,roi,uv', 'safe', 'on' => 'search'),
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


}