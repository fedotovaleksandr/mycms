<?php
use yii\helpers\Html;
$this->title = 'Вам необходимо скачать и установить SSL сертификат';
?>
<?=$this->render('menu');?>
<main class="page-main">
  <div class="breadcrumbs">
    <div class="container">
      <ul>
        <li><a href="/">Главная страница</a></li>
        <li class="active">SSL сертификат</li>
      </ul>
    </div>
  </div>
  <div class="container">
    <section>
      <div class="form-block">
        <div class="form-block__inner">
          <div class="cell__xlg-7 cell__lg-8 cell__md-9 center-block text--center">
            Вам необходимо скачать и установить SSL сертификат
              <?=Html::beginForm('/lk/user/ssl/', 'POST', ['enctype' => 'multipart/form-data'])?>
                <div class="row">
                  <div class="cell cell__xs-4">&nbsp;</div>
                  <div class="cell cell__xs-4">
                    <div class="form__group">
                      <fieldset>
                        <?=Html::activeTextInput($model, 'login', ['required' => TRUE, 'autocomplete' => "off", 'class' => "form-control "]);?>
                        <label>Логин</label>
                      </fieldset>
                    </div>
                    <div class="form__group">
                      <fieldset>
                        <?=Html::activePasswordInput($model, 'password', ['required' => TRUE, 'autocomplete' => "off", 'class' => "form-control "]);?>
                        <label>Пароль</label>
                      </fieldset>
                    </div>
                    <div class="form__group error-list">
                      <ul>
                        <?php
                        foreach($model->getErrors() as $errors)
                        {
                          if(is_array($errors))
                          {
                            foreach($errors as $error)
                            {
                            ?>
                            <li><?=$error;?></li>
                            <?php
                            }
                          }else
                          {
                            ?><li><?=$errors;?></li><?php
                          }
                        }
                        ?>
                      </ul>
                    </div>
                    <div class="form__group">
                      <fieldset><button type="submit" class="btn btn__lg btn--primary">Получить</button></fieldset>
                    </div>
                  </div>
                  <div class="cell cell__xs-4">&nbsp;</div>
                </div>
              <?=Html::endForm();?>
          </div>
        </div>
      </div>
    </section>
  </div>
</main>