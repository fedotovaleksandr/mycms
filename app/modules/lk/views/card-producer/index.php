<?php
$this->title = 'Личный кабинет';
?>
<?=$this->render('menu');?>
<main class="page-main">
  <div class="container">
    <section>
      <h1>Доступные действия</h1>
      <div class="row actions">
        <div class="cell cell__xs-4"><a href="/lk/card-producer/cards/" class="actions__item">
            <div class="actions__item--img"><img src="/web/lk/producer/images/actions-img-4.png" alt=""></div>
            <div class="actions__item--title">
              <h4 class="text--primary">Список выпущенных карт</h4>
            </div></a></div>
        <div class="cell cell__xs-4"><a href="/lk/card-producer/help/" class="actions__item">
            <div class="actions__item--img"><img src="/web/lk/producer/images/actions-img-5.png" alt=""></div>
            <div class="actions__item--title">
              <h4 class="text--primary">Помощь в использовании</h4>
            </div></a></div>
        <div class="cell cell__xs-4"><a href="/lk/card-producer/question/" class="actions__item">
            <div class="actions__item--img"><img src="/web/lk/producer/images/actions-img-6.png" alt=""></div>
            <div class="actions__item--title">
              <h4 class="text--primary">Задать вопрос</h4>
            </div></a></div>
      </div>
    </section>
  </div>
</main>