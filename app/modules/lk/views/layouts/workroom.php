<?php
use yii\helpers\Html;
$this->registerJsFile('/web/scripts/lk/fa.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?><?php $this->beginPage() ?><!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
  <head>
    <meta charset="<?= Yii::$app->charset ?>">
    <title><?=Html::encode($this->title) ?></title><!--[if IE]>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Custom Jade/Scss/Gulp/Bower template">
    <meta name="keywords" content="jade, scss, gulp, npm, bower, template, html5, css3">
    <meta name="format-detection" content="telephone=no">
    <meta name="format-detection" content="address=no">
    <!-- iOS-->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="Case__fy">
    <link rel="apple-touch-icon" href="/web/lk/producer/images/touch/apple-touch-icon.png">
    <!-- Android-->
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="theme-color" content="#f8aa27">
    <link rel="icon" type="image/png" href="/web/lk/producer/images/touch/android-chrome-192x192.png" sizes="192x192">
    <!-- Windows-->
    <meta name="msapplication-TileImage" content="/web/lk/producer/images/touch/mstile-144x144.png">
    <meta name="msapplication-TileColor" content="#f8aa27">
    <!-- Standard-->
    <link rel="icon" type="image/png" href="/web/lk/producer/images/touch/favicon.png" sizes="128x128">
    <link rel="shortcut icon" href="/web/lk/producer/favicon.ico">
    <!-- Styles-->
    <link rel="stylesheet" href="/web/lk/producer/styles/plugins.css">
    <link rel="stylesheet" href="/web/lk/producer/styles/main.css">
    <link rel="stylesheet" href="/web/lk/producer/styles/fa.css">
    <?= Html::csrfMetaTags() ?>
    <?php $this->head() ?>
  </head>
<body class="page-index"><!--[if lt IE 9]>
    <p class="browsehappy">Данный сайт построен на передовых, современных технологиях и не поддерживает Ваш браузер. Настоятельно рекомендуем выбрать и установить любой из &nbsp;<a href="http://browsehappy.com/" target="_blank">современных браузеров.</a> Это бесплатно и займет всего несколько минут.</p><![endif]-->
    <?php $this->beginBody() ?>
      <?=$content;?>
  <footer class="page-footer">
      <div class="container">
        <div class="row">
          <div class="cell cell__xs-10">
            <p class="text__md">© Портал системы тахографического контроля. 2016 г.</p>
            <p class="text__xs">Все права на материалы, находящиеся на сайте,охраняются в соответствии с законодательством Российской Федерации</p>
          </div>
          <div class="cell cell__xs-2 text--right">
            <p class="text__md">Разработано<br>в &nbsp;<a href="http://www.alkodesign.ru/" target="_blank">AlkoDesign</a></p>
          </div>
        </div>
      </div>
    </footer><!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
    
    <?php $this->endBody() ?>
    <script src="/web/lk/producer/scripts/plugins.js"></script>
    <script src="/web/lk/producer/scripts/main.js"></script>
    <script src="/web/lk/producer/scripts/fa-producer.js"></script>
</body>
</html>
<?php $this->endPage() ?>