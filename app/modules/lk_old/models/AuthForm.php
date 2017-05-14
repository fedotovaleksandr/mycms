<?php
/**
 * @link http://alkodesign.ru
 */
namespace app\modules\lk\models;
use yii\base\Model;
use app\models\TUserIndentity;
/**
 * @author AlkoDesign <info@alkodesign.ru>
 * @since 2.0
 */
class AuthForm extends Model
{
  public $login = '';
  public $password = '';
  
  public function rules()
  {
    return [
          [['login', 'password'], 'safe']
        ];
  }
  
  public function attributeLabels() {
    return [
        'login' => 'Логин',
        'password' => 'Пароль'
    ];
  }
  
  public function updateIdentity($userArr, $password)
  {
    $userIdentity = TUserIndentity::findOne(['external_id' => $userArr->id]);
    if(!$userIdentity)
    {
      $userIdentity = new TUserIndentity();
      $userIdentity->external_id = (int)$userArr->id;
      $userIdentity->login = $userArr->id;
      $userIdentity->auth_counter = 0;
    }
    if(isset($userArr->isCardManufacturer) && $userArr->isCardManufacturer)
    {
      $userIdentity->type = TUserIndentity::CARD_PRODUCER;
    }
    elseif(isset($userArr->isTachoManufacturer) && $userArr->isTachoManufacturer)
    {
      $userIdentity->type = TUserIndentity::MANUFACTURE_TYPE;
    }
    elseif(isset($userArr->isSkziManufacturer) && $userArr->isSkziManufacturer)
    {
      $userIdentity->type = TUserIndentity::MANUFACTURE_TYPE;
    }
    elseif(isset($userArr->isAutoCompany) && $userArr->isAutoCompany)
    {
      $userIdentity->type = TUserIndentity::MOTOR_COMPANY;
    }
    elseif(isset($userArr->isController) && $userArr->isController)
    {
      $userIdentity->type = TUserIndentity::CONTROLLER_TYPE;
    }
    elseif(isset($userArr->isWorkshop) && $userArr->isWorkshop)
    {
      $userIdentity->type = TUserIndentity::WORKROOM_TYPE;
    }
    $userIdentity->name = '';
    if(isset($userArr->lastName))
    {
      $userIdentity->name =  $userArr->lastName;
      $userIdentity->lastName = $userArr->lastName;
    }
    if(isset($userArr->firstName))
    {
      $userIdentity->name .=  ($userIdentity->name ? ' '.$userArr->firstName : $userArr->firstName);
      $userIdentity->firstName = $userArr->firstName;
    }
    if(isset($userArr->middleName))
    {
      $userIdentity->name .=  ($userIdentity->name ? ' '.$userArr->middleName : $userArr->middleName);
      $userIdentity->middleName = $userArr->middleName;
    }
    $userIdentity->password = $password;
    return $userIdentity->save() ? $userIdentity : NULL;
  }
  
  /**
   * авторизация пользователя
   * @return boolean
   */
  public function auth()
  {
    $helper = new \app\modules\lk\components\UserHelper();
    //получение хэша пароля
    //$password = $helper->calcPasswordHash($this->login, $this->password);
    $password = $this->password;
    if(!$password)
    {
      $this->addError('password', 'Сервис не смог проверить логин и пароль');
      return FALSE;
    }
    $userArr = $helper->findByLogin($this->login, $password);
    if(!$userArr)
    {
      $this->addError('password', 'Неверный логин или пароль');
      return FALSE;
    }
    if(isset($userArr->isBlocked) && $userArr->isBlocked)
    {
      $this->addError('password', 'Пользователь заблокирован');
      return FALSE;
    }
    $identity = $this->updateIdentity($userArr, $password);
    if(!$identity)
    {
      $this->addError('password', 'Ошибка при авторизации');
      return FALSE;
    }
    if($identity->auth_counter > \app\components\ConstantHelper::getValue('auth-limit', 3))
    {
      $this->addError('password', 'Превышен лимит авторизаций без SSL-сертификата. '.\yii\helpers\Html::a('Подробнее', '/lk/user/ssl/'));
      return FALSE;
    }
    if((!$identity->auth_counter || $identity->auth_counter == 0) && \Yii::$app->user2->login($identity))
    {
      \Yii::$app->response->redirect('/lk/user/edit/');
      return FALSE;
    }
    return \Yii::$app->user2->login($identity);
  }
  
  public function getSSL()
  {
    
  }
}