<?php
/**
 * @link http://alkodesign.ru
 */
namespace app\modules\lk\components;

class Fields extends \yii\base\Object
{

  /**
   * возвращает весь список полей таблицы $table с параметрами.
   * Если таблица не найдена, то возвращает false.
   * Иначе вохвращает array c описанием полей.
   * @param string $table
   * @return boolean|array
   */
  public static function getFields($table)
  {
    switch($table)
    {
      case 'tachograph' : return [
            'serialNumber' => [
                'required' => FALSE,
                'view_required' => FALSE,
                'label' => 'Номер тахографа',
                'type' => 'string',
                'table-width' => '120'
                ],
            'archiveStatus' => [
                    'required' => FALSE,
                    'view_required' => FALSE,
                    'label' => 'В архиве',
                    'type' => 'boolean', 
                    'table-width' => '100'
                    ],
            'equipTypeModel' => [
                'required' => TRUE,
                'view_required' => TRUE,
                'label' => 'Модель',
                'type' => 'string',
                'table-width' => '180'
                ],
            'equipTypeSoftVersion' => [
                'required' => FALSE,
                'view_required' => FALSE,
                'label' => 'Номер версии ПО',
                'type' => 'string',
                'table-width' => '100'
                ],
            'createDate' => [
                'required' => FALSE,
                'view_required' => FALSE,
                'label' => 'Дата изготовления',
                'type' => 'dateTime',
                'table-width' => '100'
                ],
            'activationDate' => [
                'required' => FALSE,
                'view_required' => FALSE,
                'label' => 'Дата активации',
                'type' => 'dateTime',
                'table-width' => '100'
                ],
            'verifDate' => [
                'required' => FALSE,
                'view_required' => FALSE,
                'label' => 'Дата верификации',
                'type' => 'dateTime',
                'table-width' => '100'
                ],
            'verifExpires' => [
                'required' => FALSE,
                'view_required' => FALSE,
                'label' => 'Срок верификации',
                'type' => 'dateTime',
                'table-width' => '100'
                ],
        ];
      case 'skzi' : return [
            'serialNumberFull' => [
                'required' => FALSE,
                'view_required' => FALSE,
                'label' => 'Полный номер СКЗИ',
                'type' => 'string',
                'table-width' => '100'
                ],
            'softwareVersion' => [
                'required' => FALSE,
                'view_required' => FALSE,
                'label' => 'Версия ПО',
                'type' => 'string'
                ],
            'activationStatusText' => [
                'required' => FALSE,
                'view_required' => FALSE,
                'label' => 'Статус',
                'type' => 'string',
                'table-width' => '100'
                ],
            'archiveStatus' => [
                'required' => FALSE,
                'view_required' => FALSE,
                'label' => 'В архиве',
                'type' => 'boolean', 
                'table-width' => '100'
                ],
            'equipTypeModel' => [
                'required' => TRUE,
                'view_required' => TRUE,
                'label' => 'Модель',
                'type' => 'string',
                'table-width' => '180'
                ],
            'equipTypeSoftVersion' => [
                'required' => FALSE,
                'view_required' => FALSE,
                'label' => 'Номер версии ПО',
                'type' => 'string',
                'table-width' => '100'
                ],
            'registrationDate' => [
                'required' => FALSE,
                'view_required' => FALSE,
                'label' => 'Дата регистрации',
                'type' => 'dateTime',
                'table-width' => '100'
                ],
            'activationDate' => [
                'required' => FALSE,
                'view_required' => FALSE,
                'label' => 'Дата активации',
                'type' => 'dateTime',
                'table-width' => '100'
                ],
            'verifDate' => [
                'required' => FALSE,
                'view_required' => FALSE,
                'label' => 'Дата проверки',
                'type' => 'dateTime',
                'table-width' => '100'
                ],
            'verifExpires' => [
                'required' => FALSE,
                'view_required' => FALSE,
                'label' => 'Срок действия проверки',
                'type' => 'dateTime',
                'table-width' => '100'
                ],
            'createDate' => [
                'required' => FALSE,
                'view_required' => FALSE,
                'label' => 'Дата изготовления',
                'type' => 'dateTime',
                'table-width' => '100'
                ],
        ];
      case 'cards' : return [
            'CardNumber' => [
                'required' => FALSE,
                'view_required' => FALSE,
                'label' => 'Номер карты',
                'type' => 'string',
                'table-width' => '200'
            ],
            'activationDate' => [
                'required' => FALSE,
                'view_required' => FALSE,
                'label' => 'Дата активации',
                'type' => 'dateTime',
                'table-width' => '100'
            ],
            'activationEndDate' => [
                'required' => FALSE,
                'view_required' => FALSE,
                'label' => 'Дата окончания активации',
                'type' => 'dateTime',
                'table-width' => '100'
            ],
            'FIO' => [
                'required' => FALSE,
                'view_required' => FALSE,
                'label' => 'Владелец(ФИО)',
                'type' => 'string',
                'table-width' => '100'
            ],
            ];
      case 'activations' : return [
            'Key' => [
                'required' => FALSE,
                'view_required' => FALSE,
                'label' => 'Ключ активизации',
                'type' => 'string',
                'table-width' => '200'
            ],
            'Data' => [
                'required' => FALSE,
                'view_required' => FALSE,
                'label' => 'Данные',
                'type' => 'string',
                'table-width' => '200'
            ],
            'additionDate' => [
                'required' => FALSE,
                'view_required' => FALSE,
                'label' => 'Дата добавления',
                'type' => 'dateTime',
                'table-width' => '100'
            ],
            'archiveStatus' => [
                'required' => FALSE,
                'view_required' => FALSE,
                'label' => 'Статус',
                'type' => 'boolean',
                'table-width' => '100'
            ],
        ];
      case 'tachograph-atp' : return [
            'serialNumber' => [
                'required' => FALSE,
                'view_required' => FALSE,
                'label' => 'Номер тахографа',
                'type' => 'string',
                'table-width' => '120'
                ],
            'archiveStatus' => [
                    'required' => FALSE,
                    'view_required' => FALSE,
                    'label' => 'В архиве',
                    'type' => 'boolean', 
                    'table-width' => '100'
                    ],
            'equipTypeModel' => [
                'required' => TRUE,
                'view_required' => TRUE,
                'label' => 'Модель',
                'type' => 'string',
                'table-width' => '180'
                ],
            'equipTypeSoftVersion' => [
                'required' => FALSE,
                'view_required' => FALSE,
                'label' => 'Номер версии ПО',
                'type' => 'string',
                'table-width' => '100'
                ],
            'createDate' => [
                'required' => FALSE,
                'view_required' => FALSE,
                'label' => 'Дата изготовления',
                'type' => 'dateTime',
                'table-width' => '100'
                ],
            'activationDate' => [
                'required' => FALSE,
                'view_required' => FALSE,
                'label' => 'Дата активации',
                'type' => 'dateTime',
                'table-width' => '100'
                ],
            'verifDate' => [
                'required' => FALSE,
                'view_required' => FALSE,
                'label' => 'Дата верификации',
                'type' => 'dateTime',
                'table-width' => '100'
                ],
            'verifExpires' => [
                'required' => FALSE,
                'view_required' => FALSE,
                'label' => 'Срок верификации',
                'type' => 'dateTime',
                'table-width' => '100'
                ],
        ];
      case 'driver-card-atp': return [
          'cardNumber' => [
                'required' => FALSE,
                'view_required' => FALSE,
                'label' => 'Номер карты',
                'type' => 'string',
                'table-width' => '100'
                ],
          'lastName' => [
                'required' => FALSE,
                'view_required' => FALSE,
                'label' => 'Фамилия',
                'type' => 'string',
                'table-width' => '100'
                ],
          'firstName' => [
                'required' => FALSE,
                'view_required' => FALSE,
                'label' => 'Имя',
                'type' => 'string',
                'table-width' => '100'
                ],
          'middleName' => [
                'required' => FALSE,
                'view_required' => FALSE,
                'label' => 'Отчество',
                'type' => 'string',
                'table-width' => '100'
                ],
          'beginDate' => [
                'required' => FALSE,
                'view_required' => FALSE,
                'label' => 'Дата начала',
                'type' => 'dateTime',
                'table-width' => '100',
                'orderName' => 'cardBeginDate'
                ],
          'endDate' => [
                'required' => FALSE,
                'view_required' => FALSE,
                'label' => 'Дата завершения',
                'type' => 'dateTime',
                'table-width' => '100',
                'orderName' => 'cardEndDate'
                ],
      ];
    }
    return false;
  }
  
