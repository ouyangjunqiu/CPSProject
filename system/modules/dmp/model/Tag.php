<?php
namespace application\modules\dmp\model;

use cloud\core\model\Model;

class Tag extends Model
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Tag the static model class
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
        return '{{dmp_tag}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('t0,t1,t2,name,radios,remark,provider,qscore,max_date', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, t0,t1,t2,name,radios,remark,provider,qscore,max_date', 'safe', 'on' => 'search'),
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

        );
    }

    public static function makeSelectJson(){
        $list = self::model()->fetchAll();
        $result = array();
        foreach($list as $row){
            $result[] = array(
                "id"=>$row["id"],
                "text"=>$row["t0"].">".$row["t1"].">".$row["t2"].">".$row["name"]
            );
        }
        return json_encode($result);
    }

}