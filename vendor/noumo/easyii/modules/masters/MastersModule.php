<?php
namespace yii\easyii\modules\masters;

class MastersModule extends \yii\easyii\components\Module
{
    public $settings = [
        'enableThumb' => true,
        'enablePhotos' => true,
        'enableShort' => true,
        'shortMaxLength' => 256,
        'enableTags' => true
    ];

    public static $installConfig = [
        'title' => [
            'en' => 'Masters',
            'ru' => 'Мастеры',
        ],
        'icon' => 'bullhorn',
        'order_num' => 70,
    ];
}