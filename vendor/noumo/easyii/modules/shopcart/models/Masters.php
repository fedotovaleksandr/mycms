<?php
namespace yii\easyii\modules\shopcart\models;
use Yii;

class Masters extends \yii\easyii\components\ActiveRecord
{
    public static function tableName()
    {
        return 'easyii_masters';
    }
    public function rules()
    {
        return [
            [['id','status'],'integer'],
            [['name'], 'string'],
            [['exp'], 'string'],
            [['rating'], 'string'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'name'=>'Имя',
            'exp'=>'Стаж',
            'rating'=>'Рейтинг'
        ];
    }
}