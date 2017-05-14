<?php
/**
 * @link http://alkodesign.ru
 */
namespace app\modules\lk\models\producer;

/**
 * A class of log of operations in back end for Alchemy CMS (Yii2)
 * Such actions like create, update, delete and so on are logged in DB if they are performed in back end.
 * 
 * @author AlkoDesign <info@alkodesign.ru>
 * @since 2.0
 */
class Docs extends \app\components\CommonActiveRecord
{
  CONST DEVICE_TACHOGRAPH = 1;
  CONST DEVICE_SKZI = 2;
  CONST DEVICE_CARD = 3;
  
  CONST WAIT_CHECK_DOC = 0;
  CONST ACTIVE_DOC = 1;
  CONST DEACTIVE_DOC = 2;
  CONST BAD_DOC = 3;
  CONST OLD_DOC = 4;
  
  public $availability;
  
  public $moderatorComment = '';
    /**
     * @return string name of db table
     */
    public static function tableName()
    {
        return '{{%producer_docs}}';
    }
    
    public function afterFind()
    {
      $availabilities = $this->getAvailability()->all();
      $this->availability = [];
      foreach($availabilities as $one)
      {
        $this->availability[] = $one->id;
      }
      return parent::afterFind();
    }
    
    /**
     * Initialization
     */
    public function init()
    {
        parent::init();
        $this->_privateAdminName = 'Документ';
        $this->_privatePluralName = 'Документы';
    }
    
