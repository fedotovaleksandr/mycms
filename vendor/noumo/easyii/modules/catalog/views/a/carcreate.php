<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
$this->title = 'Добавление марки автомобиля';
echo $this->render('@easyii/views/category/_menu.php', ['category' => $model]);
echo $this->render('_form', ['model' => $model]); ?>


