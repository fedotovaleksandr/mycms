<?php
/**
 * @link http://alkodesign.ru
 */
namespace app\modules\lk\components;

class MotorCompanyHelper extends SoapHelper
{
    public function init()
    {
        parent::init();
        //$this->client = \Yii::$app->webservice->getClient();
    }

    protected function getClient($name)
    {
        return \Yii::$app->webservice->getClient($name);
    }
    /**
     * возвращает количество строк в таблице $table в настройках пользователя с id=$userId.
     * Если в запросе есть GET['per-page'], то сначала пытается установить его значение
     * @param int $userId
     * @param string $table
     * @return int
     */
    public function getPageLimit($userId, $table)
    {
        $fromGet = 0;//(int)\Yii::$app->request->get('per-page');
        if($fromGet > 0)
        {
            \app\modules\lk\models\TableSettings::setPageLimit($userId, $table, $fromGet);
        }
        return \app\modules\lk\models\TableSettings::getPageLimit($userId, $table);
    }
    public function findTachoByFilter($table, $limit ,$offset, &$debagInfo)
    {
        $filter = $this->getFilter($table, \Yii::$app->request->get());
        $filter = $this->getOrder($filter);
        $filter['count'] = (int)$limit;
        $filter['first'] = (int)$offset;
        $identinty = \Yii::$app->user2->getIdentity();
        $filter['login'] = $identinty->login;
        $filter['password'] = $identinty->password;
        $client = $this->getClient('atpWsdl');
        $result = $client->findTacho($filter);
        $debagInfo['filter'] = $filter;
        //var_dump($result->return);die;
        $debagInfo['result'] = $result;
        $debagInfo['requestBody'] = str_replace(['<', '>'], ['&lt;', '&gt;'], $client->__getLastRequest());
        $debagInfo['responceBody'] = str_replace(['<', '>'], ['&lt;', '&gt;'], $client->__getLastResponse());
        if(is_object($result) && get_class($result) == 'stdClass')
        {
            $this->totalCount = (int)$result->return->rowCounter;
        }
        elseif(is_object($result) && get_class($result) == 'SoapFault')
        {
            $this->errorMsg = "Сервис недоступен - ".$result->getMessage();
            return [];
        }
        else
        {
            return [];
        }

        if(isset($result->return) && isset($result->return->tachoRows))
        {
            if(is_array($result->return->tachoRows))
            {
                return $result->return->tachoRows;
            }
            else
            {
                return [$result->return->tachoRows];
            }
        }
        return [];
    }

    /**
     * общее количество строк в таблице - становится известным т олько полсе запроса
     * @return int
     */
    public function getTotalCount()
    {
        return $this->totalCount;
    }
    public function findSkziById($id)
    {
        $filter = array();
        $filter['id'] = (int)$id;
        $identinty = \Yii::$app->user2->getIdentity();
        $filter['login'] = $identinty->login;
        $filter['password'] = $identinty->password;
        $client = $this->getClient('skziWsdl');
        $result = $client->findByFilter($filter);
        if(is_object($result) && get_class($result) == 'stdClass' && isset($result->return) && isset($result->return->list))
        {
            return $result->return->list;
        }
        return NULL;
    }
    
    /**
   * добавление  автомобиля
   * @param array $params список параметров
   */
  public function addCar($params, &$debagInfo)
  {
    $client = $this->getClient('atpWsdl');
    $identity = \Yii::$app->user2->getIdentity();
    $params['login'] = $identity->login;
    $params['password'] = $identity->password;
    $result = $client->addCar($params);
    $debagInfo['filter'] = $params;
    $debagInfo['result'] = $result;
    $debagInfo['requestBody'] = str_replace(['<', '>'], ['&lt;', '&gt;'], $client->__getLastRequest());
    $debagInfo['responceBody'] = str_replace(['<', '>'], ['&lt;', '&gt;'], $client->__getLastResponse());
    return $this->proccessResult($result);
  }
  
  /**
   * карты водителей
   * @param string $table уникальный алиас таблицы
   * @param string $limit количество строк на странице
   * @param string $offset смешение
   * @param array $debagInfo переменная для отладочной информации
   * @return array
   */
  public function findDriverCard($table, $limit ,$offset, &$debagInfo)
  {
      $filter = $this->getFilter($table, \Yii::$app->request->get());
      $filter = $this->getOrder($filter);
      $filter['count'] = (int)$limit;
      $filter['first'] = (int)$offset;
      $identinty = \Yii::$app->user2->getIdentity();
      $filter['login'] = $identinty->login;
      $filter['password'] = $identinty->password;
      $client = $this->getClient('atpWsdl');
      $result = $client->findDriverCard($filter);
      $debagInfo['filter'] = $filter;
      //var_dump($result->return);die;
      $debagInfo['result'] = $result;
      $debagInfo['requestBody'] = str_replace(['<', '>'], ['&lt;', '&gt;'], $client->__getLastRequest());
      $debagInfo['responceBody'] = str_replace(['<', '>'], ['&lt;', '&gt;'], $client->__getLastResponse());
      if(is_object($result) && get_class($result) == 'stdClass')
      {
          $this->totalCount = (int)$result->return->rowCounter;
      }
      elseif(is_object($result) && get_class($result) == 'SoapFault')
      {
          $this->errorMsg = "Сервис недоступен - ".$result->getMessage();
          return [];
      }
      else
      {
          return [];
      }

      if(isset($result->return) && isset($result->return->driverCards))
      {
          if(is_array($result->return->driverCards))
          {
              return $result->return->driverCards;
          }
          else
          {
              return [$result->return->driverCards];
          }
      }
      return [];
  }
  
  /**
   * количество карт, дата окончания которых в течение ближайших семи дней
   * @return array|NULL
   */
  public function getSoonExpiresDriverCards()
  {
    $from = date('c');
    $to = date('c', strtotime('+ 1 week'));
    $cacheKey = 'soon-expires-driver-cards';
    $info = \Yii::$app->cache->get($cacheKey);
    if($info !== FALSE)
    {
      return $info;
    }
    $info = [
        'cardCount' => 0,
        'date' => date('d.m.Y', strtotime('+ 1 week'))
    ];
    $filter = [];
    $filter['cardEndDateFrom'] = $from;
    $filter['cardEndDateTo'] = $to;
    $filter['count'] = 1;
    $filter['first'] = 0;
    $identinty = \Yii::$app->user2->getIdentity();
    $filter['login'] = $identinty->login;
    $filter['password'] = $identinty->password;
    $client = $this->getClient('atpWsdl');
    $result = $client->findDriverCard($filter);
    if(is_object($result) && get_class($result) == 'stdClass')
    {
        $this->totalCount = (int)$result->return->rowCounter;
        $info['cardCount'] = $this->totalCount;
        \Yii::$app->cache->set($info, $info, 6*60*60);
        return $info;
    }
    elseif(is_object($result) && get_class($result) == 'SoapFault')
    {
        $this->errorMsg = "Сервис недоступен - ".$result->getMessage();
        \Yii::$app->cache->set($cacheKey, NULL, 6*60*60);
        return NULL;
    }
    \Yii::$app->cache->set($info, NULL, 6*60*60);
    return NULL;
  }


}