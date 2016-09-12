<?php
namespace application\modules\tool\model;
use cloud\core\model\Model;

/**
 * @file Category.php
 * @author ouyangjunqiu
 * @version Created by 16/9/12 15:52
 */
class Category extends Model
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Category the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static $tree_text = array();

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'category';
    }

    public function primaryKey()
    {
        return 'cid';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('cid', 'required'),
            array('is_parent', 'numerical', 'integerOnly' => true),
            array('cid, parent_cid, sort_order', 'length', 'max' => 11),
            array('name', 'length', 'max' => 50),
            array('status', 'length', 'max' => 7),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('cid, parent_cid, name, is_parent, status, sort_order', 'safe', 'on' => 'search'),
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


    public static function getTreeText($child_id, $split = '>')
    {
        $category = self::model()->findByPk($child_id);

        if ($category === null) {
            return implode($split, self::$tree_text);
        }

        self::$tree_text[] = $category->name;
        if ($category->parent_cid > 0) {
            self::getTreeText($category->parent_cid);
        }

        return implode($split, array_reverse(self::$tree_text, true));
    }


    public static function getTreeText1($child_id, $split = '>')
    {
        $tree_text = array();
        $category = self::model()->findByPk($child_id);

        if ($category === null) {
            return implode($split, $tree_text);
        }

        $tree_text[] = $category->name;
        if ($category->parent_cid > 0) {
            $tree_text[] = self::getTreeText1($category->parent_cid, $split);
        }

        return implode($split, array_reverse($tree_text, true));
    }

}