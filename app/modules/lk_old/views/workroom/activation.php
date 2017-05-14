<?php
use yii\helpers\Html;
$this->title = 'Проверка возможности проведения активизации';
?>
<?=$this->render('menu');?>
<main class="page-main">
  <div class="breadcrumbs">
    <div class="container">
      <ul>
        <li><a href="/lk/workroom/">Главная страница</a></li>
        <li class="active">Мои активизации</li>
      </ul>
    </div>
  </div>
  <div class="container">
    <section>
	<div class="text--center">
        <h1>Мои активизации</h1>
      </div>
	<div class="form-block">
		<div class="cell__xs-8 center-block">	
			<div class="form-block__inner"> 
<?=Html::beginForm();?>
<?php $activationForm->formType = 'without_doc'; ?>
<?=Html::activeHiddenInput($activationForm, 'formType', [])?>
<div><?=Html::activeLabel($activationForm, 'orgName')?> <?=Html::activeTextInput($activationForm, 'orgName', ['class' => "form-control edited"])?></div>
<div><?=Html::activeLabel($activationForm, 'OGRN')?> <?=Html::activeTextInput($activationForm, 'OGRN', ['class' => "form-control edited"])?></div>
<div><?=Html::activeLabel($activationForm, 'INN')?> <?=Html::activeTextInput($activationForm, 'INN', ['class' => "form-control edited"])?></div>
<div><?=Html::activeLabel($activationForm, 'regionCode')?> <?=Html::activeTextInput($activationForm, 'regionCode', ['class' => "form-control edited"])?></div>
<div><?=Html::activeLabel($activationForm, 'cityName')?> <?=Html::activeTextInput($activationForm, 'cityName', ['class' => "form-control edited"])?></div>
<div><?=Html::activeLabel($activationForm, 'address')?> <?=Html::activeTextInput($activationForm, 'address', ['class' => "form-control edited"])?></div>
<div><?=Html::activeLabel($activationForm, 'brand')?> <?=Html::activeTextInput($activationForm, 'brand', ['class' => "form-control edited"])?></div>
<div><?=Html::activeLabel($activationForm, 'model')?> <?=Html::activeTextInput($activationForm, 'model', ['class' => "form-control edited"])?></div>
<div><?=Html::activeLabel($activationForm, 'vendorDate')?> <?=Html::activeTextInput($activationForm, 'vendorDate', ['class' => "form-control edited"])?></div>
<div><?=Html::activeLabel($activationForm, 'color')?> <?=Html::activeTextInput($activationForm, 'color', ['class' => "form-control edited"])?></div>
<div><?=Html::activeLabel($activationForm, 'regNumber')?> <?=Html::activeTextInput($activationForm, 'regNumber', ['class' => "form-control edited"])?></div>
<div><?=Html::activeLabel($activationForm, 'VIN')?> <?=Html::activeTextInput($activationForm, 'VIN', ['class' => "form-control edited"])?></div>
<div><?=Html::activeLabel($activationForm, 'PTS')?> <?=Html::activeTextInput($activationForm, 'PTS', ['class' => "form-control edited"])?></div>
<div><?=Html::activeLabel($activationForm, 'tachoNumber')?> <?=Html::activeTextInput($activationForm, 'tachoNumber', ['class' => "form-control edited"])?></div>
<div><?=Html::activeLabel($activationForm, 'skziNumber')?> <?=Html::activeTextInput($activationForm, 'skziNumber', ['class' => "form-control edited"])?></div>
<br/>
<div><?=Html::submitButton('Отправить на проверку', ['class' =>"btn btn__lg btn--primary"])?>
<button onclick="fillFormWithDoc($(this).parents('form'));return false;" class="btn btn__lg btn--primary">Отправить на разрешение</button></div>
<?=Html::endForm();?>
</div>
</div>
</div>
<br/><br/>
<?=Html::beginForm('', 'POST', ['id' => 'activation-form-with-doc']);?>
Прикрепите документы для подтверждения
неформатных данных
<?php $activationForm->formType = 'with_doc'; ?>
<?=Html::activeHiddenInput($activationForm, 'formType', [])?>
<?=Html::activeHiddenInput($activationForm, 'orgName', [])?>
<?=Html::activeHiddenInput($activationForm, 'OGRN', [])?>
<?=Html::activeHiddenInput($activationForm, 'INN', [])?>
<?=Html::activeHiddenInput($activationForm, 'regionCode', [])?>
<?=Html::activeHiddenInput($activationForm, 'cityName', [])?>
<?=Html::activeHiddenInput($activationForm, 'address', [])?>
<?=Html::activeHiddenInput($activationForm, 'brand', [])?>
<?=Html::activeHiddenInput($activationForm, 'model', [])?>
<?=Html::activeHiddenInput($activationForm, 'vendorDate', [])?>
<?=Html::activeHiddenInput($activationForm, 'color', [])?>
<?=Html::activeHiddenInput($activationForm, 'regNumber', [])?>
<?=Html::activeHiddenInput($activationForm, 'VIN', [])?>
<?=Html::activeHiddenInput($activationForm, 'PTS', [])?>
<?=Html::activeHiddenInput($activationForm, 'tachoNumber', [])?>
<?=Html::activeHiddenInput($activationForm, 'skziNumber', [])?>
<div><?=Html::activeLabel($activationForm, 'PTSDoc')?> <?=Html::activeFileInput($activationForm, 'PTSDoc', [])?></div>
<?=Html::submitButton('Отправить на разрешение', ['class' =>"btn btn__lg btn--primary"])?>
<?=Html::endForm();?>
<br/><br/><br/>
<a href="/lk/workroom/activation-archive/" >Таблица с последними активациями</a>
<?php foreach($lastActivations as $lastActivation){?>
<?php } ?>

