<?php
/**
 * @link http://alkodesign.ru
 */
namespace app\modules\lk\components;

class UserHelper extends \yii\base\Object
{
  protected function getClient()
  {
    return \Yii::$app->webservice->getClient('userWsdl');
  }
  
  /**
   * вызов soap-метода findByLogin
   * @param string $login
   * @param string $password
   * @return boolean|string данные о пользователе или false
   */
  public function findByLogin($login, $password)
  {
    $client = $this->getClient();
    $response = $client->findByLogin(['login' => $login, 'password' => $password]);
//    $debagInfo['requestBody'] = str_replace(['<', '>'], ['&lt;', '&gt;'], $client->__getLastRequest());
//    $debagInfo['responceBody'] = str_replace(['<', '>'], ['&lt;', '&gt;'], $client->__getLastResponse());
//    var_dump($debagInfo);
    if(is_object($response) && isset($response->return))
    {
      return $response->return;
    }
    return FALSE;
  }
  
  /**
   * вызов soap-метода calcPasswordHash
   * @param string $login
   * @param string $password
   * @return string|boolean хэш или false(при неудаче)
   */
  public function calcPasswordHash($login, $password)
  {
    $response = $this->getClient()->calcPasswordHash(['login' => $login, 'password' => $password]);
    if(is_object($response) && isset($response->return))
    {
      return $response->return;
    }
    return FALSE;
  }
  
  /**
   * изменение имени пользователя
   * @param string $login
   * @param string $password
   * @param string $lastName
   * @param string $firstName
   * @param string $middleName
   * @return bool
   */
  public function changeName($login, $password, $lastName, $firstName, $middleName)
  {
    $client = $this->getClient();
    $response = $client->changeName([
        'login' => $login, 
        'password' => $password,
        'lastName' => $lastName,
        'firstName' => $firstName,
        'middleName' => $middleName
        ]);
    if(is_object($response) && isset($response->return))
    {
      return $response->return;
    }
    return FALSE;
  }
  
  /**
   * изменение пароля
   * @param string $login
   * @param string $oldPasswordHash
   * @param string $newPasswordHash
   * @return boolean
   */
  public function changePassword($login, $oldPasswordHash, $newPasswordHash)
  {
    $client = $this->getClient();
    $response = $client->changePassword([
        'login' => $login, 
        'oldPasswordHash' => $oldPasswordHash,
        'newPasswordHash' => $newPasswordHash
        ]);
    if(is_object($response) && isset($response->return))
    {
      return $response->return;
    }
    return FALSE;
  }
}