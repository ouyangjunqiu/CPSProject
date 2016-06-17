<?php
/**
 * @file ShopTodoList.php
 * @author ouyangjunqiu
 * @version Created by 16/5/16 16:34
 */

namespace application\modules\main\model;


use cloud\core\model\Model;
use cloud\core\utils\String;

class ShopTodoList extends Model
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Shop the static model class
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
        return '{{shop_todolist}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(

            array('logdate,nick,priority,pic,content,status,creator,create_time,updator,update_time', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('logdate,nick,priority,pic,content,status,creator,create_time,updator,update_time', 'safe', 'on'=>'search'),
        );
    }

    public static function fetchHistoryListByNick($nick){
        $startDate = date("Y-m-d",strtotime("-15 days"));
        $endDate =  date("Y-m-d",strtotime("-2 days"));

        $history = self::model()->fetchAll("logdate>=? AND logdate<=? AND nick=? AND status=?",array($startDate,$endDate,$nick,0));
        foreach($history as &$row){
            $row["title"] = String::ireplaceUrl($row["content"],"<small>[链接]</small>");
            $row["md5"] = md5($row["nick"]);
        }
        return $history;
    }

    public static function fetchCurrentListByNick($nick){
        $startDate = date("Y-m-d",strtotime("-2 days"));
        $endDate =  date("Y-m-d",strtotime("+7 days"));
        $result = self::model()->fetchAll("logdate>? AND logdate<? AND nick=? AND status!=?",array($startDate,$endDate,$nick,2));
        $todolist = array();

        foreach($result as $row){
            if(strtotime($row["logdate"])>=strtotime("+1 days")){
                $key = date("Ymd",strtotime("+1 days"));
            }else{
                $key = date("Ymd",strtotime($row["logdate"]));
            }

            $todolist[$key][] = array_merge(
                $row,
                array(
                    "title"=>String::ireplaceUrl($row["content"],"<small>[链接]</small>"),
                    "md5" => md5($row["nick"]),
                    "days"=>ceil((strtotime($row["logdate"])-strtotime(date("Y-m-d")))/3600/24)
                )
            );

        }

        $list = array();
        for($i=-1;$i<=1;$i++){
            $key = date("Ymd",strtotime("$i days"));
            if(isset($todolist[$key])){
                $list[] = $todolist[$key];
            }else{
                $list[] = array();
            }
        }
        return $list;
    }

    public static function fetchRangeListByNick($nick,$logdate){
        $startDate = date("Y-m-d",strtotime("-2 days",strtotime($logdate)));
        $endDate =  date("Y-m-d",strtotime("+2 days",strtotime($logdate)));

        $result = self::model()->fetchAll("logdate>? AND logdate<? AND nick=? AND status!=?",array($startDate,$endDate,$nick,2));
        $todolist = array();

        foreach($result as $row){

            $key = date("Ymd",strtotime($row["logdate"]));

            $todolist[$key][] = array_merge(
                $row,
                array(
                    "title"=>String::ireplaceUrl($row["content"],"<small>[链接]</small>"),
                    "md5" => md5($row["nick"]),
                    "days"=>ceil((strtotime($row["logdate"])-strtotime(date("Y-m-d")))/3600/24)
                )
            );

        }

        $list = array();
        for($i=-2;$i<=2;$i++){
            $key = date("Ymd",strtotime("$i days",strtotime($logdate)));
            $datestr = date("Y.m.d",strtotime("$i days",strtotime($logdate)));
            if(isset($todolist[$key])){
                $list[] = array("list"=>$todolist[$key],"logdate"=>$datestr);
            }else{
                $list[] = array("list"=>array(),"logdate"=>$datestr);
            }
        }
        return $list;

    }

    public static function fetchListByPic($pic){
        $startDate = date("Y-m-d",strtotime("-15 days"));
        $endDate =  date("Y-m-d");
        $result = self::model()->fetchAll("logdate>=? AND logdate<=? AND pic=? AND status=?",array($startDate,$endDate,$pic,0));
        foreach($result as &$row){
            $row["title"] = String::ireplaceUrl($row["content"],"<small>[链接]</small>");
            $row["days"] = ceil((strtotime(date("Y-m-d"))-strtotime($row["logdate"]))/3600/24);
            $row["md5"] = md5($row["nick"]);
        }
        return $result;

    }


}