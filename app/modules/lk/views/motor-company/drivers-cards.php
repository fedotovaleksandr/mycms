<?php
use yii\helpers\Html;
$this->title = 'Карты водителей';

$this->registerJsFile('/web/scripts/lk/fa.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$request = \Yii::$app->request;
$allColCount = count($viewTableFields) + 2;
$t = (100 - 15 -25) / $allColCount;
$maxWidth = 1170 - 50 - 130;
$sum = 1;
foreach($viewTableFields as $fieldKey => $option)
{ 
  $sum += (int)$allFields[$fieldKey]['table-width'] + 20;
}
$koef = $maxWidth / $sum;
foreach($viewTableFields as $fieldKey => $option)
{
  $allFields[$fieldKey]['table-width'] = round((int)$allFields[$fieldKey]['table-width'] * $koef);
}
?>
<?=$this->render('menu');?>
<div id="modal-message" class="modal fade">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-body">
        <div class="padtop20 padbot20">
          <button type="button" data-dismiss="modal" aria-hidden="true" class="close"><img src="/web/lk/producer/images/close.png" alt=""></button>
          <div class="pull-left">
            <!--img src="/web/lk/producer/images/add-ico.png" alt="" class="margright10"-->
          </div>
          <h2 class="pull-left" id="modal-message-name"></h2>
          <div class="clearfix"></div>
          <div id="modal-message-body"></div>
          <div class="clearfix"></div>
        </div>
      </div>
    </div>
  </div>
</div>
<main class="page-main">
  <div class="breadcrumbs">
    <div class="container">
      <ul>
        <li><a href="/lk/motor-company/">Главная страница</a></li>
        <li class="active">Карты водителей</li>
      </ul>
    </div>
  </div>
  <div class="container">
    <section>
      <div class="relative">
        <h1>Карты водителей</h1>
        <div class="absolite-content top">
          <ul class="list--inline">
            <li></li>
          </ul>
        </div>
      </div>
      <form class="catalog-tah form-block">
        <div class="catalog-tah__inner">
          <div class="catalog-tah__item t20">
            <fieldset>
              <input type="text" name="cardNumber" autocomplete="off" class="form-control <?=$request->get('cardNumber') ? 'edited' : ''?>" value="<?=$request->get('cardNumber')?>">
              <label><?=$filters['cardNumber']['label']?></label>
            </fieldset>
          </div>
          <div class="catalog-tah__item t35">
            <fieldset>
              <input type="text" id="createDateInput" autocomplete="off" class="form-control edited date-range" from="cardBeginDateFrom" to="cardBeginDateTo">
              <label><?=$filters['cardBeginDate']['label']?></label>
              <input type="hidden" name="cardBeginDateFrom" value="<?=$request->get('cardBeginDateFrom')?>"/>
              <input type="hidden" name="cardBeginDateTo" value="<?=$request->get('cardBeginDateTo')?>"/>
            </fieldset>
          </div>
          <div class="catalog-tah__item t35">
            <fieldset>
              <input type="text" id="createDateInput" autocomplete="off" class="form-control edited date-range" from="cardEndDateFrom" to="cardEndDateTo">
              <label><?=$filters['cardEndDate']['label']?></label>
              <input type="hidden" name="cardEndDateFrom" value="<?=$request->get('cardEndDateFrom')?>"/>
              <input type="hidden" name="cardEndDateTo" value="<?=$request->get('cardEndDateTo')?>"/>
            </fieldset>
          </div>
          <div class="catalog-tah__item">
            <button type="submit" class="btn btn--primary btn__lg">найти</button>
          </div>
        </div>
      </form>
      
        <?php
        if(is_array($soonExpiresInfo) && $soonExpiresInfo['cardCount'])
        {
          ?>
            <div class="alert alert-warning">
              Срок действия <?=app\components\SiteHelper::generatePluralPhrase($soonExpiresInfo['cardCount'], ['one' => ' # карты', 'few' => ' # карт', 'many' => ' # карт', 'other' => ' # карты']);?> истекает до <?=$soonExpiresInfo['date']?>
            </div>
        <?php
        }
        ?>
    </section>
  </div>
  <div class="container-long">
    <section>
      <table class="table table--striped table-catalog">
        <thead>
          <tr>
            <th class="text--center relative">
              <div style="width:30px;">
                <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icon-cog"></i></a>
              
              <div aria-labelledby="dLabel" class="dropdown-menu">
                <?=Html::beginForm('/lk/motor-company/table/', 'POST');?>
                  <?=Html::hiddenInput('table', $table);?>
                  <?=Html::hiddenInput('return-url', yii\helpers\Url::current());?>
                <div class="pull-right"><img src="/web/lk/producer/images/icons/close.png" alt=""></div>
                <h4>Отображаемые столбцы</h4>
                <div class="form__group">
                  <?php
                    foreach ($allFields as $fieldId => $option)
                    {
                      $checked = $option['view_required'] || array_key_exists($fieldId, $userFileds);
                      $disable = $option['view_required'];
                    ?>
                    <div class="checkbox">
                      <?=Html::checkbox($fieldId, $checked, ['disable' => $disable, 'value' => 1, 'id' => $fieldId.'-stng']);?>
                      <?=Html::label($option['label'], $fieldId.'-stng', []);?>
                    </div>
                    <?php
                    }
                    ?>
                </div>
                <div class="form__group">
                  <button class="btn btn--primary" type="submit">Применить</button>
                </div>
                <?=Html::endForm();?>
              </div>
                </div>
            </th>
            <?php
            foreach($viewTableFields as $fieldKey=>$field)
            {
              ?>
              <th class="">
                <div style="width:<?=$allFields[$fieldKey]['table-width']?>px">
                  <?php
                    $sortName = isset($allFields[$fieldKey]['orderName']) ? $allFields[$fieldKey]['orderName'] : $fieldKey;
                    if($request->get('sort') != $sortName || ( $request->get('order') != SORT_ASC && $request->get('order') != SORT_DESC))
                    {
                      ?>
                      <a href="<?=yii\helpers\Url::current(['sort'=>$sortName, 'order' => SORT_ASC]);?>"><i class="icon-sort"></i></a>
                      <?php
                    }
                    ?>
                    <?php
                    if($request->get('sort') == $sortName && $request->get('order') == SORT_ASC)
                    {
                      ?>
                      <a href="<?=yii\helpers\Url::current(['sort'=>$sortName, 'order' => SORT_DESC]);?>"><i class="icon-sort-up"></i></a>
                      <?php
                    }
                    ?>
                    <?php
                    if($request->get('sort') == $sortName && $request->get('order') == SORT_DESC)
                    {
                      ?>
                      <a href="<?=yii\helpers\Url::current(['sort'=>$sortName, 'order' => SORT_ASC]);?>"><i class="icon-sort-down"></i></a>
                      <?php
                    }
                    ?>
                    <?=$field['label']?>
                </div>
              </th>
              <?php
            }
            ?>
            
          </tr>
        </thead>
        <tbody>
          <?php
            foreach($list as $key => $row)
            {
              ?>
              <tr>
                <td colspan="<?=$allColCount;?>" class="nopad">
                  <table class="table">
                    <tbody>
                      <tr>
                        <td class="text--center relative">
                          <div style="width:30px;">
                            
                          </div>
                        </td>
                        <?php
                        foreach($viewTableFields as $fieldKey => $field)
                        {?>
                            <td class="">
                              <div style="width:<?=$allFields[$fieldKey]['table-width']?>px">
                                    <?=$row[$fieldKey]?>
                              </div>
                            </td>
                        <?php
                        }
                        ?>
                      </tr>
                    </tbody>
                  </table>
                </td>
              </tr>
              <?php
            }
            ?>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="<?=$allColCount?>">
              <ul class="list--table">
                <li>
                    <div class="checkbox">
                      <input type="checkbox" id="all-checbox" onchange="$('input[device=tachograph]').prop('checked', ($(this).prop('checked') ? true : false));$('input[device=tachograph]').change();">
                      <label for="all-checbox">Все</label>
                    </div>
                </li>
                <li><b>Выбрано: <span id="checked-count">0</span></b></li>
                <li>
                  <?=Html::beginForm('', 'POST', ['id' => 'batch-actions', 'enctype' => 'multipart/form-data']);?>
                  <?=Html::hiddenInput('type', $table);?>
                  <select style="width: 290px;" class="select-actions" id="group-action-dropdown">
                    <option></option>
                    <option value="disarchive">Разархивировать</option>
                    <option value="archive">Заархивировать</option>
                    <option value="add-to-stop">Добавить в стоп-лист</option>
                  </select>
                  <button class="btn btn--primary btn-actions" style="margin-left: 20px;">Применить</button>
                  <?=Html::endForm();?>
                </li>
                <li class="select-transparent">
                  <div>
                  <?=yii\helpers\Html::beginForm('/lk/motor-company/count', 'POST', ['id' => 'form-set-per-page']);?> 
                    <?=yii\helpers\Html::hiddenInput('table', $table);?>
                    <select style="width: 180px;" name="count" onchange="$(this).parent('form').submit();">
                      <option value="5" <?=$pagination->pageSize == 5 ? 'selected' : ''?>>Выводить по  5</option>
                      <option value="10" <?=$pagination->pageSize == 10 ? 'selected' : ''?>>Выводить по  10</option>
                      <option value="15" <?=$pagination->pageSize == 15 ? 'selected' : ''?>>Выводить по  15</option>
                      <option value="20" <?=$pagination->pageSize == 20 ? 'selected' : ''?>>Выводить по  20</option>
                    </select>
                  <?=yii\helpers\Html::endForm();?>
                </li>
                <li><?=$pagination->page+1;?> из <?=$pagination->totalCount;?></li>
                <li>
                  <?=yii\widgets\LinkPager::widget([
                        'pagination' => $pagination,
                        'disabledPageCssClass' => '',
                        'maxButtonCount' => 5
                    ]);
                    ?>
                </li>
              </ul>
            </td>
          </tr>
        </tfoot>
      </table>
    </section>
  </div>
</main>
