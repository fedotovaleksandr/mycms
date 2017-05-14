<?php
use yii\helpers\Html;
?>
<header class="page-header">
  <div class="page-header__top">
    <div class="container">
      <div class="navbar">
        <div class="navbar__left">
              <img src="/web/lk/producer/images/logo.png" alt="">
              <?php
              if(\Yii::$app->user2->isGuest){ ?>
                <span class="text__lg">Вход в личный кабинет<br></span>
              <?php }else{ ?>
                <span class="text__lg">Личный кабинет<br></span>
              <?php } ?>
          </div>
          <?php if(!\Yii::$app->user2->isGuest){ 
            $userModel = \Yii::$app->user2->getIdentity();
            ?>
            <div class="page-header__ava">
              <img src="/web/lk/producer/images/ava.png" alt="<?=$userModel->getName()?>">
              <span class="text__md"><?=$userModel->getName()?><br><a href="/lk/user/logout/" class="text--primary">Выйти</a></span>
            </div>
          <?php } ?>
        </div>
        <div class="navbar__right"><a href="/" class="btn btn--transparent">Перейти в портал</a></div>
      </div>
    </div>
  </div>
  <div class="page-header__bottom">
    <div class="container">
      <nav class="main-nav">
          <ul class="main-nav__items">
            <li class="main-nav__item"><a href="#">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
              <ul class="sub-nav main-nav__items">
              </ul>
            </li>
          </ul>
      </nav>
    </div>
  </div>
</header>
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
              <?=Html::beginForm('', 'POST', ['enctype' => 'multipart/form-data'])?>
                <div class="row">
                  <div class="cell cell__xs-4">&nbsp;</div>
                  <div class="cell cell__xs-4">
                    <div class="form__group">
                      <fieldset>
                        <?=Html::textInput('producer-login', '', ['required' => TRUE, 'autocomplete' => "off", 'class' => "form-control edited"]);?>
                        <label>Логин</label>
                      </fieldset>
                    </div>
                    <div class="form__group">
                      <fieldset>
                        <?=Html::passwordInput('producer-pass', '', ['required' => TRUE, 'autocomplete' => "off", 'class' => "form-control edited"]);?>
                        <label>Пароль</label>
                      </fieldset>
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