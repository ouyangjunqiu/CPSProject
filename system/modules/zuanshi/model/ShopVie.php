<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015-12-29
 * Time: 11:37
 */

namespace application\modules\zuanshi\model;

use cloud\core\model\Model;

class ShopVie extends Model
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ShopVie the static model class
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
        return '{{shop_vie}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(

            array('nick,shopid,shopnick,shoptext,cnt,keyword,itemtext,src,campaignid,isdeleted,is_use,log_date', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('nick,shopid,shopnick,cnt,keyword,campaignid,isdeleted,is_use,log_date', 'safe', 'on'=>'search'),
        );
    }

}