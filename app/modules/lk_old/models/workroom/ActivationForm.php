<?php
/**
 * @link http://alkodesign.ru
 */
namespace app\modules\lk\models\workroom;
use yii\base\Model;
/**
 * @author AlkoDesign <info@alkodesign.ru>
 * @since 2.0
 */
class ActivationForm extends Model
{
  public $carYearOfIssue;
  public $orgName;
  public $OGRN;
  public $INN;
  public $regionCode;
  public $cityName;
  public $address;
  public $brand;
  public $model;
  public $vendorDate;
  public $color;
  public $regNumber;
  public $VIN;
  public $PTS;
  public $tachoNumber;
  public $skziNumber;
  
  public $orgNameDoc;
  public $OGRNDoc;
  public $INNDoc;
  public $regionCodeDoc;
  public $cityNameDoc;
  public $addressDoc;
  public $brandDoc;
  public $modelDoc;
  public $vendorDateDoc;
  public $colorDoc;
  public $regNumberDoc;
  public $VINDoc;
  public $ptsDoc;
  public $tachoNumberDoc;
  public $skziNumberDoc;
  public $regDoc;
  public $doc1;
  public $doc2;

  
  public $formType;//тип формы: with_doc и without_doc
  
  //////////////////////////////////дописать сценарии для with_doc и without_doc
  public function rules()
  {
    return [
          [['orgName', 'OGRN', 'INN', 'regionCode', 'cityName', 'address', 'brand', 'model', 'vendorDate', 'color', 'regNumber', 'VIN', 'PTS', 'tachoNumber', 'skziNumber','carYearOfIssue', 'ptsDoc', 'regDoc', 'doc1', 'doc2'], 'safe', 'on' =>['insert', 'update']],
          [['orgName'], 'required'],
        ];
    return [];
  }
  
  public function attributeLabels() {
    return [
        'orgName' => 'Название организации', 
        'OGRN' => 'ОГРН', 
        'INN' => 'ИНН', 
        'regionCode' => 'Код региона по классификатору', 
        'cityName' => 'Населенный пункт', 
        'address' => 'Адрес', 
        'brand' => 'Марка',  
        'model' => 'Модель',
        'vendorDate' => 'Год выпуска', 
        'color' => 'Цвет', 
        'regNumber' => 'Регистрационный номер', 
        'VIN' => 'Регистрационный номер', 
        'PTS' => 'ПТС', 
        'tachoNumber' => 'Номер тахографа', 
        'skziNumber' => 'Номер СКЗИ',
        'ptsDoc' => 'ПТС', 
        'regDoc' => 'Св-во о регистрации',
        'doc1' => 'Документ 3',
        'doc2' => 'Документ 4',
        ];
  }
  
  public function beforeValidate()
  {
    if($this->formType == 'with_doc')
    {
      $this->setScenario('with_doc');
    }
    elseif($this->formType == 'without_doc')
    {
      $this->setScenario('without_doc');
    }
    return parent::beforeValidate();
  }
  
  public function save()
  {
      $params['orgName'] = $this->orgName;
      $params['pts'] = $this->PTS;
      $params['carYearOfIssue'] = $this->carYearOfIssue;
      $helper = new \app\modules\lk\components\WorkroomHelper();
      $result = $helper->activationRequest($params);
      return $result;
    /////////////////////////////дописать отправку данных в систему
  }
}