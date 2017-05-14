<?php
/**
 * @link http://alkodesign.ru
 */
namespace app\modules\lk\models;

use yii\db\ActiveRecord as ActiveRecord;

/**
 * A class of log of operations in back end for Alchemy CMS (Yii2)
 * Such actions like create, update, delete and so on are logged in DB if they are performed in back end.
 * 
 * @author AlkoDesign <info@alkodesign.ru>
 * @since 2.0
 */
class TableSettings extends ActiveRecord
{
    /**
     * @return string name of db table
     */
    public static function tableName()
    {
        return '{{%table_settings}}';
    }
    
    /**
     * Initialization
     */
    public function init()
    {
        parent::init();
        $this->_privateAdminName = 'Настройка таблицы';
        $this->_privatePluralName = 'Настройки таблиц';
        
    }
    
    /**
     * преобразование json поля "view_fields" в массив 
     * @return null
     */
    public function afterFind()
    {
      $dataArr = json_decode($this->view_fields);
      $this->view_fields = $dataArr ? $dataArr : [];
      return parent::afterFind();
    }
    
    /**
     * возвращает список полей, отображаемых пользователю с id=$userId  в теблице $table
     * @param int $userId id пользователя
     * @param string $table название таблицы
     * @return array
     */
    public static function getTableFieldList($userId, $table)
    {
      $result = array();
      $model = self::findOne(['id_user' => (int)$userId, 'table' => (string)$table]);
      $fields = \app\modules\lk\components\Fields::getFields($table);
      if($model && $fields)
      {
        foreach($model->view_fields as $fieldKey)
        {
          if(array_key_exists($fieldKey, $fields))
          {
            $result[$fieldKey] = $fields[$fieldKey];
          }
        }
        foreach($fields as $fieldKey => $field)
        {
          if($field['view_required'])
          {
            $result[$fieldKey] = $fields[$fieldKey];
          }
        }
      }
      elseif($fields)
      {
        $result = $fields;
      }
      return $result;
    }
    
    /**
     * возвращает количество строк в таблице $table в настройках пользователя с id=$userId.
     * По-умолчанию возвращает 20.
     * @param int $userId
     * @param string $table
     * @return int
     */
    public static function getPageLimit($userId, $table)
    {
      $model = self::findOne(['id_user' => (int)$userId, 'table' => (string)$table]);
      if($model)
      {
        return $model->page_limit;
      }
      return 20;
    }
    
    /**
     * сохранаяет в настройках значение количества строк на странице
     * @param int $userId
     * @param string $table
     * @param int $pageLimit
     */
    public static function setPageLimit($userId, $table, $pageLimit)
    {
      $model = self::findOne(['id_user' => (int)$userId, 'table' => (string)$table]);
      if($model)
      {
        $model->setScenario('update');
      }
      else
      {
        $model = new TableSettings;
        $model->setScenario('insert');
        $model->table = $table;
        $fileds = \app\modules\lk\components\Fields::getFields($table);
        if($fileds)
        {
          $model->view_fields = array_keys($fileds);
        }
      }
      $model->page_limit = (int)$pageLimit;
      return $model->save();
    }

    public function beforeSave($insert)
    {
      //обязательные поля должны всегда присутствовтать
      $tableFields = \app\modules\lk\components\Fields::getFields($this->table);
      if($tableFields === FALSE)
      {
        $this->addError('table', 'Таблица не найдена');
      }
      $requiredFileds = [];
      foreach($tableFields as $fieldName => $option)
      {
        if($option['required'])
        {
          $requiredFileds[] = $fieldName;
        }
      }
      if(is_array($this->view_fields))
      {
        $this->view_fields = array_unique($this->view_fields + $requiredFileds);
      }
      else
      {
        $this->view_fields = $requiredFileds;
      }
      //преобразование в json
      $this->view_fields = json_encode($this->view_fields);
      $this->id_user= \Yii::$app->user2->getId();
      if((int)$this->page_limit <= 0)
      {
        $this->page_limit = 20;
      }
      return parent::beforeSave($insert);
    }
    
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['id', 'table', 'id_user', 'view_fields'], 'safe', 'on' =>['insert', 'update']],
            [['id', 'id_user', 'page_limit'], 'number', 'integerOnly' => true, 'on'=>['insert', 'update']],
            [['page_limit'], 'number', 'max'=>100, 'min' => 1, 'integerOnly' => true, 'on'=>['insert', 'update']],
            [['id', 'table', 'id_user', 'view_fields', 'page_limit'], 'safe', 'on'=>'search'],
        ];
    }
    
    /**
     * @return array labels of attributes
     */
    public function attributeLabels() {
        
        return [
            'table' => 'Таблица',
            'id_user' => 'Пользователь',
            'page_limit' => 'Количество строк в таблице'
        ];
        
    }
    
    /**
     * Relation to usre, who preformed operations.
     * @return ActiveQueryInterface the relational query object.
     */
    public function getUser()
    {
        return $this->hasOne(\app\models\UserIndentity::className(), ['id' => 'user_id']);
    }
    
    
    /*for crud admin*/
    public $_privateAdminName; // One item name, used in breadcrums, in header in actionAdmin
    public $_privatePluralName;// Item set name
    public $_privateAdminRepr = 'table';
    
    /**
     * @see \app\modules\privatepanel\components\PrivateModelAdmin::getAdminFields
     * @return array fields in list in back end
     */
    public function getAdminFields()
    {
        return [
            'table',
            'id_user',
            'view_fields'
        ];
            
    }

    /**
     * @see \app\modules\privatepanel\components\PrivateModelAdmin::getFieldsDescription
     * @return array fields in list in back end
     */
    public function getFieldsDescription()
    {
        return [
            'id_user' => array('RDbRelation', 'user'),
            'table' => 'RDbText',
            'view_fields' =>['RDbText', 'forceTextArea' => 'forceTextArea']
        ];
    }   
}
