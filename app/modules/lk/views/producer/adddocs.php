<?php
use yii\widgets\Pjax;
use yii\helpers\Html;
$this->title = 'Добавление документа';
?>
<?php Pjax::begin();?>
<h1>Добавление документа</h1>
<div><?=$status?></div>
<?=Html::beginForm('/lk/producer/add-doc/', 'POST', ['enctype' => 'multipart/form-data'])?>
<?=Html::activeHiddenInput($model, 'id_device_type');?>
<?=Html::activeHiddenInput($model, 'id_model');?>
<div>
  <label>Тип*</label>
  <?=Html::activeDropDownList($model, 'id_type', $model->getTypes(), ['required' => TRUE]);?>
</div>
<div>
  <label>Название документа*</label>
  <?=Html::activeTextInput($model, 'name', ['required' => TRUE]);?>
</div>
<div>
  <label>Файл*</label>
  <?=Html::activeFileInput($model, 'file', ['required' => TRUE]);?>
</div>
<div>
  <label>Версия*</label>
  <?=Html::activeTextInput($model, 'version', []);?>
</div>
<div>
  <label>Доступность*</label>
  <?=Html::activeCheckboxList($model, 'availability', $model->getAccessTypes(), ['required' => TRUE]);?>
</div>
<?=Html::errorSummary($model);?>
<?=Html::submitButton('Отправить');?>
<?=Html::endForm();?>
<?php Pjax::end(); ?>