  /**
   * возвращает список фильтров для таблицы $table
   * @param string $table
   * @return array
   */
  public static function getFilters($table)
  {
    switch($table)
    {
      case 'tachograph': 
        $equipTypeIdValues = \app\modules\lk\models\TachographModels::getDataForDropDownList();
        $equipTypeIdValues[' '] = 'Модель';
        return [
            'serialNumber' => [
                'label' => 'Номер',
                'type' => 'string',
                ],
            'softwareVersion ' => [
                'label' => 'Версия ПО',
                'type' => 'string',
                ],
            'equipTypeId' => [
                'label' => 'Модель',
                'type' => 'select',
                'values' => $equipTypeIdValues
                ],
            'archiveStatus' => [
                'label' => 'В архиве',
                'type' => 'boolean', 
                ],
            'createDate' => [
                'label' => 'Дата изготовления от',
                'type' => 'dateTime',
                'fromName' => 'createDateFrom',
                'toName' => 'createDateTo',
                ],
            'verifDate' => [
                'label' => 'Дата проверки',
                'type' => 'dateTime',
                'fromName' => 'verifDateFrom',
                'toName' => 'verifDateTo',
                ],
            'verifExpires' => [
                'label' => 'Дата конца действия проверки',
                'type' => 'dateTime',
                'fromName' => 'verifExpiresFrom',
                'toName' => 'verifExpiresTo',
                ],
            
            ];
      case 'skzi' :
          $equipTypeIdValues = \app\modules\lk\models\SkziModels::getDataForDropDownList();
          $equipTypeIdValues[' '] = 'Модель';
        return [
            'serialNumber' => [
                'label' => 'Номер СКЗИ',
                'type' => 'string',
                ],
            'activationStatus' => [
                'label' => 'Статус',
                'type' => 'select',
                'values' => [
                    '' => 'Статус',
                    0 => 'Не активирован',
                    1 => 'Активирован',
                    2 => 'Отозван',
                    3 => 'Утилизирован'
                  ]
                ],
            'equipTypeId' => [
                'label' => 'Модель',
                'type' => 'select',
                'values' => $equipTypeIdValues
                ],
            'archiveStatus' => [
                'label' => 'В архиве',
                'type' => 'boolean', 
                ],
            'createDate' => [
                'label' => 'Дата изготовления',
                'type' => 'dateTime',
                'fromName' => 'createDateFrom',
                'toName' => 'createDateTo',
                ],
            'verifDate' => [
                'label' => 'Дата проверки',
                'type' => 'dateTime',
                'fromName' => 'verifDateFrom',
                'toName' => 'verifDateTo',
                ],
            'verifExpires' => [
                'label' => 'Дата конца действия проверки',
                'type' => 'dateTime',
                'fromName' => 'verifExpiresFrom',
                'toName' => 'verifExpiresTo',
                ],
        ];
        case 'cards' : return [
            'CardNumber' => [
                'required' => FALSE,
                'view_required' => FALSE,
                'label' => 'Номер карты',
                'type' => 'string',
                'table-width' => '200'
            ],
            'activationDate' => [
                'required' => FALSE,
                'view_required' => FALSE,
                'label' => 'Дата активации',
                'type' => 'dateTime',
                'table-width' => '100'
            ],
            'activationEndDate' => [
                'required' => FALSE,
                'view_required' => FALSE,
                'label' => 'Дата окончания активации',
                'type' => 'dateTime',
                'table-width' => '100'
            ],
            'FIO' => [
                'required' => FALSE,
                'view_required' => FALSE,
                'label' => 'Владелец(ФИО)',
                'type' => 'string',
                'table-width' => '100'
            ],
        ];
		case 'activations' : return [
            'Key' => [
                'required' => FALSE,
                'view_required' => FALSE,
                'label' => 'Ключ активизации',
                'type' => 'string',
                'table-width' => '200'
            ],
            'Data' => [
                'required' => FALSE,
                'view_required' => FALSE,
                'label' => 'Данные',
                'type' => 'string',
                'table-width' => '200'
            ],
            'additionDate' => [
                'required' => FALSE,
                'view_required' => FALSE,
                'label' => 'Дата добавления',
                'type' => 'dateTime',
                'table-width' => '100'
            ],
			'archiveStatus' => [
                'label' => 'Статус',
                'type' => 'select',
                'values' => [
                    '' => 'Статус',
                    0 => 'Отклонено',
                    1 => 'Подтверждено',
                  ]
                ],
        ];
        case 'tachograph-atp': 
        $tachoEquipTypeIdValues = \app\modules\lk\models\TachographModels::getDataForDropDownList();
        $tachoEquipTypeIdValues[' '] = 'Модель тахографа';
        $skziEquipTypeIdValues = \app\modules\lk\models\SkziModels::getDataForDropDownList();
        $skziEquipTypeIdValues[' '] = 'Модель СКЗИ';
        return [
            'tachoSerialNumber' => [
                'label' => 'Номер тахографа',
                'type' => 'string',
                ],
            'tachoSoftwareVersion' => [
                'label' => 'Версия ПО тахографа',
                'type' => 'string',
                ],
            'tachoEquipTypeId' => [
                'label' => 'Модель тахографа',
                'type' => 'select',
                'values' => $tachoEquipTypeIdValues
                ],
            'tachoArchiveStatus' => [
                'label' => 'Тахограф в архиве',
                'type' => 'select',
                'values' => []
                ],
            'tachoCreateDate' => [
                'label' => 'Дата изготовления тахографа',
                'type' => 'dateTime',
                'fromName' => 'tachoCreateDateFrom',
                'toName' => 'tachoCreateDateTo',
                ],
            'tachoVerifDate' => [
                'label' => 'Дата проверки тахографа',
                'type' => 'dateTime',
                'fromName' => 'tachoVerifDateFrom',
                'toName' => 'tachoVerifDateTo',
                ],
            'tachoVerifExpires' => [
                'label' => 'Дата конца действия проверки тахографа',
                'type' => 'dateTime',
                'fromName' => 'tachoVerifExpiresFrom',
                'toName' => 'tachoVerifExpiresTo',
                ],
            'vrn' => [
                'label' => 'ГРЗ',
                'type' => 'string',
                ],
            'carModel' => [
                'label' => 'Модель автотранспорта',
                'type' => 'string',
                ],
            'skziSerialNumber' => [
                'label' => 'Номер СКЗИ',
                'type' => 'string',
                ],
            'skziSoftwareVersion' => [
                'label' => 'Версия ПО СКЗИ',
                'type' => 'string',
                ],
            'skziEquipTypeId' => [
                'label' => 'Модель СКЗИ',
                'type' => 'select',
                'values' => $skziEquipTypeIdValues
                ],
            'skziArchiveStatus' => [
                'label' => 'СКЗИ в архиве',
                'type' => 'select',
                'values' => []
                ],
            'skziCreateDate' => [
                'label' => 'Дата изготовления СКЗИ',
                'type' => 'dateTime',
                'fromName' => 'skziCreateDateFrom',
                'toName' => 'skziCreateDateTo',
                ],
            'skziVerifDate' => [
                'label' => 'Дата проверки СКЗИ',
                'type' => 'dateTime',
                'fromName' => 'skziVerifDateFrom',
                'toName' => 'skziVerifDateTo',
                ],
            'skziVerifExpires' => [
                'label' => 'Дата конца действия проверки СКЗИ',
                'type' => 'dateTime',
                'fromName' => 'skziVerifExpiresFrom',
                'toName' => 'skziVerifExpiresTo',
                ],
            ];
      case 'driver-card-atp': return [
          'cardNumber' => [
                'label' => 'Номер карты',
                'type' => 'string',
                ],
          'cardBeginDate' => [
                'label' => 'Дата начала действия карты',
                'type' => 'dateTime',
                'fromName' => 'cardBeginDateFrom',
                'toName' => 'cardBeginDateTo',
                ],
          'cardEndDate' => [
                'label' => 'Дата окончания действия карты',
                'type' => 'dateTime',
                'fromName' => 'cardEndDateFrom',
                'toName' => 'cardEndDateTo',
                ],
      ];
    }
    return [];
  }
}