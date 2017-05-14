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
class InfoForm extends Model
{
  public $id;
  public $number;
  public $name;
  public $abbreviation;
  public $head;
  public $inn;
  public $ogrn;
  public $region;
  public $phone;
  public $email;
  public $postAddress;
  public $realAddress;
  public $status;
  
  
  public function rules()
  {
    return [
          [['number', 'name', 'abbreviation', 'head', 'inn', 'ogrn', 'region', 'phone', 'postAddress', 'realAddress', 'status'], 'safe', 'on' =>['insert', 'update']]
        ];
  }
  
  /**
   * инициализация свойств
   * @param type $workroom
   */
  public function loadObject($workroom)
  {
    ///////////////////////////////////загрузить информацию о мастерской из системы 
    
  }
  
  public function attributeLabels() {
    return [
        'number' => 'Номер клейма мастерской', 
        'abbreviation' => 'Сокращенное наименование', 
        'name' => 'Наименование организации', 
        'head' => 'Руководитель мастерской', 
        'inn' => 'ИНН', 
        'ogrn' => 'ОГРН', 
        'region' => 'Код региона по классификатору',  
        'phone' => 'Телефон', 
        'email' => 'Электронная почта', 
        'postAddress' => 'Почтовый адрес', 
        'realAddress' => 'Фактический адрес выполнения работ', 
        'status' => 'Статус', 
        ];
  }
  
  /**
   * добавление новой мастерской в систему
   */
  public function save()
  {
    
  }
  
  /**
   * обновление информации о мастерской в системе
   */
  public function update()
  {
    $helper = new \app\modules\lk\components\WorkroomHelper();
    $data = array();
    //////////////////////////
    return $helper->editWorkRoom($this->id, $data);
  }
}