<?php
use yii\helpers\Html;
$this->title = 'Задать вопрос';
?>
<?=$this->render('menu');?>
<main class="page-main">
  <div class="breadcrumbs">
    <div class="container">
      <ul>
        <li><a href="/lk/workroom/">Главная страница</a></li>
        <li class="active">Задать вопрос</li>
      </ul>
    </div>
  </div>
  <div class="container">
    <section>
      <div class="text--center">
        <h1>Задать вопрос</h1>
      </div>
      <div class="form-block">
        <div class="row">
          <div class="cell__xs-8 center-block">
            <div class="form-block__inner">
              <?php
              if($status === FALSE) {
              ?>
              <?=Html::beginForm('/lk/workroom/question/', 'POST', ['enctype' => 'multipart/form-data'])?>
              <?=Html::activeHiddenInput($model, 'from');?>
                <div class="row">
                  <div class="cell cell__xs-6">
                    <div class="form__group">
                      <fieldset>
                        <?=Html::activeTextInput($model, 'name', ['required' => TRUE, 'autocomplete' => "off", 'class' => "form-control edited"]);?>
                        <label>ФИО</label>
                      </fieldset>
                    </div>
                    <div class="form__group">
                      <fieldset>
                        <?=Html::activeTextInput($model, 'org_name', ['required' => TRUE, 'autocomplete' => "off", 'class' => "form-control edited"]);?>
                        <label>Организация</label>
                      </fieldset>
                    </div>
                    <div class="form__group">
                      <fieldset>
                        <?=Html::activeTextInput($model, 'email', ['required' => TRUE, 'autocomplete' => "off", 'class' => "form-control edited", 'type' => 'email']);?>
                        <label>Ответ направить на e-mail адрес</label>
                      </fieldset>
                    </div>
                  </div>
                  <div class="cell cell__xs-6">
                    <div class="form__group">
                        <label for="text"></label>
                        <?=Html::activeTextArea($model, 'message', ['required' => TRUE, 'placeholder' => "Текст сообщения", 'rows'=>"8", 'class'=>"form-control"]);?>
                    </div>
                  </div>
                </div>
                <div class="text--right">
                  <button type="submit" class="btn btn__lg btn--primary">Отправить</button>
                </div>
              <?=Html::endForm();?>
              <?php }else{ ?>
              <div class="row">
                Сообщение отправлено
              </div>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</main>