<div><a href="/lk/workroom/activation-archive/" >Архив активизаций</a></div>
=======
      <div class="text--center">
        <h1>Мои активизации</h1>
      </div>
      <div class="form-block">
        <div class="cell__xs-8 center-block">
          <div class="form-block__inner">
            <?=Html::beginForm();?>
            <?php $activationForm->formType = 'without_doc'; ?>
            <?=Html::activeHiddenInput($activationForm, 'formType', [])?>
            <div><?=Html::activeLabel($activationForm, 'orgName')?> <?=Html::activeTextInput($activationForm, 'orgName', ['class' => "form-control edited"])?></div>
            <div><?=Html::activeLabel($activationForm, 'OGRN')?> <?=Html::activeTextInput($activationForm, 'OGRN', ['class' => "form-control edited"])?></div>
            <div><?=Html::activeLabel($activationForm, 'INN')?> <?=Html::activeTextInput($activationForm, 'INN', ['class' => "form-control edited"])?></div>
            <div><?=Html::activeLabel($activationForm, 'regionCode')?> <?=Html::activeTextInput($activationForm, 'regionCode', ['class' => "form-control edited"])?></div>
            <div><?=Html::activeLabel($activationForm, 'cityName')?> <?=Html::activeTextInput($activationForm, 'cityName', ['class' => "form-control edited"])?></div>
            <div><?=Html::activeLabel($activationForm, 'address')?> <?=Html::activeTextInput($activationForm, 'address', ['class' => "form-control edited"])?></div>
            <div><?=Html::activeLabel($activationForm, 'brand')?> <?=Html::activeTextInput($activationForm, 'brand', ['class' => "form-control edited"])?></div>
            <div><?=Html::activeLabel($activationForm, 'model')?> <?=Html::activeTextInput($activationForm, 'model', ['class' => "form-control edited"])?></div>
            <div><?=Html::activeLabel($activationForm, 'vendorDate')?> <?=Html::activeTextInput($activationForm, 'vendorDate', ['class' => "form-control edited"])?></div>
            <div><?=Html::activeLabel($activationForm, 'color')?> <?=Html::activeTextInput($activationForm, 'color', ['class' => "form-control edited"])?></div>
            <div><?=Html::activeLabel($activationForm, 'regNumber')?> <?=Html::activeTextInput($activationForm, 'regNumber', ['class' => "form-control edited"])?></div>
            <div><?=Html::activeLabel($activationForm, 'VIN')?> <?=Html::activeTextInput($activationForm, 'VIN', ['class' => "form-control edited"])?></div>
            <div><?=Html::activeLabel($activationForm, 'PTS')?> <?=Html::activeTextInput($activationForm, 'PTS', ['class' => "form-control edited"])?></div>
            <div><?=Html::activeLabel($activationForm, 'tachoNumber')?> <?=Html::activeTextInput($activationForm, 'tachoNumber', ['class' => "form-control edited"])?></div>
            <div><?=Html::activeLabel($activationForm, 'skziNumber')?> <?=Html::activeTextInput($activationForm, 'skziNumber', ['class' => "form-control edited"])?></div>
            <br/>
            <div><?=Html::submitButton('Отправить на проверку', ['class' =>"btn btn__lg btn--primary"])?>
              <button onclick="fillFormWithDoc($(this).parents('form'));return false;" class="btn btn__lg btn--primary">Отправить на разрешение</button></div>
            <?=Html::endForm();?>
          </div>
        </div>
      </div>
      <br/><br/>
      <?=Html::beginForm('', 'POST', ['id' => 'activation-form-with-doc']);?>
      Прикрепите документы для подтверждения
      неформатных данных
      <?php $activationForm->formType = 'with_doc'; ?>
      <?=Html::activeHiddenInput($activationForm, 'formType', [])?>
      <?=Html::activeHiddenInput($activationForm, 'orgName', [])?>
      <?=Html::activeHiddenInput($activationForm, 'OGRN', [])?>
      <?=Html::activeHiddenInput($activationForm, 'INN', [])?>
      <?=Html::activeHiddenInput($activationForm, 'regionCode', [])?>
      <?=Html::activeHiddenInput($activationForm, 'cityName', [])?>
      <?=Html::activeHiddenInput($activationForm, 'address', [])?>
      <?=Html::activeHiddenInput($activationForm, 'brand', [])?>
      <?=Html::activeHiddenInput($activationForm, 'model', [])?>
      <?=Html::activeHiddenInput($activationForm, 'vendorDate', [])?>
      <?=Html::activeHiddenInput($activationForm, 'color', [])?>
      <?=Html::activeHiddenInput($activationForm, 'regNumber', [])?>
      <?=Html::activeHiddenInput($activationForm, 'VIN', [])?>
      <?=Html::activeHiddenInput($activationForm, 'PTS', [])?>
      <?=Html::activeHiddenInput($activationForm, 'tachoNumber', [])?>
      <?=Html::activeHiddenInput($activationForm, 'skziNumber', [])?>
      <div><?=Html::activeLabel($activationForm, 'ptsDoc')?> <?=Html::activeFileInput($activationForm, 'ptsDoc', [])?></div>
      <?=Html::submitButton('Отправить на разрешение', ['class' =>"btn btn__lg btn--primary"])?>
      <?=Html::endForm();?>
      <br/><br/><br/>
      <a href="/lk/workroom/activation-archive/" >Таблица с последними активациями</a>
      <?php foreach($lastActivations as $lastActivation){?>
      <?php } ?>

      <div><a href="/lk/workroom/activation-archive/" >Архив активизаций</a></div>
