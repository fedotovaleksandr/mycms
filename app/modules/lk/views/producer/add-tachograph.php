<?php
$this->title = 'Добавить новую партию тахографов';
?>
<?=$this->render('menu');?>
<main class="page-main">
  <div class="breadcrumbs">
    <div class="container">
      <ul>
        <li><a href="/lk/producer/">Главная страница</a></li>
        <li class="active">Добавить новую партию тахографов</li>
      </ul>
    </div>
  </div>
  <div class="container">
    <section>
      <?=\yii\helpers\Html::beginForm('', 'POST', ['enctype' => 'multipart/form-data']);?>
      <div class="dropbox">
        <div class="dropbox__item t30">
          <h1>Добавить новую партию<br>тахографов</h1>
        </div>
        <div class="dropbox__item">
          <div class="dropbox__inner">
            <input type="file" class="input__file-js" name="export" required=""><img src="/web/lk/producer/images/dropbox-img.png" alt="">
            <p class="input__text-js"><span class="text--primary text__md">Выбрать файл</span><br><span class="text--default text__sm">или перетащите сюда файл, чтобы прикрепить его</span></p>
          </div>
        </div>
        <div class="dropbox__item t25"><button type="submit" class="btn btn--primary">далее</button></div>
      </div>
      <div class="dropbox__item">
        <?php
        foreach($messages as $message)
        {
          ?>
          <div><?=$message;?></div>
        <?php
        }
        ?>
      </div>
      <?=\yii\helpers\Html::endForm();?>
      <!--h4>Последние 7 отправок</h4>
      <table class="table table--striped table--center">
        <thead>
          <tr>
            <th>Дата и время</th>
            <th>Размер файла</th>
            <th>Подписан</th>
            <th>Статус</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><span>01.01.2016</span><span>00:36</span></td>
            <td>200 Мб</td>
            <td>Ковтун О.Н.</td>
            <td><span>Новый</span>
              <div data-per="28" class="slider-line slider-line--js">
                <div class="inner"></div>
              </div>
            </td>
          </tr>
          <tr>
            <td><span>01.01.2016</span><span>17:27</span></td>
            <td>770 Мб</td>
            <td>Ковтун О.Н.</td>
            <td><span>В обработке</span>
              <div data-per="70" class="slider-line slider-line--js">
                <div class="inner"></div>
              </div>
            </td>
          </tr>
          <tr>
            <td><span>01.01.2016</span><span>12:52</span></td>
            <td>43 Мб</td>
            <td>Петров Г.М.</td>
            <td><span>Обработан</span>
              <div data-per="100" class="slider-line slider-line--js">
                <div class="inner"></div>
              </div>
            </td>
          </tr>
          <tr>
            <td><span>01.01.2016</span><span>09:42</span></td>
            <td>200 Мб</td>
            <td>Петров Г.М.</td>
            <td><span>Новый</span>
              <div data-per="28" class="slider-line slider-line--js">
                <div class="inner"></div>
              </div>
            </td>
          </tr>
          <tr>
            <td><span>01.01.2016</span><span>19:18</span></td>
            <td>200 Мб</td>
            <td>Ковтун О.Н.</td>
            <td><span>Новый</span>
              <div data-per="28" class="slider-line slider-line--js">
                <div class="inner"></div>
              </div>
            </td>
          </tr>
          <tr>
            <td><span>01.01.2016</span><span>09:42</span></td>
            <td>770 Мб</td>
            <td>Петров Г.М.</td>
            <td><span>Новый</span>
              <div data-per="28" class="slider-line slider-line--js">
                <div class="inner"></div>
              </div>
            </td>
          </tr>
          <tr>
            <td><span>01.01.2016</span><span>12:52</span></td>
            <td>43 Мб</td>
            <td>Ковтун О.Н.</td>
            <td><span>Обработан</span>
              <div data-per="100" class="slider-line slider-line--js">
                <div class="inner"></div>
              </div>
            </td>
          </tr>
        </tbody>
      </table-->
    </section>
  </div>
</main>