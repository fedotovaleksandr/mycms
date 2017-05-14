<?php
/**
 * @link http://alkodesign.ru
 */
namespace app\modules\lk\models\producer;
use yii\base\Model;


/**
 * The class of adverts for Alchemy CMS (Yii2)
 * 
 * @author AlkoDesign <info@alkodesign.ru>
 * @since 2.0
 */
class SkziForm extends Model
{
  public $id;
  public $equipTypeId;
  public $softwareVersion;
  public $serialNumberFull;
  public $createDate;
  public $verifDate;
  public $verifExpires;
  
  public function loadSkzi($id)
  {
    $helper = new \app\modules\lk\components\ProducerHelper();
    $model = $helper->findSkziById($id);
    if($model)
    {
      if(isset($model->equipTypeId)) 
      {
        $this->equipTypeId = $model->equipTypeId;
      }
      if(isset($model->equipTypeSoftVersion)) 
      {
        $this->softwareVersion = $model->equipTypeSoftVersion;
      }
      if(isset($model->serialNumberFull)) 
      {
        $this->serialNumberFull = $model->serialNumberFull;
      }
      if(isset($model->createDate)) 
      {
        $this->createDate = $model->createDate;
      }
      if(isset($model->verifDate)) 
      {
        $this->verifDate = $model->verifDate;
      }
      if(isset($model->verifExpires)) 
      {
        $this->verifExpires = $model->verifExpires;
      }
    }
    else
    {
      throw new \yii\web\HttpException(404, 'Модель не найдена');
    }
  }
  
  public function loadFromObject($object)
  {
      $this->id = $object->id;
      if(isset($object->equipTypeId)) 
      {
        $this->equipTypeId = $object->equipTypeId;
      }
      if(isset($object->equipTypeSoftVersion)) 
      {
        $this->softwareVersion = $object->equipTypeSoftVersion;
      }
      if(isset($object->serialNumberFull)) 
      {
        $this->serialNumberFull = $object->serialNumberFull;
      }
      if(isset($object->createDate)) 
      {
        $this->createDate = date('c', strtotime($object->createDate)+7200);
      }
      if(isset($object->verifDate)) 
      {
        $this->verifDate = date('c', strtotime($object->verifDate)+7200);
      }
      if(isset($object->verifExpires)) 
      {
        $this->verifExpires = date('c', strtotime($object->verifExpires)+7200);
      }
  }
  
  public function rules()
  {
    return [
        [['id', 'equipTypeId', 'softwareVersion', 'serialNumberFull', 'createDate', 'verifDate', 'verifExpires', 'id'], 'safe', 'on' =>['insert', 'update']],
        [['equipTypeId', 'serialNumberFull', 'createDate', 'verifDate', 'verifExpires'], 'required', 'on' =>['insert', 'update']],
        [['equipTypeId', 'id'], 'number', 'integerOnly' => true, 'on'=>['insert', 'update']],
    ];
  }
  
  public function attributeLabels() {
    return [
        'equipTypeId' => 'Модель',
        'softwareVersion' => 'Версия ПО',
        'serialNumberFull' => 'Серийный номер',
        'createDate' => 'Дата изготовления',
        'verifDate' => 'Дата проверки',
        'verifExpires' => 'Срок действия проверки'
    ];
  }
  
  /**
   * 
   * @see \app\modules\lk\models\SkziModels::getModels()
   */
  public function getModels()
  {
    return \app\modules\lk\models\SkziModels::getModels();
  }
  
  /**
   * список версий ПО
   * @return array
   */
  public function getVersionItems()
  {
    return [
        1 => '1.0',
        2 => '1.2'
    ];
  }
  
  public function beforeSave()
  {
    return true;
  }
  
  /**
   * отправка данных на сохранение в систему
   * @return boolean
   */
  public function save(&$debagInfo)
  {
    if($this->beforeSave())
    {
      $params = array();
      $params['serialNumberFull'] = $this->serialNumberFull;
      $params['equipTypeId'] = $this->equipTypeId;
      if(strtotime($this->createDate))
      {
        $params['createDate'] = date('c', strtotime($this->createDate));
      }
      if(strtotime($this->verifDate))
      {
        $params['verifDate'] = date('c', strtotime($this->verifDate));
      }
      if(strtotime($this->verifExpires))
      {
        $params['verifExpires'] = date('c', strtotime($this->verifExpires));
      }
      $helper = new \app\modules\lk\components\ProducerHelper();
      $message = $helper->addSkzi($params, $debagInfo);
      if($message === TRUE)
      {
        return TRUE;
      }
      if(is_array($message))
      {
        foreach($message as $val)
        {
          $this->addError('serialNumberFull', $val);
        }
      }
      else
      {
        $this->addError('serialNumberFull', $message);
      }
      return FALSE;
    }
    return FALSE;

  }
  
  /**
   * обновление блока СКЗИ
   * @param array $debagInfo
   */
  public function update($id, &$debagInfo)
  {
    $params = array();
    $params['id'] = (int)$id;
    $params['serialNumberFull'] = $this->serialNumberFull;
    $params['equipTypeId'] = (int)$this->equipTypeId;
    if(strtotime($this->createDate))
    {
      $params['createDate'] = date('c', strtotime($this->createDate));
    }
    if(strtotime($this->verifDate))
    {
      $params['verifDate'] = date('c', strtotime($this->verifDate));
    }
    if(strtotime($this->verifExpires))
    {
      $params['verifExpires'] = date('c', strtotime($this->verifExpires));
    }
    $helper = new \app\modules\lk\components\ProducerHelper();
    $message = $helper->updateSkzi($params, $debagInfo);
    if($message === TRUE)
    {
      return TRUE;
    }
    if(is_array($message))
    {
      foreach($message as $val)
      {
        $this->addError('serialNumberFull', $val);
      }
    }
    else
    {
      $this->addError('serialNumberFull', $message);
    }
    return FALSE;
  }
}