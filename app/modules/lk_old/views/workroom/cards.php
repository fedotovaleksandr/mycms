<?php
use yii\helpers\Html;
use app\modules\lk\components\ProducerHelper;
$this->title = 'Карты и сроки их действия';
$request = \Yii::$app->request;
?>
<?=$this->render('menu');?>
<?php
if($errorMsg)
{
  ?>
  <div><?=$errorMsg?></div>
  <?php
}
?>
  <main class="page-main">
    <div class="breadcrumbs">
      <div class="container">
        <ul>
          <li><a href="/lk/producer/">Главная страница</a></li>
          <li class="active">Карты и сроки их действия</li>
        </ul>
      </div>
    </div>
    <div class="container">
      <section>
        <div class="relative">
          <h1>Карты и сроки их действия</h1>

        <form class="catalog-tah form-block">
          <div class="catalog-tah__inner">
            <div class="catalog-tah__item t20">
              <fieldset>
                <input type="text" name="serialNumberFull" autocomplete="off" class="form-control <?=$request->get('serialNumberFull') ? 'edited' : ''?>" value="<?=$request->get('serialNumberFull')?>">
                <label>Номер</label>
              </fieldset>
            </div>
            <div class="catalog-tah__item t35">
              <fieldset>
                <input type="text" id="createDateInput" autocomplete="off" class="form-control edited date-range" from="createDateFrom" to="createDateTo">
                <label>Период окончания акивации</label>
                <input type="hidden" name="createDateFrom" value="<?=$request->get('createDateFrom')?>"/>
                <input type="hidden" name="createDateTo" value="<?=$request->get('createDateTo')?>"/>
              </fieldset>
            </div>
            <div class="catalog-tah__item t30">
              <fieldset>
                <input type="text" name="serialNumberFull" autocomplete="off" class="form-control <?=$request->get('serialNumberFull') ? 'edited' : ''?>" value="<?=$request->get('serialNumberFull')?>">
                <label>ФИО</label>
              </fieldset>
            </div>
            <div class="catalog-tah__item">
              <button type="submit" class="btn btn--primary btn__lg">найти</button>
            </div>
          </div>
        </form>
        </div>
      </section>
    </div>
    <div class="container">
      <section>
        <table class="table table--striped table-catalog">
          <thead>
          <tr>
            <th class="t5 text--center relative">
              <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icon-cog"></i></a>
              <div aria-labelledby="dLabel" class="dropdown-menu">
                <?=Html::beginForm('/lk/workroom/table/', 'POST');?>
                <?=Html::hiddenInput('table', 'cards');?>
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
            </th>
            <?php
            foreach($viewTableFields as $fieldKey=>$field)
            {
              ?>
              <th class="t20">
                <?php
                if($request->get('sort') != $fieldKey || ( $request->get('order') != SORT_ASC && $request->get('order') != SORT_DESC))
                {
                  ?>
                  <a href="<?=yii\helpers\Url::current(['sort'=>$fieldKey, 'order' => SORT_ASC]);?>"><i class="icon-sort"></i></a>
                  <?php
                }
                ?>
                <?php
                if($request->get('sort') == $fieldKey && $request->get('order') == SORT_ASC)
                {
                  ?>
                  <a href="<?=yii\helpers\Url::current(['sort'=>$fieldKey, 'order' => SORT_DESC]);?>"><i class="icon-sort-up"></i></a>
                  <?php
                }
                ?>
                <?php
                if($request->get('sort') == $fieldKey && $request->get('order') == SORT_DESC)
                {
                  ?>
                  <a href="<?=yii\helpers\Url::current(['sort'=>$fieldKey, 'order' => SORT_ASC]);?>"><i class="icon-sort-down"></i></a>
                  <?php
                }
                ?>
                <?=$field['label'];?></th>
              <?php
            }
            ?>

          </tr>
          </thead>

          <tfoot>
          <tr>
            <?php
            $allColCount = count($viewTableFields) + 2;
            ?>
            <td colspan="<?=$allColCount?>">
              <ul class="list--table">
                <li>
                  <div class="checkbox">
                    <input type="checkbox" id="all-checbox" onchange="$('input[device=skzi]').prop('checked', ($(this).prop('checked') ? true : false));$('input[device=skzi]').change();">
                    <label for="all-checbox">Все</label>
                  </div>
                </li>
                <li><b>Выбрано: <span id="checked-count">0</span></b></li>
                <li>
                  <?=Html::beginForm('', 'POST', ['id' => 'batch-actions', 'enctype' => 'multipart/form-data']);?>
                  <?=Html::hiddenInput('type', 'skzi');?>
                  <select style="width: 290px;" class="select-actions" id="group-action-dropdown">
                    <option></option>
                    <option value="disarchive">Разархивировать</option>
                    <option value="archive">Заархивировать</option>
                    <option value="add-to-stop">Добавить в стоп-лист</option>
                    <!--option value="del">Утилизировать</option-->
                  </select>
                  <button class="btn btn--primary btn-actions" style="margin-left: 20px;">Применить</button>
                  <?=Html::endForm();?>
                </li>
                <li class="select-transparent">
                  <div>
                    <?=yii\helpers\Html::beginForm('/lk/producer/count', 'POST', ['id' => 'form-set-per-page']);?>
                    <?=yii\helpers\Html::hiddenInput('table', 'skzi');?>
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


<?php /*
<div class="debug">
  <h2>Отладочная информация:</h2>
  <?php
  foreach($debagInfo as $key => $value)
  {
    if(is_string($value))
    {
      ?>
      <h3><?=$key;?></h3>
      <textarea style="width:100%;height:100px;"><?=$value;?></textarea>
      <?php
    }else{
    ?>
    <h3><?=$key;?></h3>
    <?=var_dump($value)?>
  <?php
    }
  }
  ?>
</div>
 *
 */
?>