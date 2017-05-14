<?php
use yii\helpers\Html;
$this->title = 'Вход в личный кабинет';
?>
<?=$this->render('menu');?>
<main class="page-main">
  <div class="breadcrumbs">
    <div class="container">
      <ul>
        <li><a href="/">Главная страница</a></li>
        <li class="active">Авторизация</li>
      </ul>
    </div>
  </div>
  <div class="container">
    <section>
      <div class="form-block">
        <div class="form-block__inner">
          <div class="cell__xlg-7 cell__lg-8 cell__md-9 center-block text--center">
              <?=Html::beginForm('/lk/user/login/', 'POST', ['enctype' => 'multipart/form-data'])?>
                <div class="row">
                  <div class="cell cell__xs-4">&nbsp;</div>
                  <div class="cell cell__xs-4">
                    <div class="form__group">
                      <fieldset>
                        <?=Html::activeTextInput($model, 'login', ['required' => TRUE, 'autocomplete' => "off", 'class' => "form-control edited"]);?>
                        <label>Логин</label>
                      </fieldset>
                    </div>
                    <div class="form__group">
                      <fieldset>
                        <?=Html::activePasswordInput($model, 'password', ['required' => TRUE, 'autocomplete' => "off", 'class' => "form-control edited"]);?>
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
                      <fieldset><button type="submit" class="btn btn__lg btn--primary">Войти</button><a href="/site/registration" class="btn btn__lg btn--primary">Регистрация</a></fieldset>
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