    /**
     * возвращает текст последнего комментария из модели DocHistory
     * @return string
     */
    public function getLastModeratorComment()
    {
      $model = DocHistory::find()->where('id_doc=:id_doc AND text!=:text', [':id_doc' => $this->id, ':text' => ''])->orderBy('add_date DESC')->asArray()->one();
      if($model)
      {
        return $model['text'];
      }
      return '';
    }
   
    
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['name', 'id_user', 'id_type', 'file', 'id_model', 'id_device_type', 'availability'], 'safe', 'on' =>['insert']],
            [['name', 'id_type', 'file', 'availability'], 'safe', 'on' =>['update']],
            [['id_user', 'id_type', 'id_model', 'id_device_type', 'id_parent', 'status'], 'number', 'integerOnly' => true, 'on'=>['insert']],
            [['id_type', 'id_parent'], 'number', 'integerOnly' => true, 'on'=>['insert', 'update']],
            [['name'], 'string', 'on'=>['insert', 'update']],
            [['name'], 'required', 'on'=>['insert', 'update']],
            [['file'], 'file', 'on'=>['insert', 'update']],
            [['id', 'name', 'id_user', 'id_type', 'file', 'version', 'id_model', 'id_device_type', 'id_parent', 'filesize'], 'safe', 'on'=>'search'],
            [['id', 'name', 'id_user', 'id_type', 'file', 'version', 'id_model', 'id_device_type', 'id_parent', 'filesize', 'moderatorComment'], 'safe', 'on'=>'check'],
        ];
    }
    
    public static function getFileDirectory()
    {
      return \yii::getAlias('@web2').'/files/producer/docs/';
    }
    
    public function getFilePath()
    {
      return $this->getFileDirectory().$this->file;
    }
    
    /**
     * сохранение файла
     * @param type $fileInstance
     * @return boolean
     */
    public function uploadFile()
    {
      if(!$this->file)
      {
        $this->addError('file', 'Загрузите файл');
      }
      if ($this->validate()) 
      {
        \app\components\SiteHelper::checkFolderPath($this->getFileDirectory());
        $fileName = $this->file->baseName . '.' . $this->file->extension;
        if(file_exists($_SERVER['DOCUMENT_ROOT'].$this->getFileDirectory() .$fileName))
        {
          $fileName = $this->file->baseName.'_'.md5(microtime().rand()). '.' . $this->file->extension;
        }
        if($this->file->saveAs($_SERVER['DOCUMENT_ROOT'].$this->getFileDirectory() . $fileName))
        {
          $this->file = $fileName;
          return true;
        }
        return false;
        
      }
      else 
      {
        return false;
      }
    }
    
    /**
     * @return array labels of attributes
     */
    public function attributeLabels() {
        
        return [
            'id' => 'ID',
            'name' => 'Название документа',
            'id_user' => 'Пользователь',
            'id_type' => 'Тип',
            'file' => 'Файл',
            'version' => 'Версия',
            'id_model' => 'Модель',
            'id_device_type' => 'Тип устройства',
            'add_date' => 'Дата добавления',
            'id_parent' => 'Предыдущая версия',
            'filesize' => 'Размер(кб)',
            'status' =>  'Статус',
            'name' => 'Название',
            'availability' => 'Доступен'
        ];
    }
    
    /**
     * список с типом устройств
     * @return array
     */
    public static function getDeviceTypes()
    {//id_device_type
      return[
          self::DEVICE_TACHOGRAPH => 'Тахограф',
          self::DEVICE_SKZI => 'СКЗИ',
          self::DEVICE_CARD => 'Карты'
      ];
    }
    
    /**
     * возможные статусы документа
     * @return array
     */
    public static function getStatusItems()
    {
      return [
          self::WAIT_CHECK_DOC => 'Подан на проверку',
          self::ACTIVE_DOC => 'Активен',
          self::DEACTIVE_DOC => 'Деактивирован',
          self::BAD_DOC => 'Отклонен',
          self::OLD_DOC => 'Старая версия'
      ];
    }
    
    /**
     * возвращает текстовое представление статуса
     * @return string|int
     */
    public function getStringStatus()
    {
      $statusItems = self::getStatusItems();
      return isset($statusItems[$this->status]) ? $statusItems[$this->status] : $this->status;
    }

    /**
     * связь с пользователем
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
      return $this->hasOne(\app\models\TUserIndentity::className(), ['id' => 'id_user']);
    }
    
    /**
     * связь с моделью
     * @return \yii\db\ActiveQuery
     */
    public function getModels()
    {
      switch($this->id_device_type)
      {
        case 1: return $this->hasOne(\app\modules\lk\models\TachographModels::className(), ['id' => 'id_model']);break;
        case 2: return $this->hasOne(\app\modules\lk\models\SkziModels::className(), ['id' => 'id_model']);break;
        case 3: return $this->hasOne(\app\modules\lk\models\TachographModels::className(), ['id' => 'id_model']);break;
          
      }
      return $this->hasOne(\app\modules\lk\models\TachographModels::className(), ['id' => 'id_model']);
    }
    
    /**
     * связь с родителем
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
      return $this->hasOne(self::className(), ['id' => 'id_parent']);
    }
    
    /**
     * список типов доступов
     * @return array
     */
    public function getAccessTypes()
    {
      static $list;
      if(is_array($list))
      {
        return $list;
      }
      return $list = \yii\helpers\ArrayHelper::map(AccessTypes::find()->asArray()->all(), 'id', 'name');
    }
    
    public function getAccessTypesOptins()
    {
      $list = $this->getAccessTypes();
      $result = [];
      $availabaty = $this->getAvailability()->select('id')->column();
      foreach($list as $key => $value)
      {
        if(in_array($key, $availabaty))
        {
          $result[$key] = ['default-value' => 'checked'];
        }
        else
        {
          $result[$key] = ['default-value' => ''];
        }
      }
      return $result;
    }
    
    public function getAvailability()
    {
        return $this->hasMany(AccessTypes::className(), ['id' => 'id_accestype'])->viaTable('{{%producer_docs_access}}', ['id_doc' => 'id']);
    }
    
    public static function getTypes()
    {//id_type
      return[
          1 => 'Инструкция',
          2 => 'Методическая рекомендация',
          3 => 'Фотография'
      ];
    }
    
    /**
     * возвращает имя типа документа по id
     * @param int $id
     * @return string
     */
    public static function getTypeName($id)
    {
      $types = self::getTypes();
      return array_key_exists($id, $types) ? $types[$id] : 'Not found';
    }
        
    
    /*for crud admin*/
    public $_privateAdminName; // One item name, used in breadcrums, in header in actionAdmin
    public $_privatePluralName;// Item set name
    public $_privateAdminRepr = 'name';
    
    /**
     * @see \app\modules\privatepanel\components\PrivateModelAdmin::getAdminFields
     * @return array fields in list in back end
     */
    public function getAdminFields()
    {
        return [
            'id',
            'name',
            'id_user',
            'id_type',
            'version',
            'id_model',
            'add_date',
            'id_parent',
            'filesize',
            'file',
            'status'
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

    /**
     * @see \app\modules\privatepanel\components\PrivateModelAdmin::getFieldsDescription
     * @return array fields in list in back end
     */
    public function getFieldsDescription()
    {
        return [
            'name' => 'RDbText',
            'id_user' => ['RDbRelation', 'user'],
            'id_type' => ['RDbSelect', 'data' => self::getTypes()],
            'file' => 'RDbFile',
            'version' => 'RDbText',
            'id_model' => ['RDbRelation', 'models'],
            'id_device_type' => ['RDbSelect', 'data' => self::getDeviceTypes()],
            'add_date' => 'RDbDate',
            'id_parent' => ['RDbRelation', 'parent','treeParentRel'=>'parent', 'treeChildRel' => 'children', 'condition'],
            'filesize' => 'RDbText',
            'status' => ['RDbSelect', 'data' => self::getStatusItems()],
            'availability' => ['RDbRelation', 'availability'],
        ];
    }
    
    public function beforeSave($insert)
    {
      $this->id_parent = (int)$this->id_parent;
      if($insert)
      {//указываем владельца
        $this->id_user = \Yii::$app->user2->getId();
        if($this->id_parent && ($parent = self::findOne(['id' => (int)$this->id_parent])))
        {//увеличивается номер версии
          $this->version = $parent->version + 1;
        }
      }
      else
      {
        //если активируется, то родитель становится не активнымым
        if($this->id_parent && $this->status == 1)
        {
          $parent = $this->parent;
          while($parent)
          {
            if($parent->status == 1)
            {
              $parent->status = 4;
              $parent->save();
            }
            $parent = $parent->parent;
          }
        }
        //если деактивируется, то родитель становится активнымым
        if($this->id_parent && $this->status != 1 && ($parent = self::findOne(['id' => (int)$this->id_parent])) && $parent->status == 4)
        {
          $parent->status = 1;
          $parent->save();
        }
      }
      //поиск первый родитель(основного документа)
      if($this->id_parent > 0 && $this->first_parent == 0 && $this->parent)
      {
        //ищем родителя
        $parent = $this->parent;
        $lastParent = $this;
        while ($parent && $parent->first_parent == 0)
        {
          $parent = $parent->parent;
          if($parent)
          {
            $lastParent;
          }
        }
        if($parent && $parent->first_parent > 0)//если значение первого предка найдено
        {
          $this->first_parent = $parent->first_parent;
        }
        elseif($lastParent && $lastParent->id_parent == 0)//если найден основной документ
        {
          $this->first_parent = $lastParent->id;
        }
      }
      //размер файла
      $path = $_SERVER['DOCUMENT_ROOT'].$this->getFilePath();
      if(file_exists($path))
      {
        $this->filesize = filesize($path) / 1024;//в килобайтах
      }
      else
      {
        $this->addError('file', 'Файл не найден');
      }
      return parent::beforeSave($insert);
    }
    
    public function afterSave($insert, $changedAttributes)
    {
      if(is_array($this->availability))
      {
        //обновление информации о доступе
        \Yii::$app->db->createCommand("DELETE FROM {{%producer_docs_access}} WHERE id_doc={$this->id}")->execute();
        foreach($this->availability as $availability)
        {
          $command = \Yii::$app->db->createCommand("INSERT INTO {{%producer_docs_access}} (`id_doc`, `id_accestype`) VALUES (:id_doc,:id_accestype)");
          $command->bindValue(':id_doc', (int)$this->id);
          $command->bindValue(':id_accestype', (int)$availability);
          $command->execute();
        }
      }
      //первый родитель
      if($this->id_parent == 0 && $this->first_parent == 0)
      {
        $this->first_parent = $this->id;
        $this->save(FALSE);
      }
      //запись в лог
      if(isset($changedAttributes['status']) && $changedAttributes['status'] != $this->status)
      {
        $history = new DocHistory();
        $history->setScenario('insert');
        $history->id_doc = $this->id;
        $history->last_status = $changedAttributes['status'];
        $history->next_status = $this->status;
        $history->text = $this->moderatorComment;
        $history->save();        
      }
      return parent::afterSave($insert, $changedAttributes);
    }
    
    public function afterDelete()
    {
      //удаление файла
      $fullPath = $_SERVER['DOCUMENT_ROOT'].$this->getFilePath();
      if(file_exists($fullPath) && !is_dir($fullPath))
      {
        unlink($fullPath);
      }
      //удаление связанных документов
      \Yii::$app->db->createCommand("DELETE FROM {{%producer_docs_access}} WHERE id_doc={$this->id}")->execute();
      return parent::afterDelete();
    }
    
    public static function getDocModels($userId)
    {
      $list = [];
      /*foreach(self::getDeviceTypes() as $key => $value)
      {
        $list[$key] = [
          'name' => $value,
          'models' => []
        ];
      }
      $docs = self::find()->where(['id_user' => (int)$userId])->groupBy('id_model, id_device_type')->asArray()->all();
      foreach($docs as $doc)
      {
        $list[$doc['id_device_type']]['models'][$doc['id_model']] = ['name' => self::getDeviceName($doc['id_model'], $doc['id_device_type'])];
      }*/
      return $list;
    }
    
    /**
     * список актуальных документов, удовлетворяющих параметрам
     * @param int $userId
     * @param int $idModel
     * @param int $idDeviceType
     * @return array
     */
    public static function getDocuments($userId, $idModel, $idDeviceType, $orderBy = ['add_date' => SORT_ASC, 'version' => SORT_DESC])
    {
      return self::find()
              ->where(['id_model' => (int)$idModel, 'id_user' => (int)$userId, 'id_device_type' => (int)$idDeviceType])
              ->orderBy($orderBy)
              //->groupBy('id_model, id_device_type')
              ->limit(1000)
              ->all();
    }
    
    /**
     * возвращает название устройства
     * @param type $idModel
     * @param type $idType
     * @return string
     */
    public static function getDeviceName($idModel, $idType)
    {
      $name = '';
      switch($idType)
      {
        case \app\modules\lk\models\producer\Docs::DEVICE_TACHOGRAPH:
          $object = \app\modules\lk\models\TachographModels::getObject($idModel);
          $name = $object ? "Тахограф \"{$object->model}\"" : '';
          break;
        case \app\modules\lk\models\producer\Docs::DEVICE_SKZI:
          $object = \app\modules\lk\models\SkziModels::getObject($idModel);
          $name = $object ? "СКЗИ \"{$object->model}\"" : '';
          break;
        case \app\modules\lk\models\producer\Docs::DEVICE_CARD:
          $object = \app\modules\lk\models\CardModels::getObject($idModel);
          $name = $object ? "Карта \"{$object->model}\"" : '';
          break;
      }
      return $name;
    }
    
    public function getGridButtonColumns($columnParams = array('buttons'=>array(), 'template'=>'')) {
        if(\Yii::$app->user->can(\Yii::$app->controller->getAccessOperationName('activate')) && $this->getScenario() == 'check')
        {
            $columnParams['template'] .= ' {activate}';
            $columnParams['buttons']['activate'] = function ($url, $model, $key) 
            {
                $options = array_merge([
                    'title' => 'Активировать',
                    'aria-label' => 'Активировать',
                    'class' => 'btn btn-blue btn-sm',
                ], []);
                return \yii\helpers\Html::a('<i class="fa fa-hourglass-start"></i>', '/private/docs/activate?id='.$model->id, $options);
            };
        }
        return $columnParams;
    }
    
    public static function getPreviusVersionDropdown()
    {
      $list = ['' => ''];
      $userId = \Yii::$app->user2->getId();
      $list = $list + \yii\helpers\ArrayHelper::map(self::find()->select('id, name')->where(['id_user' => $userId])->asArray()->all(), 'id', 'name');
      return $list;
    }
    
    public static function getFormatedDate($format = 'd.m.Y', $date = NULL)
    {
      if($date)
      {
        return date($format, strtotime($date));
      }
      return '';
    }
    
    
    public static function getFileSize($filesize = NULL)
    {
      if($filesize < 1024)
      {
        return "{$filesize} Кб";
      }
      else
      {
        return round($filesize/1024.0).' Mб';
      }
    }

    public function beforeDelete()
    {
      $chidlrens = $this->getChildren()->all();
      foreach($chidlrens as $chidlren)
      {
        $chidlren->id_parent = $this->id_parent;
        $chidlren->save();
      }
      return parent::beforeDelete();
    }
}
