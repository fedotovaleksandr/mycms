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
              <span class="text__md"><?=$userModel->getName()?><br><a href="/lk/card-producer/out/" class="text--primary">Выйти</a></span>
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