<?php
/**
 * @link http://alkodesign.ru
 */
namespace app\modules\lk\models;

/**
 * @author AlkoDesign <info@alkodesign.ru>
 * @since 2.0
 */
class HelpPages extends \app\components\CommonActiveRecord
{
  public $_privateAdminName;
  public $_privatePluralName;
  public $_privateAdminRepr = 'name';
  /**
   * Initialization
   */
  public function init()
  {
      parent::init();
      $this->_privateAdminName = 'Страница';
      $this->_privatePluralName = 'Страницы';
  }
  
  /**
   * @return string name of db table
   */
  public static function tableName()
  {
      return '{{%lk_page_}}';
  }
  
  /**
   * @return array the validation rules.
   */
  public function rules()
  {
    return [
      [['id_section', 'alias', 'name', 'desc'], 'safe', 'on' =>['insert', 'update']],
      [['id_section'], 'number', 'integerOnly' => true, 'on'=>['insert', 'update']],
      [['name', 'desc'], 'string', 'on'=>['insert', 'update']],
      [['name', 'id_section'], 'required', 'on'=>['insert', 'update']],
      [['id_section', 'alias', 'name', 'desc'], 'safe', 'on'=>'search'],
    ];
  }
  
  /**
   * @return array labels of attributes
   */
  public function attributeLabels() {
      return [
          'id' => 'ID',
          'name' => 'Название страницы',
          'id_section' => 'Раздел',
          'desc' => 'Содержание'
      ];
  }
  
  /**
   * связь с родителем
   * @return \yii\db\ActiveQuery
   */
  public function getSection()
  {
    return $this->hasOne(HelpSections::className(), ['id' => 'id_section']);
  }
  
  public function getAdminFields()
  {
    return [
        'id',
        'name',
        'id_section',
        'desc'
    ];
  }
  
  public function getFieldsDescription()
  {
    return [
        'id_section' => ['RDbSelect', 'data' => HelpSections::getListForDropDown($this->id, 0, [], [])],
        'name' => 'RDbText',
        'desc' => 'RDbText',
    ];
  }
  
  /**
   * возвращает список страниц отсортированных по разделам
   * @param int $type
   * @return array
   */
  public static function getPageList($type)
  {
    $list = array();
    $sections = HelpSections::find()->select('id')->where(['id_type' => (int)$type])->column();
    if($sections)
    {
      $pageList = self::find()->where(['IN', 'id_section', $sections])->all();
      foreach($pageList as $pageRow)
      {
        $list[$pageRow['id_section']][$pageRow['id']] = $pageRow;
      }
    }
    return $list;
  }
    
    
}