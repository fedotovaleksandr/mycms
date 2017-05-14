<?php
$this->title = 'Личный кабинет';
?>
<?=$this->render('menu');?>
<main class="page-main">
  <div class="container">
    <section>
      <h1>Доступные действия</h1>
      <div class="row actions">
        <div class="cell cell__xs-4"><a href="/lk/producer/tachograph/" class="actions__item">
            <div class="actions__item--img"><img src="/web/lk/producer/images/actions-img-1.png" alt=""></div>
            <div class="actions__item--title">
              <h4 class="text--primary">Список тахографов</h4>
            </div></a></div>
        <div class="cell cell__xs-4"><a href="/lk/producer/skzi/" class="actions__item">
            <div class="actions__item--img"><img src="/web/lk/producer/images/actions-img-2.png" alt=""></div>
            <div class="actions__item--title">
              <h4 class="text--primary">Список СКЗИ</h4>
            </div></a></div>
        <div class="cell cell__xs-4"><a href="/lk/producer/add-batch-tachograph/" class="actions__item">
            <div class="actions__item--img"><img src="/web/lk/producer/images/actions-img-3.png" alt=""></div>
            <div class="actions__item--title">
              <h4 class="text--primary">Добавление партии тахографов</h4>
            </div></a></div>
        <div class="cell cell__xs-4"><a href="/lk/producer/docs/" class="actions__item">
            <div class="actions__item--img"><img src="/web/lk/producer/images/actions-img-4.png" alt=""></div>
            <div class="actions__item--title">
              <h4 class="text--primary">Модели оборудования</h4>
            </div></a></div>
        <div class="cell cell__xs-4"><a href="/lk/producer/help/" class="actions__item">
            <div class="actions__item--img"><img src="/web/lk/producer/images/actions-img-5.png" alt=""></div>
            <div class="actions__item--title">
              <h4 class="text--primary">Помощь в использовании</h4>
            </div></a></div>
        <div class="cell cell__xs-4"><a href="/lk/producer/question/" class="actions__item">
            <div class="actions__item--img"><img src="/web/lk/producer/images/actions-img-6.png" alt=""></div>
            <div class="actions__item--title">
              <h4 class="text--primary">Задать вопрос</h4>
            </div></a></div>
        <div class="cell cell__xs-4"><a href="/lk/producer/add-batch-skzi/" class="actions__item">
            <div class="actions__item--img"><img src="/web/lk/producer/images/actions-img-7.png" alt=""></div>
            <div class="actions__item--title">
              <h4 class="text--primary">Добавление партии СКЗИ</h4>
            </div></a></div>
      </div>
    </section>
  </div>
</main>
