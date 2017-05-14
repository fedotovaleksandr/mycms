<?php
$this->title = 'Личный кабинет';
?>
<?=$this->render('menu');?>
<main class="page-main">
  <div class="container">
    <section>
      <h1>Доступные действия</h1>
      <div class="row actions">
        <div class="cell cell__xs-4"><a href="/lk/workroom/activation/" class="actions__item">
            <div class="actions__item--img"><img src="/web/lk/workroom/images/actions-img-1.png" alt=""></div>
            <div class="actions__item--title">
              <h4 class="text--primary">Мои активизации</h4>
            </div></a></div>
        <div class="cell cell__xs-4"><a href="/lk/workroom/cards/" class="actions__item">
            <div class="actions__item--img"><img src="/web/lk/workroom/images/actions-img-2.png" alt=""></div>
            <div class="actions__item--title">
              <h4 class="text--primary">Карты и сроки их действия</h4>
            </div></a></div>
        <div class="cell cell__xs-4"><a href="/lk/workroom/activation-archive/" class="actions__item">
            <div class="actions__item--img"><img src="/web/lk/workroom/images/actions-img-3.png" alt=""></div>
            <div class="actions__item--title">
              <h4 class="text--primary">Архив активизаций</h4>
            </div></a></div>
        <div class="cell cell__xs-4"><a href="/lk/workroom/info/" class="actions__item">
            <div class="actions__item--img"><img src="/web/lk/workroom/images/actions-img-4.png" alt=""></div>
            <div class="actions__item--title">
              <h4 class="text--primary">Информация о мастерской</h4>
            </div></a></div>
        <div class="cell cell__xs-4"><a href="/lk/workroom/help/" class="actions__item">
            <div class="actions__item--img"><img src="/web/lk/workroom/images/actions-img-5.png" alt=""></div>
            <div class="actions__item--title">
              <h4 class="text--primary">Помощь в использовании</h4>
            </div></a></div>
        <div class="cell cell__xs-4"><a href="/lk/workroom/question/" class="actions__item">
            <div class="actions__item--img"><img src="/web/lk/workroom/images/actions-img-6.png" alt=""></div>
            <div class="actions__item--title">
              <h4 class="text--primary">Задать вопрос</h4>
            </div></a></div>
      </div>
    </section>
  </div>
</main>