>>>>>>> mo-local
    </section>
  </div>
</main>

<script>
  /**
   * копирование данных форму с документами
   * @param {jQUery} form форма откуда будут копироваться данные
   * @param {Object} errorForm список необходимых документов
   */
  function fillFormWithDoc(form, errorForm)
  {
    var form = $(elem).parents('form');
    var form2 = $('#activation-form-with-doc');
    form.find('input, select, textarea').each(function(i, elem){
      if($(elem).attr('type') === 'hidden')
      {
        return;
      }
      if($(elem).attr('type') === 'checkbox')
      {
        form2.find('#'+$(elem).attr('id')).prop('checked', $(elem).prop('checked'));
      }
      else
      {
        form2.find('#'+$(elem).attr('id')).val($(elem).val());
      }
    })
  }
</script>
<!--
осноную форму сделать на ajax
если какое-то поле оказалось с ошибкой, то открывать форму с выбором: отредактировать или отправить на разрешение
при нажатии на отправить на разрешение, данные из первой формы копируются во второй и должны быть отправлены вместе с документами

При нажатии «Редактировать данные» должен происходить возврат к блоку ввода данных для проведения активизации и выделяться красным неправильно введённые поля.
При нажатии «Отправить на разрешение»  должно открываться следующее окно в котором должно быть предложено прикрепить документы для подтверждения правильности введенных неформатных данных. Названия и количество полей должно соответствовать названию и тем полям которые были введены неправильно:

-->