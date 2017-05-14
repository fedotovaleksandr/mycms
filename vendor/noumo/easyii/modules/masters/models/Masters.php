<?php
namespace yii\easyii\modules\masters\models;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\easyii\behaviors\SeoBehavior;
use yii\easyii\behaviors\Taggable;
use yii\easyii\models\Photo;
use yii\helpers\StringHelper;

class Masters extends \yii\easyii\components\ActiveRecord
{
    const STATUS_OFF = 0;
    const STATUS_ON = 1;
    public static function tableName()
    {
        return 'easyii_masters';
    }
    public function rules()
    {
        return [
            [['id','status'],'integer'],
            [['name','image','exp','rating'], 'string'],
            ['slug', 'match', 'pattern' => self::$SLUG_PATTERN, 'message' => Yii::t('easyii', 'Slug can contain only 0-9, a-z and "-" characters (max: 128).')],
            ['status', 'default', 'value' => self::STATUS_ON],
            [['name'], 'required']
        ];
    }
    public function attributeLabels()
    {
        return [
            'name'=>'Имя',
            'exp'=>'Стаж',
            'rating'=>'Рейтинг',
                'image'=>'Фото'
        ];
    }
    public function behaviors()
    {
        return [
            'taggabble' => Taggable::className(),
            'sluggable' => [
                'class' => SluggableBehavior::className(),
                'attribute' => 'name',
                'ensureUnique' => true
            ],
        ];
    }
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $settings = Yii::$app->getModule('admin')->activeModules['masters']->settings;

            if(!$insert && $this->image != $this->oldAttributes['image'] && $this->oldAttributes['image']){
                @unlink(Yii::getAlias('@webroot').$this->oldAttributes['image']);
            }
            return true;
        } else {
            return false;
        }
    }
//    public function beforeSave($insert)
//    {
//        if (parent::beforeSave($insert)) {
//            if(!$insert && $this->photo != $this->oldAttributes['photo'] && $this->oldAttributes['photo']){
//                @unlink(Yii::getAlias('@webroot').$this->oldAttributes['photo']);
//            }
//            return true;
//        } else {
//            return false;
//        }
//    }
}
