<?php
$userModel = \Yii::$app->user2->getIdentity();
?>
<header class="page-header">
  <div class="page-header__top">
    <div class="container">
      <div class="navbar">
        <div class="navbar__left">
          <div class="page-header__logo">
            <a href="/lk/controller/">
              <img src="/web/lk/producer/images/logo.png" alt="Company ltd.">
              <span class="text__lg">Личный кабинет<br><?=$userModel->getOrgName()?></span>
            </a>
          </div>
          <div class="page-header__ava">
            <img src="/web/lk/producer/images/ava.png" alt="<?=$userModel->getName()?>">
            <span class="text__md"><?=$userModel->getName()?><br><a href="/lk/card-producer/out/" class="text--primary">Выйти</a></span>
          </div>
        </div>
        <div class="navbar__right"><a href="/" class="btn btn--transparent">Перейти в портал</a></div>
      </div>
    </div>
  </div>
  <div class="page-header__bottom">
    <div class="container">
      <nav class="main-nav">
          <ul class="main-nav__items">
            <li class="main-nav__item"><a href="/lk/controller/" title="Главная страница">Главная страница</a>
              <ul class="sub-nav main-nav__items">
              </ul>
            </li>
            <li class="main-nav__item"><a href="#" title="">Список выпущенных карт</a>
              <ul class="sub-nav main-nav__items">
              </ul>
            </li>
            <li class="main-nav__item"><a href="#" title="">Помощь в использовании</a>
              <ul class="sub-nav main-nav__items">
              </ul>
            </li>
            <li class="main-nav__item"><a href="#" title="">Задать вопрос</a>
              <ul class="sub-nav main-nav__items">
              </ul>
            </li>
          </ul>
      </nav>
    </div>
  </div>
</header>