<?php
use \app\modules\lk\models\producer;
?>
<?=$this->render('menu');?>
<main class="page-main">
  <div class="container">
    <section>
    <?php
    if(count($tachographModels))
    {
      ?>
      <h1>Тахографы</h1>
      <?php
      foreach($tachographModels as $model)
      {
        ?>
        <a href="/lk/producer/view-docs/?device-type=<?=producer\Docs::DEVICE_TACHOGRAPH?>&id-device=<?=$model->id?>"><?=$model->model?></a><br/>
      <?php
      }
    }
    ?>
    <?php
    if(count($skziModels))
    {
      ?>
      <h1>СКЗИ</h1>
      <?php
      foreach($skziModels as $model)
      {
        ?>
        <a href="/lk/producer/view-docs/?device-type=<?=producer\Docs::DEVICE_SKZI?>&id-device=<?=$model->id?>"><?=$model->model?></a><br/>
      <?php
      }
    }
    ?>
    <?php
    if(count($cardModels))
    {
      ?>
      <h1>Карты</h1>
      <?php
      foreach($cardModels as $model)
      {
        ?>
      <a href="/lk/producer/view-docs/?device-type=<?=producer\Docs::DEVICE_CARD?>&id-device=<?=$model->id?>"><?=$model->model?></a><br/>
      <?php
      }
    }
    ?>
    </section>
  </div>
</main>

