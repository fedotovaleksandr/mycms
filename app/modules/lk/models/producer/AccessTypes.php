<?php
/**
 * @link http://alkodesign.ru
 */
namespace app\modules\lk\models\producer;

use yii\db\ActiveRecord as ActiveRecord;

/**
 * A class of log of operations in back end for Alchemy CMS (Yii2)
 * Such actions like create, update, delete and so on are logged in DB if they are performed in back end.
 * 
 * @author AlkoDesign <info@alkodesign.ru>
 * @since 2.0
 */
class AccessTypes extends ActiveRecord
{
  CONST ALL = 1;
  CONST MOTOR_COMPANY = 2;
  CONST WORKROOM = 3;
  CONST CONTROLLER = 4;
  
    /**
     * @return string name of db table
     */
    public static function tableName()
    {
        return '{{%producer_accesstypes}}';
    }
    
    /**
     * Initialization
     */
    public function init()
    {
        parent::init();
        $this->_privateAdminName = 'Тип доступов';
        $this->_privatePluralName = 'Типы доступов';
        
    }
   
    
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['id', 'name'], 'safe', 'on' =>['insert', 'update']],
            [['name'], 'required', 'on'=>['insert', 'update']],
            [['name'], 'string', 'on'=>['insert', 'update']],
            [['id', 'name'], 'safe', 'on'=>'search'],
        ];
    }
    
    /**
     * @return array labels of attributes
     */
    public function attributeLabels() {
        
        return [
            'id' => 'ID',
            'name' => 'Название',
        ];
    }
        
    
    /*for crud admin*/
    public $_privateAdminName; // One item name, used in breadcrums, in header in actionAdmin
    public $_privatePluralName;// Item set name
    public $_privateAdminRepr = 'name';
    
    /**
     * @see \app\modules\privatepanel\components\PrivateModelAdmin::getAdminFields
     * @return array fields in list in back end
     */
    public function getAdminFields()
    {
        return [
            'id',
            'name',
        ];
            
    }

    /**
     * @see \app\modules\privatepanel\components\PrivateModelAdmin::getFieldsDescription
     * @return array fields in list in back end
     */
    public function getFieldsDescription()
    {
        return [
            'id' => 'RDbText',
            'name' => 'RDbText'
        ];
    }   
}
