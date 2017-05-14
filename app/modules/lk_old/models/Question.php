<?php
/**
 * @link http://alkodesign.ru
 */
namespace app\modules\lk\models;

use yii\db\ActiveRecord as ActiveRecord;

/**
 * A class of log of operations in back end for Alchemy CMS (Yii2)
 * Such actions like create, update, delete and so on are logged in DB if they are performed in back end.
 * 
 * @author AlkoDesign <info@alkodesign.ru>
 * @since 2.0
 */
class Question extends ActiveRecord
{
  CONST FROM_MANUFACTURE = 1;
  CONST FROM_MOTOR_COMPANY = 2;
  CONST FROM_CARD_PRODUCER = 3;
  CONST FROM_CONTROLLER = 4;
  CONST FROM_WORKROOM = 5;
    /**
     * @return string name of db table
     */
    public static function tableName()
    {
        return '{{%lk_question}}';
    }
    
    /**
     * Initialization
     */
    public function init()
    {
        parent::init();
        $this->_privateAdminName = 'Вопрос';
        $this->_privatePluralName = 'Вопросы';
        
    }
   
    
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['name', 'from', 'email', 'org_name', 'id_user', 'message'], 'safe', 'on' =>['insert', 'update']],
            [['from'], 'number', 'integerOnly' => true, 'on'=>['insert', 'update']],
            [['name', 'org_name', 'message'], 'string', 'on'=>['insert', 'update']],
            [['name', 'email', 'message'], 'required', 'on'=>['insert', 'update']],
            [['email'], 'email', 'on'=>['insert', 'update']],
            [['id', 'name', 'from', 'email', 'org_name', 'id_user', 'message', 'date_add'], 'safe', 'on'=>'search'],
        ];
    }
    
    /**
     * @return array labels of attributes
     */
    public function attributeLabels() {
        
        return [
            'id' => 'ID',
            'name' => 'ФИО',
            'from' => 'Вопрос задан из',
            'email' => 'Email',
            'org_name' => 'Организация',
            'id_user' => 'Пользователь',
            'message' => 'Текст обращения',
            'date_add' => 'Дата добавления',
        ];
    }
    
    /**
     * связь с пользователем
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
      return $this->hasOne(TUserIndentity::className(), ['id' => 'id_user']);
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
            'from',
            'email',
            'org_name',
            'id_user',
            'message',
            'date_add',
        ];
            
    }
    
    /**
     * список возможных отправителей
     * @return array
     */
    public static function getFromItems()
    {
      return [
          self::FROM_MANUFACTURE => 'Производитель тахографов',
          self::FROM_MOTOR_COMPANY => 'Автопредприятие',
          self::FROM_CARD_PRODUCER => 'Производитель карт',
          self::FROM_CONTROLLER => 'Контролёр',
          self::FROM_WORKROOM => 'Мастерская'
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
            'name' => 'RDbText',
            'from' => ['RDbSelect', 'data' => self::getFromItems()],
            'email' => 'RDbText',
            'org_name' => 'RDbText',
            'id_user' => ['RDbRelation', 'user'],
            'message' => ['RDbText', 'forceTextArea' => 'forceTextArea'],
            'date_add' => 'RDbDate',
        ];
    }   
    
    public function beforeSave($insert)
    {
      if(!$insert)//нельзя править вопросы
      {
        return false;
      }
      $this->id_user = \Yii::$app->user2->getId();
      $this->message = strip_tags($this->message);
      $this->org_name = strip_tags($this->org_name);
      $this->name = strip_tags($this->name);
      $this->email = strip_tags($this->email);
      return parent::beforeSave($insert);
    }
    
    /**
     * отправка сообщения
     */
    private function sendMail()
    {
      $mailHelper = new \app\components\MailHelper();
      $mailHelper->from = 'no-replay@'.$_SERVER['HTTP_HOST'];
      $mailHelper->to = \app\components\ConstantHelper::getValue('question-email');
      $mailHelper->mailTemplate = 'question-form';
      $mailHelper->params = [
          'NAME' => $this->name,
          'EMAIL' => $this->email,
          'ORGANIZATION' => $this->org_name,
          'MESSAGE' => $this->message,
          'DATETIME' => date('d.m.Y H:i:s')
      ];
      $mailHelper->send();
    }

    public function afterSave($insert, $changedAttributes)
    {
      if($insert)
      {
        $this->sendMail();
      }
      return parent::afterSave($insert, $changedAttributes);
    }
}
