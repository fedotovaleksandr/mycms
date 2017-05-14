<?php
/**
 * @link http://alkodesign.ru
 */
namespace app\modules\lk\models;

/**
 * @author AlkoDesign <info@alkodesign.ru>
 * @since 2.0
 */
class HelpSections extends \app\components\CommonActiveRecord
{
  CONST MANUFACTURE_TYPE = 1;
  CONST MOTOR_COMPANY = 2;
  CONST CARD_PRODUCER = 3;
  CONST CONTROLLER_TYPE = 4;
  CONST WORKROOM_TYPE = 5;
  
  public $_privateAdminName;
  public $_privatePluralName;
  public $_privateAdminRepr = 'name';
  /**
   * Initialization
   */
  public function init()
  {
      parent::init();
      $this->_privateAdminName = 'Раздел';
      $this->_privatePluralName = 'Разделы';
  }
  
  /**
   * @return string name of db table
   */
  public static function tableName()
  {
      return '{{%lk_page_sections}}';
  }
  
  /**
   * @return array the validation rules.
   */
  public function rules()
  {
    return [
      [['name', 'id_parent', 'id_type', 'desc'], 'safe', 'on' =>['insert', 'update']],
      [['id_parent', 'id_type',], 'number', 'integerOnly' => true, 'on'=>['insert', 'update']],
      [['name'], 'string', 'on'=>['insert', 'update']],
      [['name', 'id_type'], 'required', 'on'=>['insert', 'update']],
      [['id', 'name', 'id_parent', 'id_type', 'desc', 'visible'], 'safe', 'on'=>'search'],
    ];
  }
  
  /**
   * @return array labels of attributes
   */
  public function attributeLabels() {
      return [
          'id' => 'ID',
          'name' => 'Название раздела',
          'id_type' => 'Отображать',
          'id_parent' => 'Родительский раздел',
          'desc' => 'Описание'
      ];
  }
  
  public static function getPageTypes()
  {
    return [
        self::MANUFACTURE_TYPE => 'Производителям тахографов',
        self::MOTOR_COMPANY => 'Автопредприятиям',
        self::CARD_PRODUCER => 'Производителям карт',
        self::CONTROLLER_TYPE => 'Контроллерам',
        self::WORKROOM_TYPE => 'Мастерским'
    ];
  }
  
  /**
   * связь с родителем
   * @return \yii\db\ActiveQuery
   */
  public function getParent()
  {
    return $this->hasOne(self::className(), ['id' => 'id_parent']);
  }
  
  public function getAdminFields()
  {
    return [
        'id',
        'name',
        'id_type',
        'id_parent',
        'desc'
    ];
  }
  
  /**
   * связь с потомками
   * @return type
   */
  public function getChildren()
  {
      return $this->hasMany(self::className(), ['id_parent' => 'id']);
  }

  public $treeParentAttribute = 'id_parent';
  /**
   * @var string name relation, which associated with children
   */
  public $treeChildRelation = 'children';
  
  public function getFieldsDescription()
  {
    return [
        'name' => 'RDbText',
        'id_type' => ['RDbSelect', 'data' => self::getPageTypes()],
        'desc' => 'RDbText',
        'id_parent' => ['RDbSelect', 'data' => self::getListForDropDown($this->id, 0, [], [])],
    ];
  }
  
  /**
   * генерация списка для DropDown
   * @param int $id текущей модели
   * @param int $idParent потомки этого родителя будут добавлены в список
   * @param array $list результирующий список
   * @param array $before список предыдущих предков
   * @return array
   */
  public static function getListForDropDown($id = 0, $idParent = 0, $list = array(), $before = [])
  {
    $rows = self::find()->select('id, name, id_parent')->where('id!=:id and id_parent=:id_parent', [':id' => (int)$id, ':id_parent' => (int)$idParent])->asArray()->all();
    foreach($rows as $row)
    {
      $list[$row['id']] = ($before ? implode('->', $before).'->'.$row['name'] : $row['name']);
      $list = $list + self::getListForDropDown($id, (int)$row['id'], $list, array_merge($before, [$row['name']]));
    }
    return $list;
  }
  
  /**
   * рекурсивный сбор списка разделов
   * @param int $type
   * @param int $idParent
   * @return array
   */
  public static function getSecttionList($type, $idParent = 0)
  {
    $list = array();
    $rows = self::find()
            ->where('id_parent=:id_parent and id_type=:id_type', [':id_parent' => (int)$idParent, ':id_type' => (int)$type])
            ->asArray()
            ->all();
    foreach($rows as $row)
    {
      $list[$row['id']] = $row;
      $list[$row['id']]['childrens'] = self::getSecttionList($type, $row['id']);
    }
    return $list;
  }
    
}