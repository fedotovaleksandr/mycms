<?php
use yii\helpers\Html;
$this->title = 'Информация о мастерской';
?>
<?=$this->render('menu');?>
<main class="page-main">
  <div class="container">
    <section>
      <h1>Вывод списка мастерских</h1>

      <?php

      foreach($workRoomList as $key => $workroom)
      {
          ?>
          <div class="cell cell__lg-4 cell__md-6 cell__xs-12 margbot40 wherebuy-element" style="cursor: pointer;">
              <ul class="list--inline margbot0">
                  <li>
                      <img src="/web/files/wherebuy/wherebuy-ico-1.png" alt="<?=$workroom;?>">
                  </li>
                  <li><b><?=$workroom?></b></li>
              </ul>
              <h4 class="text--primary">
                  <?= $workroom ? $workroom : $workroom; ?>
              </h4>
              <p class="text--grey">
                  <?= $workroom ? $workroom : $workroom; ?>
              </p>
          </div>
      <?php
      }
      ?>
      <?php
      foreach($infoEditFormList as $key => $workRoomList)
      {
        ?>
        <?=Html::beginForm('', 'POST', ['class' => 'workroom-edit-form']);?>
        <?=Html::activeHiddenInput($workRoomList, 'id');?>
        <?=Html::endForm();?>
      <?php
      }
      ?>
    </section>
  </div>
</main>
<script>
  $('form.workroom-edit-form').submit(function(e){
    ///отправка данных из формы
    e.prevetDefault();
    var form = $(this);
    $.ajax({
            dataType: "json",
            url: $(this).attr('action'),
            cache: false,
            method: 'POST',
            data: form.serialize(),
            success: function( data )
            {
                if(data.error == true)
                {
                  form.find('#form-errors').html(data.errorHtml);
                }
                if(data.error == false)
                {
                  //form.find('#doc-add-form-errors').html(data.html);
                  $('#modal-message-name').html('Результат');
                  $('#modal-message-body').html(data.html);
                  $('#modal-message').modal('show');
                }
            }
        });
    return false;
  })
</script>