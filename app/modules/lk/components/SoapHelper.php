<?php
namespace app\modules\lk\components;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class SoapHelper extends \yii\base\Object
{
  /**
   *
   * @var string
   */
  protected $errorMsg = '';
  /**
   *
   * @var int
   */
  protected $totalCount = 0;
  /**
   * предобработка результатов операции
   * @param type $result
   * @return boolean
   */
  protected function proccessResult($result)
  {
    if(is_object($result) && get_class($result) == 'SoapFault')
    {
      return $this->errorMsg = $result->getMessage();
    }
    elseif(is_object($result) && get_class($result) == 'stdClass')
    {
      if($result->return->isOk)
      {
        return TRUE;
      }
      $this->errorMsg = print_r($result->return->messages, TRUE);
      $errorstr = '';
      if(is_array($result->return->messages))
      {
        foreach($result->return->messages as $message)
        {
          $errorstr .= print_r($message, TRUE)."\n";
        }
      }else{
        $errorstr = print_r($result->return->messages, TRUE);
      }
      return str_replace("\n", '<br/>',  trim($errorstr));
    }
    return FALSE;
  }
  
  protected function proccessBatchResult($result)
  {
    if(is_object($result) && get_class($result) == 'SoapFault')
    {
      return [$result->getMessage()];
    }
    elseif(is_object($result) && get_class($result) == 'stdClass')
    {
      if($result->return->isOk)
      {
        return ['Файл отправлен'];
      }
      $this->errorMsg = print_r($result->return->messages, TRUE);
      if(isset($result->return->messages) && is_array($result->return->messages))
      {
        return $result->return->messages;
      }elseif(!is_array($result->return->messages))
      {
        return [print_r($result->return->messages, TRUE)];
      }
    }
    return ['Ошибка'];
  }
  
  /**
   * выполняет групповые операции
   * @param string $equipmentCode код оборудования: SKZ, TAC.
   * @param string $operationCode код операции: PRM, ARC, SEC, UTL, NTC.
   * @param string $xml
   */
  private function batchOperation($equipmentCode, $operationCode, $xml)
  {
    $client = $this->getClient('batchWsdl');
	$identinty = \Yii::$app->user2->getIdentity();
	$params = [
		'login' => $identinty->login,
		'password' => $identinty->password,
		'equipmentCode' => $equipmentCode,
        'operationCode' => $operationCode,
        'xml' => $xml
	];
    $result = $client->groupOperation($params);	
	return $this->proccessBatchResult($result);
  }
  
  public function processBeforeView($rows, $viewTableFields)
    {
        $list = [];
        foreach($rows as $key => $row)
        {
            if(isset($row->id))
            {
              $oneRow = ['id' => $row->id];
            }
            else
            {
              $oneRow = [];
            }
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

    public static function processOneObjectBeforeView($table, $object)
    {
        $fields = Fields::getFields($table);
        $row = [];
        $row = (array)$object;
        foreach($fields as $fieldKey => $fieldParams)
        {
            if(isset($row[$fieldKey]))
            {
                switch($fieldParams['type'])
                {
                    case 'dateTime':
                        $row[$fieldKey] = date('d.m.Y', (int)strtotime($row[$fieldKey]));
                        break;
                    case 'boolean':
                        $row[$fieldKey] = ($row[$fieldKey] ? 'Да' : 'Нет');
                        break;
                }
            }
        }
        return $row;
    }
    
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
}