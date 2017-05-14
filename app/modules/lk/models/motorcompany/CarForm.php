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
class CarForm extends Model
{
  //добавление 
  public $vrn;
  public $vin;
  public $tachoSerialNumber;
  public $skziSerialNumber;
  
  
  public function rules()
  {
    return [
        [['vrn', 'vin', 'tachoSerialNumber', 'skziSerialNumber'], 'safe', 'on' =>['insert']],
        [['vrn', 'vin', 'tachoSerialNumber', 'skziSerialNumber'], 'required', 'on' =>['insert']],
        //[['id', 'serialNumber', 'equipTypeId', 'softwareVersion', 'createDate', 'verifDate', 'verifExpires',], 'safe', 'on' =>['update']],
        //[['id', 'serialNumber', 'createDate'], 'required', 'on' =>['update']]
    ];
  }
  
  public function attributeLabels() {
    return [
        'vrn' => 'ГРЗ',
        'vin' => 'VIN',
        'tachoSerialNumber' => 'Номер тахографа',
        'skziSerialNumber' => 'Номер СКЗИ',
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
      $params['vrn'] = $this->vrn;
      $params['vin'] = $this->vin;
      $params['tachoSerialNumber'] = $this->tachoSerialNumber;
      $params['skziSerialNumber'] = $this->skziSerialNumber;
      $helper = new \app\modules\lk\components\MotorCompanyHelper();
      $message = $helper->addCar($params, $debagInfo);
      if($message === TRUE)
      {
        return TRUE;
      }
      if(is_array($message))
      {
        foreach($message as $val)
        {
          $this->addError('vrn', $val);
        }
      }
      else
      {
        $this->addError('vrn', $message);
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
    return FALSE;
  }
}