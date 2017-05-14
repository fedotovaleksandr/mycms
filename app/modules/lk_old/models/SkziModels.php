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
class SkziModels extends ActiveRecord
{
    /**
     * @return string name of db table
     */
    public static function tableName()
    {
        return '{{%skzi_models}}';
    }
    
    /**
     * Initialization
     */
    public function init()
    {
        parent::init();
        $this->_privateAdminName = 'Модель СКЗИ';
        $this->_privatePluralName = 'Модели СКЗИ';
        
    }
   
    
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['id', 'model', 'external_id', 'softVersion', 'softIssueDate', 'registrationDate', 'lastUpdate', 'manufacturerName', 'manufacturerInn', 'manufacturerOgrn', 'manufacturerAddress', 'isDriverCard', 'isCompanyCard', 'isWorkshopCard', 'isControllerCard'], 'safe', 'on' =>['insert', 'update']],
            [['id', 'model', 'external_id', 'softVersion', 'softIssueDate', 'registrationDate', 'lastUpdate', 'manufacturerName', 'manufacturerInn', 'manufacturerOgrn', 'manufacturerAddress', 'isDriverCard', 'isCompanyCard', 'isWorkshopCard', 'isControllerCard'], 'safe', 'on'=>'search'],
        ];
    }
    
    /**
     * @return array labels of attributes
     */
    public function attributeLabels() {
        
        return [
            'id' => 'ID',
            'model' => 'Название',
            'softVersion' => 'Версия ПО',
            'softIssueDate' => 'Версия ПО',
            'registrationDate' => 'Дата регистрации',
            'lastUpdate' => 'Последнее обновление',
            'manufacturerName' => 'Приозводитель',
            'manufacturerInn' => 'ИНН производителя',
            'manufacturerOgrn' => 'ОГРН',
            'manufacturerAddress' => 'Адрес производителя',
            'isDriverCard' => 'isDriverCard',
            'isCompanyCard' => 'isCompanyCard',
            'isWorkshopCard' => 'isWorkshopCard',
            'isControllerCard' => 'isControllerCard',
            'external_id' => 'Id в системе'
        ];
    }
        
    
    /*for crud admin*/
    public $_privateAdminName; // One item name, used in breadcrums, in header in actionAdmin
    public $_privatePluralName;// Item set name
    public $_privateAdminRepr = 'model';
    
    /**
     * @see \app\modules\privatepanel\components\PrivateModelAdmin::getAdminFields
     * @return array fields in list in back end
     */
    public function getAdminFields()
    {
        return [
            'id',
            'external_id',
            'model',
            'softVersion',
            'softIssueDate',
            'registrationDate',
            'lastUpdate',
            'manufacturerName',
            'manufacturerInn',
            'manufacturerOgrn',
            'manufacturerAddress',
            'isDriverCard',
            'isCompanyCard',
            'isWorkshopCard',
            'isControllerCard',
        ];
            
    }

    /**
     * @see \app\modules\privatepanel\components\PrivateModelAdmin::getFieldsDescription
     * @return array fields in list in back end
     */
    public function getFieldsDescription()
    {
        return [
            'id' => 'RDbText',
            'external_id' => 'RDbText',
            'model' => 'RDbText',
            'softVersion' => 'RDbText',
            'softIssueDate' => 'RDbText',
            'registrationDate' => 'RDbText',
            'lastUpdate' => 'RDbText',
            'manufacturerName' => 'RDbText',
            'manufacturerInn' => 'RDbText',
            'manufacturerOgrn' => 'RDbText',
            'manufacturerAddress' => 'RDbText',
            'isDriverCard' => 'RDbText',
            'isCompanyCard' => 'RDbText',
            'isWorkshopCard' => 'RDbText',
            'isControllerCard' => 'RDbText',
        ];
    }   
    
    /**
     * возврашщает название модели
     * @param int $id первичный ключ
     * @return string
     */
    public static function getName($id)
    {
      $models = self::getModels();
      return array_key_exists($id, $models) ? $models[$id]['name'] : '';
    }
    
    /**
     * получение списка всех моделей
     * @param int $vendorId id производителя
     * @return array [id => [...], ...]
     */
    public static function getModels()
    {
      //self::updateModels();
      static $list = false;
      if($list === FALSE)
      {
        $helper = new \app\modules\lk\components\ProducerHelper();
        $list = $helper->getSkziModels();
      }
      return $list;
    }
    
    /**
     * возвращает тахограф по id
     * @param int $id
     * @return stdClass|NULL
     */
    public static function getObject($id)
    {
      $list = self::getModels();
      foreach($list as $object)
      {
        if($object->id == $id)
        {
          return $object;
        }
      }
      return NULL;
    }
    
    /**
     * список всех моделей СКЗИ
     * @staticvar type $data
     * @return type
     */
    public static function getDataForDropDownList($required = FALSE)
    {
      if($required)
      {
        $data = [];
      }
      else
      {
        $data = [' ' => ' '];
      }
      $helper = new \app\modules\lk\components\ProducerHelper();
      $modelList = $helper->getSkziModels();
      foreach($modelList as $object)
      {
        $data[$object->id] = $object->model;
      }
      return $data;
    }
    
    /**
     * список версий ПО
     * @return array
     */
    public static function getSoftVersionList()
    {
      $data = [];
      $helper = new \app\modules\lk\components\ProducerHelper();
      $modelList = $helper->getSkziModels();
      foreach($modelList as $object)
      {
        $data[$object->id] = [];
        $versions = explode(';', $object->softVersion);
        foreach($versions as $version)
        {
          $data[$object->id][$version] = $version;
        }
      }
      return $data;
    }
    
    /**
     * обновление списка моделей SKZI
     */
    public static function updateModels()
    {
      $helper = new \app\modules\lk\components\ProducerHelper();
      $modelList = $helper->getSkziModels();
      foreach($modelList as $object)
      {
        if(($model = self::findOne(['external_id' => $object->id])))
        {
          $model->setScenario('update');
        }
        else
        {
          $model = new SkziModels();
          $model->setScenario('insert');
        }
        $model->model = $object->model;
        $model->softVersion = isset($object->softVersion) ? $object->softVersion : '';
        $model->softIssueDate = isset($object->softIssueDate) ? $object->softIssueDate : '';
        $model->registrationDate = isset($object->registrationDate) ? $object->registrationDate : '';
        $model->lastUpdate = isset($object->lastUpdate) ? $object->lastUpdate : '';
        $model->manufacturerName = isset($object->manufacturerName) ? $object->manufacturerName : '';
        $model->manufacturerInn = isset($object->manufacturerInn) ? $object->manufacturerInn : '';
        $model->manufacturerAddress = isset($object->manufacturerAddress) ? $object->manufacturerAddress : '';
        $model->manufacturerOgrn = isset($object->manufacturerOgrn) ? $object->manufacturerOgrn : '';
        $model->isDriverCard = isset($object->isDriverCard) ? (int)$object->isDriverCard : 0;
        $model->isCompanyCard = isset($object->isCompanyCard) ? (int)$object->isCompanyCard : 0;
        $model->isWorkshopCard = isset($object->isWorkshopCard) ? (int)$object->isWorkshopCard : 0;
        $model->isControllerCard = isset($object->isControllerCard) ? (int)$object->isControllerCard : 0;
        $model->save();
      }
    }
    
    /**
     * Modifies action column in backend
     * A button "clone" is added to action buttons
     * @see \app\modules\privatepanel\components\PrivateModelAdmin::getGridButtonColumns
     * @param array $columnParams source array of actions
     * @return array
     */
    public function getGridButtonColumns($columnParams = array('buttons'=>array(), 'template'=>'')) {
        unset($columnParams['buttons']['update']);
        unset($columnParams['buttons']['delete']);
        unset($columnParams['buttons']['log']);
        return $columnParams;
    }
}
