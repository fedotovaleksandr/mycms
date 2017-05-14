<?php
/**
 * @link http://alkodesign.ru
 */
namespace app\modules\lk\components;

class ProducerHelper extends SoapHelper
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
  
  /**
   * общее количество строк в таблице - становится известным т олько полсе запроса
   * @return int
   */
  public function getTotalCount()
  {
    return $this->totalCount;
  }
  
  /**
   * 
   * @param type $serialNumber
   * @return type
   */
  public function fakeFindSkziByFilter($serialNumber)
  {
    $client = $this->getClient('skziWsdl');
    $filter = [];
    $filter['login'] = 7000001;
    $filter['password'] = 'pmWkWSBCL51Bfkhn79xPuKBKHz//H6B+mY6G9/eieuM=';
    $filter['serialNumber'] = $serialNumber;
    $result = $client->findByFilter($filter);
    if(is_object($result) && get_class($result) == 'stdClass')
    {
      $this->totalCount = (int)$result->return->countTotal;
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
    if(isset($result->return) && isset($result->return->list))
    {
      if(is_array($result->return->list))
      {
        return $result->return->list;
      }
      else
      {
        return [$result->return->list];
      }
    }
    return [];
  }
  
  /**
   * 
   * @param type $serialNumber
   * @return type
   */
  public function fakeFindTachographByFilter($serialNumber)
  {
    $client = $this->getClient('tachoWsdl');
    $filter = [];
    $filter['login'] = 7000001;
    $filter['password'] = 'pmWkWSBCL51Bfkhn79xPuKBKHz//H6B+mY6G9/eieuM=';
    $filter['serialNumber'] = $serialNumber;
    $result = $client->findByFilter($filter);
    if(is_object($result) && get_class($result) == 'stdClass')
    {
      $this->totalCount = (int)$result->return->countTotal;
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
    if(isset($result->return) && isset($result->return->list))
    {
      if(is_array($result->return->list))
      {
        return $result->return->list;
      }
      else
      {
        return [$result->return->list];
      }
    }
    return [];
  }
  
  /**
   * 
   * @param type $table
   * @param type $limit
   * @param type $offset
   * @param array $debagInfo
   * @return type
   */
  public function findSkziByFilter($table, $limit ,$offset, &$debagInfo)
  {
    $filter = $this->getFilter($table, \Yii::$app->request->get());
    $filter = $this->getOrder($filter);
    $filter['count'] = (int)$limit;
    $filter['first'] = (int)$offset;
    $identinty = \Yii::$app->user2->getIdentity();
    $filter['login'] = $identinty->login;
    $filter['password'] = $identinty->password;
    $client = $this->getClient('skziWsdl');
    $result = $client->findByFilter($filter);
    $debagInfo['filter'] = $filter;
    //$debagInfo['result'] = $result;
    $debagInfo['requestBody'] = str_replace(['<', '>'], ['&lt;', '&gt;'], $client->__getLastRequest());
    $debagInfo['responceBody'] = str_replace(['<', '>'], ['&lt;', '&gt;'], $client->__getLastResponse());
    
    if(is_object($result) && get_class($result) == 'stdClass')
    {
      $this->totalCount = (int)$result->return->countTotal;
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
    
    if(isset($result->return) && isset($result->return->list))
    {
      if(is_array($result->return->list))
      {
        return $result->return->list;
      }
      else
      {
        return [$result->return->list];
      }
    }
    return [];
  }
  
  /**
   * добавление в фильтр атрибутов сортировки
   * @param array $filter
   * @return array
   */
  public function getOrder($filter)
  {
    if(\Yii::$app->request->get('sort') && \Yii::$app->request->get('order'))
    {
      $fieldName = str_replace(['activationStatusText'], ['activationStatus'], \Yii::$app->request->get('sort'));
      $filter['sortOrder'] =  [];
      $filter['sortOrder']['fieldName'] = $fieldName;
      $filter['sortOrder']['ascending']= (\Yii::$app->request->get('order') == SORT_ASC);
    }
    return $filter;
  }
  
  /**
   * 
   * @param type $table
   * @param type $limit
   * @param type $offset
   * @param array $debagInfo
   * @return type
   */
  public function findTachoByFilter($table, $limit ,$offset, &$debagInfo)
  {
    $filter = $this->getFilter($table, \Yii::$app->request->get());
    $filter = $this->getOrder($filter);
    $filter['count'] = (int)$limit;
    $filter['first'] = (int)$offset;
    $identinty = \Yii::$app->user2->getIdentity();
    $filter['login'] = $identinty->login;
    $filter['password'] = $identinty->password;
    $client = $this->getClient('tachoWsdl');
    $result = $client->findByFilter($filter);
    $debagInfo['filter'] = $filter;
    var_dump($result);
    //$debagInfo['result'] = $result;
    $debagInfo['requestBody'] = str_replace(['<', '>'], ['&lt;', '&gt;'], $client->__getLastRequest());
    $debagInfo['responceBody'] = str_replace(['<', '>'], ['&lt;', '&gt;'], $client->__getLastResponse());
    
    if(is_object($result) && get_class($result) == 'stdClass')
    {
      $this->totalCount = (int)$result->return->countTotal;
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
    
    if(isset($result->return) && isset($result->return->list))
    {
      if(is_array($result->return->list))
      {
        return $result->return->list;
      }
      else
      {
        return [$result->return->list];
      }
    }
    return [];
  }
  
  /**
   * генерирует массив-фильтр из массива $params для таблицы $table
   * @param string $table
   * @param array $params
   * @return array
   * @throws \yii\web\HttpException
   */
  public function getFilter($table, $params)
  {
    $filter = array();
    $filters = Fields::getFilters($table);
    foreach($filters as $filerKey => $options)
    {
      if(array_key_exists($filerKey, $params) || $options['type'] == 'dateTime')
      {
        switch($options['type'])
        {
          case 'int': 
            if((int)$params[$filerKey] > 0)
            {
              $filter[$filerKey] = (int)$params[$filerKey];
            }
            break;
          case 'select': 
            if(is_numeric($params[$filerKey]) && (int)$params[$filerKey] >= 0)
            {
              $filter[$filerKey] = (int)$params[$filerKey];
            }
            break;
           case 'boolean': 
            $filter[$filerKey] = (bool)$params[$filerKey];
            break;
          case 'dateTime':
            if(array_key_exists($options['fromName'], $params) && strtotime($params[$options['fromName']]))
            {
              $filter[$options['fromName']] = date('c', strtotime($params[$options['fromName']]));
            }
            if(array_key_exists($options['toName'], $params) && strtotime($params[$options['toName']]))
            {
              $filter[$options['toName']] = date('c', strtotime($params[$options['toName']]));
            }
            break;
          default:
            if($params[$filerKey])
            {
              $filter[$filerKey] = $params[$filerKey];
            }
        }
      }
    }
    return $filter;
  }
  
  /**
   * возвращает последнее сообщение об ошибке
   * @return string
   */
  public function getErrorMsg()
  {
    return $this->errorMsg;
  }
  
  /**
   * преобразование данных для отображения в странице
   * @param array $rows результат метода self::findByFilter()
   * @param array $viewTableFields результат метода \app\modules\lk\models\TableSettings::getTableFieldList()
   * @return array
   */
  public function processBeforeView($rows, $viewTableFields)
  {
    $list = [];
    foreach($rows as $key => $row)
    {
      $oneRow = ['id' => $row->id];
      foreach($viewTableFields as $fieldkey => $field)
      {
        if(isset($row->{$fieldkey}))
        {
          switch($field['type'])
          {
            case 'dateTime':
              $oneRow[$fieldkey] = date('d.m.Y', (int)strtotime($row->{$fieldkey}));
              break;
            case 'boolean':
              $oneRow[$fieldkey] = $row->{$fieldkey} ? 'Да' : 'Нет';
              break;
            default: 
              $oneRow[$fieldkey] = $row->{$fieldkey};
          }
        }
        else
        {
          $oneRow[$fieldkey] = '-';
        }
      }
      $list[$key] = $oneRow;
    }
    return $list;
  }
  
  /**
   * отправляет файл с тахографами для дальнейшего добавления
   * @param \yii\web\UploadedFile $file отправляемый файл
   * @return string статус
   */
  public function addBatchTacho($file)
  {
    return $this->batchOperation('TAC', 'PRM', file_get_contents($file->tempName));
  }
  
  /**
   * отправляет файл с скзи для дальнейшего добавления
   * @param \yii\web\UploadedFile $file отправляемый файл
   * @return string статус
   */
  public function addBatchSkzi($file)
  {
    return $this->batchOperation('SKZ', 'PRM', file_get_contents($file->tempName));
  }
  
  /**
   * список всех моделей СКЗИ из системы учёт
   * @return array [stdClass, stdClass, ...]
   */
  public function getSkziModels()
  {
    static $list;
    if(is_array($list))
    {
      return $list;
    }
    $client = $this->getClient('skziModelWsdl');
    $identinty = \Yii::$app->user2->getIdentity();
    $result = $client->findByFilter([
        'count' => 1000, 
        'first' => 0,
        'login' => $identinty->login,
        'password' => $identinty->password,
        ]);
    $list = array();
    if(is_object($result) && isset($result->return) && isset($result->return->countTotal))
    {
      if($result->return->countTotal > 1 && isset($result->return->list) && is_array($result->return->list))
      {
        $list = $result->return->list;
      }
      elseif($result->return->countTotal == 1 && isset($result->return->list) )
      {
        $list = [$result->return->list];
      }
    }
    return $list;
  }
  
  /**
   * список всех моделей тахографов из системы учёт
   * @return array
   */
  public function getTachographModels()
  {
    static $list;
    if(is_array($list))
    {
      return $list;
    }
    $client = $this->getClient('tachoModelWsdl');
    $identinty = \Yii::$app->user2->getIdentity();
    $result = $client->findByFilter([
        'count' => 1000, 
        'first' => 0,
        'login' => $identinty->login,
        'password' => $identinty->password,
        ]);
    $list = array();
    if(is_object($result) && isset($result->return) && isset($result->return->countTotal))
    {
      if($result->return->countTotal > 1 && isset($result->return->list) && is_array($result->return->list))
      {
        $list = $result->return->list;
      }
      elseif($result->return->countTotal == 1 && isset($result->return->list) )
      {
        $list = [$result->return->list];
      }
    }
    return $list;
  }
  
  
  /**
   * список всех моделей карт для тахографов из системы учёт
   * @return array
   */
  public function getCardModels()
  {
    static $list;
    if(is_array($list))
    {
      return $list;
    }
    $identinty = \Yii::$app->user2->getIdentity();
    $client = $this->getClient('cardModelWsdl');
    $result = $client->findByFilter([
        'count' => 1000, 
        'first' => 0,
        'login' => $identinty->login,
        'password' => $identinty->password,
        ]);
    $list = array();
    if(is_object($result) && isset($result->return) && isset($result->return->countTotal))
    {
      if($result->return->countTotal > 1 && isset($result->return->list) && is_array($result->return->list))
      {
        $list = $result->return->list;
      }
      elseif($result->return->countTotal == 1 && isset($result->return->list) )
      {
        $list = [$result->return->list];
      }
    }
    return $list;
  }
  
  /**
   * получение модели СКЗИ по серийному номеру
   * @param int $id
   * @return array
   */
  public function findSkziBySerialNumber($serialNumber)
  {
    $filter = array();
    $filter['serialNumber'] = $serialNumber;
    $filter['count'] = 5;
    $identinty = \Yii::$app->user2->getIdentity();
    $filter['login'] = $identinty->login;
    $filter['password'] = $identinty->password;
    $client = $this->getClient('skziWsdl');
    $result = $client->findByFilter($filter);
    if(is_object($result) && get_class($result) == 'stdClass' && isset($result->return) && isset($result->return->list))
    {
      if(is_array($result->return->list))
      {
        return $result->return->list;
      }
      else
      {
        return [$result->return->list];
      }
    }
    return [];
  }
  
  /**
   * получение модели СКЗИ по id
   * @param int $id
   * @return NULL|stdClass
   */
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
   * получение модели тахографа по id
   * @param int $id
   * @return NULL|stdClass
   */
  public function findTachographById($id)
  {
    $filter = array();
    $filter['id'] = (int)$id;
    $identinty = \Yii::$app->user2->getIdentity();
    $filter['login'] = $identinty->login;
    $filter['password'] = $identinty->password;
    $client = $this->getClient('tachoWsdl');
    $result = $client->findByFilter($filter);
    if(is_object($result) && get_class($result) == 'stdClass' && isset($result->return) && isset($result->return->list))
    {
      return $result->return->list;
    }
    return NULL;
  }
  
  /**
   * архивация СКЗИ по id
   * @param int $id
   * @return boolean
   */
  public function archiveSkzi($id)
  {
    $params = array('id' => (int)$id);
    $identity = \Yii::$app->user2->getIdentity();
    $params['login'] = $identity->login;
    $params['password'] = $identity->password;
    $client = $this->getClient('skziWsdl');
    $result = $client->operArchive($params);
    return $this->proccessResult($result);
  }
  
   /**
   * разархивация СКЗИ по id
   * @param int $id
   * @return boolean
   */
  public function unArchiveSkzi($id)
  {
    $params = array('id' => (int)$id);
    $identity = \Yii::$app->user2->getIdentity();
    $params['login'] = $identity->login;
    $params['password'] = $identity->password;
    $client = $this->getClient('skziWsdl');
    $result = $client->operSecondaryAccounting($params);
    return $this->proccessResult($result);
  }
  
  /**
   * архивация тахографа по id
   * @param int $id
   * @return boolean
   */
  public function archiveTachograph($id)
  {
    $params = array('id' => (int)$id);
    $identity = \Yii::$app->user2->getIdentity();
    $params['login'] = $identity->login;
    $params['password'] = $identity->password;
    $client = $this->getClient('tachoWsdl');
    $result = $client->operArchive($params);
    $debagInfo['filter'] = $params;
    $debagInfo['result'] = $result;
    $debagInfo['requestBody'] = str_replace(['<', '>'], ['&lt;', '&gt;'], $client->__getLastRequest());
    $debagInfo['responceBody'] = str_replace(['<', '>'], ['&lt;', '&gt;'], $client->__getLastResponse());
    \Yii::info(print_r($debagInfo, TRUE), 'soap-archive-tachograph');
    return $this->proccessResult($result);
  }
  
  /**
   * разархивация тахографа по id
   * @param int $id
   * @return boolean
   */
  public function unArchiveTachograph($id)
  {
    $params = array('id' => (int)$id);
    $identity = \Yii::$app->user2->getIdentity();
    $params['login'] = $identity->login;
    $params['password'] = $identity->password;
    $client = $this->getClient('tachoWsdl');
    $result = $client->operSecondaryAccounting($params);
    return $this->proccessResult($result);
  }
  
  /**
   * добавление СКЗИ
   * @param array $params список параметров
   * @param type $debagInfo
   * @return boolean|array|string
   */
  public function addSkzi($params, &$debagInfo)
  {
    $client = $this->getClient('skziWsdl');
	$identity = \Yii::$app->user2->getIdentity();
    $params['login'] = $identity->login;
    $params['password'] = $identity->password;
    $result = $client->operPrimaryAccounting($params);
    $debagInfo['filter'] = $params;
    //$debagInfo['result'] = $result;
    $debagInfo['requestBody'] = str_replace(['<', '>'], ['&lt;', '&gt;'], $client->__getLastRequest());
    $debagInfo['responceBody'] = str_replace(['<', '>'], ['&lt;', '&gt;'], $client->__getLastResponse());
    return $this->proccessResult($result);
  }
  
  /**
   * 
   * @param type $params
   * @param type $debagInfo
   */
  public function updateSkzi($params, &$debagInfo)
  {
    $client = $this->getClient('skziWsdl');
    $identity = \Yii::$app->user2->getIdentity();
    $params['login'] = $identity->login;
    $params['password'] = $identity->password;
    $result = $client->operUpdateInformation($params);
    $debagInfo['filter'] = $params;
    $debagInfo['result'] = $result;
    $debagInfo['requestBody'] = str_replace(['<', '>'], ['&lt;', '&gt;'], $client->__getLastRequest());
    $debagInfo['responceBody'] = str_replace(['<', '>'], ['&lt;', '&gt;'], $client->__getLastResponse());
    return $this->proccessResult($result);
  }
  
  /**
   * добавление тахографа
   * @param array $params список параметров
   */
  public function addTachograph($params, &$debagInfo)
  {
    $client = $this->getClient('tachoWsdl');
    $identity = \Yii::$app->user2->getIdentity();
    $params['login'] = $identity->login;
    $params['password'] = $identity->password;
    $result = $client->operPrimaryAccounting($params);
    //var_dump($result);//A1D70000031415AA
    //die;
    $debagInfo['filter'] = $params;
    $debagInfo['result'] = $result;
    $debagInfo['requestBody'] = str_replace(['<', '>'], ['&lt;', '&gt;'], $client->__getLastRequest());
    $debagInfo['responceBody'] = str_replace(['<', '>'], ['&lt;', '&gt;'], $client->__getLastResponse());
    \Yii::info(print_r($debagInfo, TRUE), 'soap-add-tachograph');
    return $this->proccessResult($result);
  }
  
  /**
   * обновление тахографа
   * @param type $params
   * @param type $debagInfo
   */
  public function updateTachograph($params, &$debagInfo)
  {
    $client = $this->getClient('tachoWsdl');
    $identity = \Yii::$app->user2->getIdentity();
    $params['login'] = $identity->login;
    $params['password'] = $identity->password;
    $result = $client->operUpdateInformation($params);
    $debagInfo['filter'] = $params;
    $debagInfo['result'] = $result;
    $debagInfo['requestBody'] = str_replace(['<', '>'], ['&lt;', '&gt;'], $client->__getLastRequest());
    $debagInfo['responceBody'] = str_replace(['<', '>'], ['&lt;', '&gt;'], $client->__getLastResponse());
    \Yii::info(print_r($debagInfo, TRUE), 'soap-update-tachograph');
    return $this->proccessResult($result);
  }
  
  /**
   * добавление тахографов в стоп лист с помощью файла
   * @param \yii\web\UploadedFile $file
   */
  public function addStop($file)
  {
    return $this->batchOperation('TAC', '', file_get_contents($file->tempName));
  }
  
  /**
   * добавление скзи в стоп-лист
   * @param int $id
   * @return boolean|string
   */
  public function stopSkzi($id)
  {
	$client = $this->getClient('skziWsdl');
	$identinty = \Yii::$app->user2->getIdentity();
	$params = [
		'login' => $identinty->login,
		'password' => $identinty->password,
		'id' => $id
	];
	$result = $client->operAddToStopList($params);	
	return $this->proccessResult($result);
  }
  
  public function stopTachograph($id)
  {
    $client = $this->getClient('tachoWsdl');
	$identinty = \Yii::$app->user2->getIdentity();
	$params = [
		'login' => $identinty->login,
		'password' => $identinty->password,
		'id' => $id
	];
	$result = $client->operAddToStopList($params);	
	return $this->proccessResult($result);
  }
  
  public function delSkzi($id)
  {
    return true;//////////////////////////////////доделать///////////////////////////////////////
  }
  
  public function delTachograph($id)
  {
    return true;//////////////////////////////////доделать///////////////////////////////////////
  }
  
  public function unStopSkzi($id)
  {
    return true;//////////////////////////////////доделать///////////////////////////////////////
  }
  
  public function unStopTachograph($id)
  {
    return true;//////////////////////////////////доделать///////////////////////////////////////
  }
  
  public static function checkAction($table, $action, $object)
  {
    if($table == 'skzi')
    {
      return self::checkSkziAction($action, $object);
    }
    elseif($table == 'tachograph')
    {
      return self::checkTachographAction($action, $object);
    }
    else
    {
      throw new \yii\web\HttpException(400, 'Error param "table"');
    }
  }
  
  public static function checkSkziAction($action, $object)
  {
    switch ($action)
    {
      case 'edit':
        return (isset($object->activationStatusId) && $object->activationStatusId == 0);
      case 'archive':
        return ((isset($object->activationStatusId) && $object->activationStatusId == 0) &&(!isset($object->archiveStatus) || (isset($object->archiveStatus) && $object->archiveStatus == false)));
      case 'unarchive':
        return (isset($object->archiveStatus) && $object->archiveStatus);
      case 'stop':
        return ((!isset($object->archiveStatus) || (isset($object->archiveStatus) && $object->archiveStatus == false)));
      case 'unstop':
        return (isset($object->activationStatusId) && $object->activationStatusId == 0);
    }
    throw new \yii\web\HttpException(400, 'Error param "action"');
  }
  
  public static function checkTachographAction($action, $object)
  {
    switch ($action)
    {
      case 'edit':
        return (!isset($object->activationDate));
      case 'archive':
        return (isset($object->archiveStatus) && !$object->archiveStatus);
      case 'unarchive':
        return (isset($object->archiveStatus) && $object->archiveStatus);
      case 'stop':
        return true;//(isset($object->activationStatusId) && $object->activationStatusId == 0);
      case 'unstop':
        return (isset($object->activationStatusId) && $object->activationStatusId == 0);
    }
    throw new \yii\web\HttpException(400, 'Error param "action"');
  }
}