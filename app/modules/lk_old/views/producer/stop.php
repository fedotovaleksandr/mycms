<?php
use yii\helpers\Html;
?>
<?=$this->render('menu');?>
<h1>Добавить в стоп лист</h1>
<?=Html::beginForm('', 'POST', ['enctype' => 'multipart/form-data']);?>
<div><?=$status;?></div>
<?=Html::fileInput('stop');?>
<?=Html::submitButton('Отправить');?>
<?=Html::endForm();?>