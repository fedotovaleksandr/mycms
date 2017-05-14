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
class UserForm extends Model
{
  public $login = '';
  public $password = '';
  public $newPassword = '';
  public $lastName = '';
  public $firstName = '';
  public $middleName = '';
  
  public function rules()
  {
    $rules = [
          [['login', 'password', 'newPassword', 'lastName', 'firstName', 'middleName'], 'safe'],
          [['password'], 'required']
        ];
    if(\Yii::$app->user2->getIdentity()->auth_counter <= 1 || $this->newPassword)
    {
      $rules[] = [['newPassword'], 'required'];
      $rules[] = [['newPassword'], 'string', 'min' => 3];
    }
    return $rules;
  }
  
  public function attributeLabels() {
    return [
        'login' => 'Логин',
        'password' => 'Пароль',
        'lastName' => 'Фамилия',
        'firstName' => 'Имя',
        'middleName' => 'Отчество',
        'newPassword' => 'Новый пароль'
    ];
  }
  
  public function updateIdentity($id, $passwordHash)
  {
    $userIdentity = TUserIndentity::findOne(['external_id' => $id]);
    if(!$userIdentity)
    {
      $userIdentity = new TUserIndentity();
      $userIdentity->external_id = (int)$id;
      $userIdentity->login = $id;
      $userIdentity->auth_counter = 0;
    }
    $userIdentity->name = '';
    if(!empty($this->lastName))
    {
      $userIdentity->name =  $this->lastName;
      $userIdentity->lastName =  $this->lastName;
    }
    if(!empty($this->firstName))
    {
      $userIdentity->name .=  ($userIdentity->name ? ' '.$this->firstName : $this->firstName);
      $userIdentity->firstName =  $this->firstName;
    }
    if(!empty($this->middleName))
    {
      $userIdentity->name .=  ($userIdentity->name ? ' '.$this->middleName : $this->middleName);
      $userIdentity->middleName =  $this->middleName;
    }
    $userIdentity->passwordHash = $passwordHash;
    return $userIdentity->save() ? $userIdentity : NULL;
  }
  
  public function update()
  {
    $login = \Yii::$app->user2->getIdentity()->external_id;
    $helper = new \app\modules\lk\components\UserHelper();
    //получение хэша пароля
    //$passwordHash = $helper->calcPasswordHash($this->login, $this->password);
    $passwordHash = base64_encode(hash('sha256', $this->password, TRUE));
    if($helper->changeName($login, $passwordHash, $this->lastName, $this->firstName, $this->middleName))
    {
      $this->updateIdentity(\Yii::$app->user2->getIdentity()->external_id, $passwordHash);
    }
    else
    {
      $this->addError('password', 'Ошибка при изменении имени');
    }
    if($this->newPassword)
    {
      $newPasswordHash = base64_encode(hash('sha256', $this->newPassword, TRUE));
      if($helper->changePassword($login, $passwordHash, $newPasswordHash))
      {
        $this->updateIdentity(\Yii::$app->user2->getIdentity()->external_id, $newPasswordHash);
      }
      else
      {
        $this->addError('password', 'Ошибка при изменении пароля');
      }
    }
  }
}