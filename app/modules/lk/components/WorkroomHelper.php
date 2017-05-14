<?php
/**
 * @link http://alkodesign.ru
 */
namespace app\modules\lk\components;

class WorkroomHelper extends \yii\base\Object
{
  /**
   *
   * @var int
   */
  private $totalCount = 0;
  /**
   *
   * @var string
   */
  private $errorMsg = '';
  
  
  public function init()
  {
    parent::init();
    //$this->client = \Yii::$app->webservice->getClient();
  }
    public function getPageLimit($userId, $table)
    {
        $fromGet = 0;//(int)\Yii::$app->request->get('per-page');
        if($fromGet > 0)
        {
            \app\modules\lk\models\TableSettings::setPageLimit($userId, $table, $fromGet);
        }
        return \app\modules\lk\models\TableSettings::getPageLimit($userId, $table);
    }

  protected function getClient($name)
  {
    return \Yii::$app->webservice->getClient($name);
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
   * возвращает список активизаций со статусом «На рассмотрении ФБУ» и тех активизаций, которые были внесены в течении 28 дней.
   * @return array
   */
  public function activationRequest($params){
      $client = $this->getClient('workroomWsdl');
      $message = $client->activationRequest($params);

      return $message;
  }
  public function getLastActivations($userId)
  {
    return [];
  }
  
  /**
   * возвращает список архива активизаций со статусом «подтверждено», «отклонено»
   * @param int $userId
   * @param array $getParams
   * @return array
   */
  public function getActivationArchive($userId, $getParams)
  {
      $pageLimit;
      $userId;
      $filters = $this->getActivationArchiveFilter($getParams);
      return $filters;
  }
  
  /**
   * генерирует фильтр для архива активаций
   * @param array $getParams
   * @return array
   */
  public function getActivationArchiveFilter($getParams)
  {
      $client = $this->getClient('workroomWsdl');
      $message = $client->findActivation();
    return $message;
  }
  
  /**
   * возвращает список карт, соответствующий параметрам поиска отображённых в блоке поиска
   * @param int $userId
   * @param array $getParams
   * @return array
   */
  public function getCards($userId, $pageLimit ,$getParams)
  {
          $pageLimit;
          $userId;
    $filters = $this->getCardsFilter($getParams);
    return $filters;
  }
  
  /**
   * генерирует фильтр для списка карт
   * @param array $getParams
   * @return array
   */
  public function getCardsFilter($getParams)
  {

    return array();
  }
  
  /**
   * возвращает список мастерских
   * @param int $userId
   * @return array
   */
  public function getWorkRoomList($userId)
  {
      $client = $this->getClient('workroomWsdl');
      $list = $client->getWorkShopAddresses();

    return $list;//array();
  }
  
  /**
   * редактирование мастерской в системе
   * @param int $id
   * @param array $data
   * @return boolean
   */
  public function editWorkRoom($id, $data)
  {
    return TRUE;
  }
  
  /**
   * поиск по фильтру в публичной части сайта
   * @param array $getParams
   * @param int $limit
   * @param int $skip
   */
  public function findByFilter($getParams, $limit, $skip)
  {
    $filter = $getParams;
    return [
        'points' => [],
        'totalCount' => 100
    ];
  }
  
  /**
   * список кодов регионов
   * @return array
   */
  public function getRegions()
  {
    return [
        1 => 'Республика Адыгея',
        2 => 'Республика Башкортостан'
    ];
  }
  
  
}