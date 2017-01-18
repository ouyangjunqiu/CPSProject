<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015-11-19
 * Time: 17:01
 */

namespace application\modules\main\model;


use cloud\core\model\Model;

class ShopLog extends Model {

    public static $status = array("0"=>"合作中","1"=>"暂停","2"=>"流失");
    public static $saleTypes = array(
        "直钻业务"=>"直钻业务",
        "直通车业务"=>"直通车业务",
        "钻展业务"=>"钻展业务",
        "其它业务"=>"其它业务"
    );

    public static $searchSaleTypes = array(
        ""=>"所有业务",
        "直钻业务"=>"直钻业务",
        "直通车业务"=>"直通车业务",
        "钻展业务"=>"钻展业务",
        "其它业务"=>"其它业务"
    );

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ShopLog the static model class
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
        return '{{shop_log}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('logdate,userid,nick,usernumid,shopid,shopname,shopcatname,shopurl,login_nick, login_password,pic,zuanshi_pic,bigdata_pic,ztc_pic,status,create_date,open_date,stop_date,off_date', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('logdate,userid,nick,usernumid,shopid,shopname,shopcatname,shopurl,login_nick, login_password,pic,zuanshi_pic,bigdata_pic,ztc_pic,status,create_date,open_date,stop_date,off_date', 'safe', 'on'=>'search'),
        );
    }

}