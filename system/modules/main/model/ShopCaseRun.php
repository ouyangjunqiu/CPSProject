<?php

namespace application\modules\main\model;

use cloud\core\model\Model;

class ShopCaseRun extends Model
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ShopCaseRun the static model class
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
        return '{{shop_case_run}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(

            array('caseid, dept, runtype, budget, remark', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('caseid, dept, runtype, budget, remark', 'safe', 'on'=>'search'),
        );
    }

    public function fetchAllByOrder( $condition = '', $params = array()){
        $list = $this->fetchAll( $condition , $params );
        $result = array();
        foreach($list as $row){
            $result[$row["dept"]] = $row;
        }
        krsort($result,SORT_LOCALE_STRING );
        return $result;
    }

    public static function updateCaseBudget($caseid){
        $list = self::model()->fetchAll("caseid=?",array($caseid));
        $sum = 0;
        foreach($list as $row){
            @$sum +=$row["budget"];
        }
        $case = ShopCase::model()->find("caseid=?",array($caseid));
        $case->actual_budget = $sum;
        if($case->save()){
            return true;
        }
        return false;
    }

    public static function summaryAll(){

        $sql = "SELECT COUNT(*) AS c FROM  {{shop_case_run}} AS a LEFT JOIN {{shop_case}} AS b ON a.`caseid`=b.`caseid` LEFT JOIN {{shop}} AS c ON b.nick=c.nick WHERE b.`isstop`='0' AND c.status=0 AND a.`budget`>0";
        $command = \Yii::app()->db->createCommand($sql);
        return  $command->queryScalar();
    }

    public static function summaryZtc(){
        $sql = "SELECT COUNT(*) AS c FROM  {{shop_case_run}} AS a LEFT JOIN {{shop_case}} AS b ON a.`caseid`=b.`caseid` LEFT JOIN {{shop}} AS c ON b.nick=c.nick WHERE  b.`isstop`='0' AND a.`dept`='直通车' AND c.status=0 AND a.`budget`>0";
        $command = \Yii::app()->db->createCommand($sql);
        return  $command->queryScalar();
    }
    public static function summaryZuanshi(){
        $sql = "SELECT COUNT(*) AS c FROM  {{shop_case_run}} AS a LEFT JOIN {{shop_case}} AS b ON a.`caseid`=b.`caseid` LEFT JOIN {{shop}} AS c ON b.nick=c.nick WHERE   b.`isstop`='0' AND a.`dept`='钻展' AND c.status=0 AND a.`budget`>0";
        $command = \Yii::app()->db->createCommand($sql);
        return  $command->queryScalar();
    }

    public static function detailZtc(){
        $sql =<<<EOT
 SELECT c.ztc_pic AS pic,COUNT(DISTINCT c.nick) AS shoptotal,COUNT(*) AS casetotal
 FROM {{shop_case_run}} AS a
LEFT JOIN {{shop_case}}  AS b ON a.`caseid` = b.`caseid`
LEFT JOIN {{shop}} AS c ON b.`nick`=c.`nick`
WHERE a.`budget`>0 AND a.`dept`="直通车" AND c.status=0
 GROUP BY c.ztc_pic
 ORDER BY casetotal DESC
EOT;
        $command = \Yii::app()->db->createCommand($sql);
        $list =  $command->queryAll();
        $result = array();
        foreach($list as $row){
            if(!empty($row["pic"]) && strtoupper($row["pic"]) != "NULL"){
                $result[] = $row;
            }
        }
        return $result;
    }

    public static function detailZuanshi(){
        $sql =<<<EOT
SELECT c.zuanshi_pic AS pic,COUNT(DISTINCT c.nick) AS shoptotal,COUNT(*) AS casetotal
FROM {{shop_case_run}} AS a
LEFT JOIN {{shop_case}}  AS b ON a.`caseid` = b.`caseid`
LEFT JOIN {{shop}} AS c ON b.`nick`=c.`nick`
WHERE a.`budget`>0 AND a.`dept`="钻展" AND c.status=0
 GROUP BY c.`zuanshi_pic`
 ORDER BY casetotal DESC
EOT;
        $command = \Yii::app()->db->createCommand($sql);
        $list =  $command->queryAll();
        $result = array();
        foreach($list as $row){
            if(!empty($row["pic"]) && strtoupper($row["pic"]) != "NULL"){
                $result[] = $row;
            }
        }
        return $result;
    }

}