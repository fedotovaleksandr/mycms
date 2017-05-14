<?php
$userModel = \Yii::$app->user2->getIdentity();
?>
<header class="page-header">
  <div class="page-header__top">
    <div class="container">
      <div class="navbar">
        <div class="navbar__left">
          <div class="page-header__logo">
            <a href="/lk/workroom/">
              <img src="/web/lk/workroom/images/logo.png" alt="<?=$userModel->getOrgName()?>">
              <span class="text__lg">Личный кабинет мастерской<br><?=$userModel->getOrgName()?></span>
            </a>
          </div>
          <div class="page-header__ava">
            <img src="/web/lk/workroom/images/ava.png" alt="<?=$userModel->getName()?>">
            <span class="text__md"><?=$userModel->getName()?><br><a href="/lk/workroom/out/" class="text--primary">Выйти</a></span>
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
            <li class="main-nav__item"><a href="/lk/workroom/" title="Главная страница">Главная страница</a>
              <ul class="sub-nav main-nav__items">
              </ul>
            </li>
            <li class="main-nav__item"><a href="/lk/workroom/activation/" title="Мои активизации">Мои активизации</a>
              <ul class="sub-nav main-nav__items">
              </ul>
            </li>
            <li class="main-nav__item"><a href="/lk/workroom/cards/" title="Карты и сроки их действия">Карты и сроки их действия</a>
              <ul class="sub-nav main-nav__items">
              </ul>
            </li>
            <li class="main-nav__item"><a href="/lk/workroom/activation-archive/" title="Архив активизаций">Архив активизаций</a>
              <ul class="sub-nav main-nav__items">
              </ul>
            </li>
            <li class="main-nav__item"><a href="/lk/workroom/info/" title="Информация о мастерской">Информация о мастерской</a>
              <ul class="sub-nav main-nav__items">
              </ul>
            </li>
            <li class="main-nav__item"><a href="/lk/workroom/help/" title="Помощь в использовании">Помощь в использовании</a>
              <ul class="sub-nav main-nav__items">
              </ul>
            </li>
            <li class="main-nav__item"><a href="/lk/workroom/question/" title="Задать вопрос">Задать вопрос</a>
              <ul class="sub-nav main-nav__items">
              </ul>
            </li>
          </ul>
      </nav>
    </div>
  </div>
</header>