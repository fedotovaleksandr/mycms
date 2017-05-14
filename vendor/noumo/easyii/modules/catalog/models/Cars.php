<?php
/**
 * Created by PhpStorm.
 * User: Artur
 * Date: 08.05.2017
 * Time: 14:24
 */

namespace yii\easyii\modules\catalog\models;
use Yii;

class Cars extends \yii\easyii\components\ActiveRecord
{
    const STATUS_OFF = 0;
    const STATUS_ON = 1;
    public static function tableName()
    {
        return 'easyii_brands_of_cars';
    }
    public function rules()
    {
        return [
            [['id'],'integer'],
            [['name','image'], 'string'],
            ['slug', 'match', 'pattern' => self::$SLUG_PATTERN, 'message' => Yii::t('easyii', 'Slug can contain only 0-9, a-z and "-" characters (max: 128).')],
            ['status', 'default', 'value' => self::STATUS_ON],
            [['name','slug'], 'required']
        ];
    }
    public function attributeLabels()
    {
        return [
            'name'=>'Название',
            'image'=>'Фото'
        ];
    }




}