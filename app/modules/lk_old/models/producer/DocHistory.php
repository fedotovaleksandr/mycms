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
class DocHistory extends ActiveRecord
{
    /**
     * @return string name of db table
     */
    public static function tableName()
    {
        return '{{%producer_docs_history}}';
    }
    
    /**
     * Initialization
     */
    public function init()
    {
        parent::init();
        $this->_privateAdminName = 'История изменений документа';
        $this->_privatePluralName = 'Логи изменений документа';
        
    }
   
    
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['id_doc', 'last_status', 'next_status', 'text'], 'safe', 'on' =>['insert', 'update']],
            [['id', 'id_doc', 'last_status', 'next_status', 'text', 'add_date'], 'safe', 'on'=>'search'],
        ];
    }
    
    /**
     * @return array labels of attributes
     */
    public function attributeLabels() {
        
        return [
            'id' => 'ID',
            'last_status' => 'Предыдущий статус',
            'next_status' => 'Новый статус',
            'id_doc' => 'Документ',
            'add_date' => 'Дата изменения',
            'text' => 'Комментарий'
        ];
    }
        
    
    /*for crud admin*/
    public $_privateAdminName; // One item name, used in breadcrums, in header in actionAdmin
    public $_privatePluralName;// Item set name
    public $_privateAdminRepr = 'id_doc';
    
    /**
     * @see \app\modules\privatepanel\components\PrivateModelAdmin::getAdminFields
     * @return array fields in list in back end
     */
    public function getAdminFields()
    {
        return [
            'id_doc',
            'last_status',
            'next_status',
            'text',
            'add_date'
        ];
            
    }
    
    public function getDocuments()
    {
      return $this->hasOne(Docs::className(), ['id' => 'id_parent']);
    }

    /**
     * @see \app\modules\privatepanel\components\PrivateModelAdmin::getFieldsDescription
     * @return array fields in list in back end
     */
    public function getFieldsDescription()
    {
        return [
            'id_doc' => ['RDbRelation', 'documents'],
            'last_status' => ['RDbSelect', 'data' => Docs::getStatusItems()],
            'next_status' => ['RDbSelect', 'data' => Docs::getStatusItems()],
            'text' => ['RDbText', 'forceTextArea' => 'forceTextArea'],
            'add_date' => 'RDbDate'
        ];
    }   
}
