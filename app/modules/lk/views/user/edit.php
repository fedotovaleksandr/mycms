<?php
use yii\helpers\Html;
$this->title = 'Редактирование профиля';
?>
<?=$this->render('menu');?>
<main class="page-main">
  <div class="breadcrumbs">
    <div class="container">
      <ul>
        <li><a href="/">Главная страница</a></li>
        <li class="active">Редактирование профиля</li>
      </ul>
    </div>
  </div>
  <div class="container">
    <section>
      <div class="form-block">
        <div class="form-block__inner">
          <div class="cell__xlg-7 cell__lg-8 cell__md-9 center-block text--center">
              <?=Html::beginForm('/lk/user/edit/', 'POST', ['enctype' => 'multipart/form-data'])?>
                <div class="row">
                  <div class="cell cell__xs-4">&nbsp;</div>
                  <div class="cell cell__xs-4">
                    <h2>Редактирование профиля</h2>
                    <?php
                    if(!count($model->getErrors()) && \Yii::$app->request->isPost)
                    {
                      ?><h6>Изменения сохранены</h6><?php
                    }
                    ?>
                    <div class="form__group">
                      <fieldset>
                        <?=Html::activePasswordInput($model, 'password', ['required' => TRUE, 'autocomplete' => "off", 'class' => "form-control edited"]);?>
                        <label>Старый пароль</label>
                      </fieldset>
                    </div>
                    <div class="form__group">
                      <fieldset>
                        <?=Html::activePasswordInput($model, 'newPassword', ['required' => TRUE, 'autocomplete' => "off", 'class' => "form-control edited"]);?>
                        <label>Новый пароль</label>
                      </fieldset>
                    </div>
                    <div class="form__group">
                      <fieldset>
                        <?=Html::activeTextInput($model, 'lastName', ['autocomplete' => "off", 'class' => "form-control edited"]);?>
                        <label>Фамилия</label>
                      </fieldset>
                    </div>
                    <div class="form__group">
                      <fieldset>
                        <?=Html::activeTextInput($model, 'firstName', ['autocomplete' => "off", 'class' => "form-control edited"]);?>
                        <label>Имя</label>
                      </fieldset>
                    </div>
                    <div class="form__group">
                      <fieldset>
                        <?=Html::activeTextInput($model, 'middleName', ['autocomplete' => "off", 'class' => "form-control edited"]);?>
                        <label>Отчество</label>
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
                      <fieldset><button type="submit" class="btn btn__lg btn--primary">Сохранить</button></fieldset>
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