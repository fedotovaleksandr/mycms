<?php
use yii\helpers\Html;
$this->title = $page->name.' - Помощь в использовании';
?>
<?=$this->render('menu');?>
<main class="page-main">
  <div class="container">
    <section>
      <h1><?=$page->name;?></h1>
      <?=$page->desc;?>
    </section>
  </div>
</main>