<?php
/**
 * @link http://alkodesign.ru
 */
namespace app\modules\lk\models\motorcompany;
use yii\base\Model;


/**
 * The class of adverts for Alchemy CMS (Yii2)
 * 
 * @author AlkoDesign <info@alkodesign.ru>
 * @since 2.0
 */
class TachographForm extends Model
{
  //добавление 
  public $serialNumberTacho;
  public $createDateTacho;
  public $verifDateTacho;
  public $verifExpiresTacho;
  public $equipTypeIdTacho;
  public $softwareVersionTacho;
  public $serialNumberFullSkzi;
  public $equipTypeIdSkzi;
  public $createDateSkzi;
  public $verifDateSkzi;
  public $verifExpiresSkzi;
  
  //редактирование
  public $id;
  public $serialNumber;
  public $equipTypeId;
  public $softwareVersion;
  public $createDate;
  public $verifDate;
  public $verifExpires;
  
  public function rules()
  {
    return [
        [['serialNumberTacho', 'createDateTacho', 'verifDateTacho', 'verifExpiresTacho', 'equipTypeIdTacho', 'softwareVersionTacho', 'serialNumberFullSkzi', 'equipTypeIdSkzi', 'createDateSkzi', 'verifDateSkzi', 'verifExpiresSkzi'], 'safe', 'on' =>['insert']],
        [['serialNumberTacho', 'createDateTacho', 'verifDateTacho', 'verifExpiresTacho'], 'required', 'on' =>['insert']],
        [['id', 'serialNumber', 'equipTypeId', 'softwareVersion', 'createDate', 'verifDate', 'verifExpires',], 'safe', 'on' =>['update']],
        [['id', 'serialNumber', 'createDate'], 'required', 'on' =>['update']]
    ];
  }
  
  public function attributeLabels() {
    return [
        'serialNumberTacho' => 'Серийный номер',
        'createDateTacho' => 'Дата изготовления',
        'verifDateTacho' => 'Дата проверки',
        'verifExpiresTacho' => 'Срок действия проверки',
        'equipTypeIdTacho' => 'Модель оборудования',
        'softwareVersionTacho' => 'Версия ПО',
        'serialNumberFullSkzi' => 'Полный серийный номер СКЗИ',
        'equipTypeIdSkzi' => 'Модель оборудования СКЗИ',
        'createDateSkzi' => 'Дата выпуска СКЗИ',
        'verifDateSkzi' => 'Дата поверки СКЗИ',
        'verifExpiresSkzi' => 'Дата окончания действия поверки СКЗИ',
        
        'serialNumber' => 'Серийный номер',
        'equipTypeId' => 'Модель оборудования',
        'softwareVersion' => 'Версия ПО',
        'createDate' => 'Дата изготовления',
        'verifDate' => 'Дата проверки',
        'verifExpires' => 'Срок действия проверки',
    ];
  }
  
  public function loadFromObject($object)
  {
      foreach($object as $key => $prop)
      {
        if(property_exists(self::className(), $key))
        {
          $this->{$key} = $prop;
        }
      }
  }
  
  /**
   * 
   * @see \app\modules\lk\models\SkziModels::getModels()
   */
  public function getModels()
  {
    return \app\modules\lk\models\TachographModels::getModels();
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
      $params['serialNumberTacho'] = $this->serialNumberTacho;
      $params['equipTypeIdTacho'] = $this->equipTypeIdTacho;
      $params['softwareVersionTacho'] = $this->softwareVersionTacho;
      $params['createDateTacho'] = $this->createDateTacho;
      $params['verifDateTacho'] = $this->verifDateTacho;
      $params['verifExpiresTacho'] = $this->verifExpiresTacho;
      $params['serialNumberFullSkzi'] = $this->serialNumberFullSkzi;
      $params['equipTypeIdSkzi'] = $this->equipTypeIdSkzi;
      $params['createDateSkzi'] = $this->createDateSkzi;
      $params['verifDateSkzi'] = $this->verifDateSkzi;
      $params['verifExpiresSkzi'] = $this->verifExpiresSkzi;
      if(strtotime($this->createDateTacho))
      {
        $params['createDateTacho'] = date('c', strtotime($this->createDateTacho));
      }
      if(strtotime($this->verifDateTacho))
      {
        $params['verifDateTacho'] = date('c', strtotime($this->verifDateTacho));
      }
      if(strtotime($this->verifExpiresTacho))
      {
        $params['verifExpiresTacho'] = date('c', strtotime($this->verifExpiresTacho));
      }
      if(strtotime($this->createDateSkzi))
      {
        $params['createDateSkzi'] = date('c', strtotime($this->createDateSkzi));
      }
      if(strtotime($this->verifDateSkzi))
      {
        $params['verifDateSkzi'] = date('c', strtotime($this->verifDateSkzi));
      }
      if(strtotime($this->verifExpiresSkzi))
      {
        $params['verifExpiresSkzi'] = date('c', strtotime($this->verifExpiresSkzi));
      }
      $helper = new \app\modules\lk\components\ProducerHelper();
      $message = $helper->addTachograph($params, $debagInfo);
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
    $params['serialNumber'] = $this->serialNumber;
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
    $message = $helper->updateTachograph($params, $debagInfo);
    if($message === TRUE)
    {
      return TRUE;
    }
    if(is_array($message))
    {
      foreach($message as $val)
      {
        $this->addError('serialNumber', $val);
      }
    }
    else
    {
      $this->addError('serialNumber', $message);
    }
    return FALSE;
  }
}