<?php
use yii\helpers\Html;
$allFields = \app\modules\lk\components\Fields::getFields('tachograph');
$userFileds = app\modules\lk\models\TableSettings::getTableFieldList(\Yii::$app->user2->getId(), 'tachograph');
//var_dump($userFileds);
?>
<div style="width:49%;display:inline-block;">
  <h3>Таблица Тахографы</h3>
<?=Html::beginForm('/lk/producer/table/', 'POST');?>
  <?=Html::hiddenInput('table', 'tachograph');?>
  <?php
  foreach ($allFields as $fieldId => $option)
  {
    $checked = $option['view_required'] || array_key_exists($fieldId, $userFileds);
    $disable = $option['view_required'];
    ?>
  <div>
    <?=Html::label($option['label'], $fieldId, []);?>
    <?=Html::checkbox($fieldId, $checked, ['disable' => $disable, 'value' => 1, 'id' => $fieldId]);?>
  </div>
  <?php
  }
  ?>
  <?=Html::submitButton();?>
<?=Html::endForm();?>
</div>
<?php
$allFields = \app\modules\lk\components\Fields::getFields('skzi');
$userFileds = app\modules\lk\models\TableSettings::getTableFieldList(\Yii::$app->user2->getId(), 'skzi');
//var_dump($userFileds);
?>
<div style="width:49%;display:inline-block;">
  <h3>Таблица СКЗИ</h3>
<?=Html::beginForm('/lk/producer/table/', 'POST');?>
  <?=Html::hiddenInput('table', 'skzi');?>
  <?php
  foreach ($allFields as $fieldId => $option)
  {
    $checked = $option['view_required'] || array_key_exists($fieldId, $userFileds);
    $disable = $option['view_required'];
    ?>
  <div>
    <?=Html::label($option['label'], $fieldId, []);?>
    <?=Html::checkbox($fieldId, $checked, ['disable' => $disable, 'value' => 1, 'id' => $fieldId]);?>
  </div>
  <?php
  }
  ?>
  <?=Html::submitButton();?>
<?=Html::endForm();?>
</div>