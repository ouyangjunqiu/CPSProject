<?php
/**
 * @file ShopConcat.php
 * @author ouyangjunqiu
 * @version Created by 16/6/1 10:41
 */

namespace application\modules\main\model;


use cloud\core\model\Model;

class ShopContact extends Model
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ShopContact the static model class
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
        return '{{shop_contact}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(

            array('nick','unique'),
            array('qq,email,phone,weixin', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('qq,email,phone,weixin', 'safe', 'on'=>'search'),
        );
    }

    public static function fetchByNick($nick){
        $model = self::model()->fetch("nick=?",array(addslashes($nick)));
        if(empty($model)){
            return array(
                "nick"=>$nick,
                "qq"=>"",
                "email"=>"",
                "phone"=>"",
                "weixin"=>""
            );
        }
        return $model;

    }


}