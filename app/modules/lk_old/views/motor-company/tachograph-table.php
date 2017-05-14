<?php
use yii\helpers\Html;
use app\modules\lk\components\ProducerHelper;
$this->title = 'Список тахографов';
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
        <li class="active">Список тахографов</li>
      </ul>
    </div>
  </div>
  <div class="container">
    <section>
      <div class="relative">
        <h1>Список тахографов</h1>
        <div class="absolite-content top">
          <ul class="list--inline">
            <li><img src="/web/lk/producer/images/tah-ico-3.png" alt=""><a href="#modal-add-car" data-toggle="modal"><b class="text--primary">Добавить автомобиль</b></a></li>
          </ul>
        </div>
      </div>
      <form class="catalog-tah form-block">
        <div class="catalog-tah__inner">
          <div class="catalog-tah__item t20">
            <fieldset>
              <input type="text" name="tachoSerialNumber" autocomplete="off" class="form-control <?=$request->get('tachoSerialNumber') ? 'edited' : ''?>" value="<?=$request->get('tachoSerialNumber')?>">
              <label><?=$filters['tachoSerialNumber']['label']?></label>
            </fieldset>
          </div>
          <div class="catalog-tah__item t35">
            <fieldset>
              <input type="text" id="createDateInput" autocomplete="off" class="form-control edited date-range" from="tachoCreateDateFrom" to="tachoCreateDateTo">
              <label><?=$filters['tachoCreateDate']['label']?></label>
              <input type="hidden" name="tachoCreateDateFrom" value="<?=$request->get('tachoCreateDateFrom')?>"/>
              <input type="hidden" name="tachoCreateDateTo" value="<?=$request->get('tachoCreateDateTo')?>"/>
            </fieldset>
          </div>
          <div class="catalog-tah__item t25">
              <?=Html::dropDownList('tachoEquipTypeId', $request->get('tachoEquipTypeId'), $filters['tachoEquipTypeId']['values'], ['style' => 'width: 285px;', 'class' => 'edited']);?>
          </div>
          <div class="catalog-tah__item">
            <button type="submit" class="btn btn--primary btn__lg">найти</button>
          </div>
          <div class="catalog-tah__item"><a href="#" class="search-adv search-adv--js">Расширенный поиск</a></div>
        </div>
        <div class="catalog-tah__hide" style="<?=($request->get('tachoVerifDateFrom')
                      ||$request->get('tachoVerifDateTo')
                      ||$request->get('tachoSoftwareVersion')
                      ||$request->get('tachoVerifExpiresFrom')
                      ||$request->get('tachoVerifExpiresFrom')
                      ||$request->get('tachoVerifExpiresFrom')
                      ||$request->get('tachoVerifExpiresFrom')
                      ||$request->get('tachoVerifExpiresFrom')
                      ||$request->get('tachoVerifExpiresTo')) ? 'display:block;' : ''?>">
          <div class="catalog-tah__inner"></div>
          <div class="catalog-tah__inner">
            <div class="catalog-tah__item t25">
              <fieldset>
                <input type="text" name="tachoSoftwareVersion" autocomplete="off" value="<?=$request->get('tachoSoftwareVersion')?>" required class="form-control edited">
                <label><?=$filters['tachoSoftwareVersion']['label']?></label>
              </fieldset>
            </div>
            <div class="catalog-tah__item t25">
              <fieldset>
                <input type="text" id="verifDate" autocomplete="off" class="form-control date-range edited" from="tachoVerifDateFrom" to="tachoVerifDateTo">
                <label><?=$filters['tachoVerifDate']['label']?></label>
                <input type="hidden" name="tachoVerifDateFrom" value="<?=$request->get('tachoVerifDateFrom')?>"/>
                <input type="hidden" name="tachoVerifDateTo" value="<?=$request->get('tachoVerifDateTo')?>"/>
              </fieldset>
            </div>
            <div class="catalog-tah__item t25">
              <fieldset>
                <input type="text" id="verifExpires" autocomplete="off" class="form-control date-range edited" from="tachoVerifExpiresFrom" to="tachoVerifExpiresTo">
                <label><?=$filters['tachoVerifExpires']['label']?></label>
                <input type="hidden" name="tachoVerifExpiresFrom" value="<?=$request->get('tachoVerifExpiresFrom')?>"/>
                <input type="hidden" name="tachoVerifExpiresTo" value="<?=$request->get('tachoVerifExpiresTo')?>"/>
              </fieldset>
            </div>
          </div>
          <div class="catalog-tah__inner">
            <div class="catalog-tah__item t25">
              <fieldset>
                <input type="text" name="vrn" autocomplete="off" value="<?=$request->get('vrn')?>" required class="form-control edited">
                <label><?=$filters['vrn']['label']?></label>
              </fieldset>
            </div>
            <div class="catalog-tah__item t25">
              <fieldset>
                <input type="text" name="carModel" autocomplete="off" value="<?=$request->get('carModel')?>" required class="form-control edited">
                <label><?=$filters['carModel']['label']?></label>
              </fieldset>
            </div>
          </div>
          <div class="catalog-tah__inner">
            <div class="catalog-tah__item t25">
              <fieldset>
                <input type="text" name="vrn" autocomplete="off" value="<?=$request->get('skziSerialNumber')?>" required class="form-control edited">
                <label><?=$filters['skziSerialNumber']['label']?></label>
              </fieldset>
            </div>
            <div class="catalog-tah__item t35">
              <fieldset>
                <input type="text" id="createDateInput" autocomplete="off" class="form-control edited date-range" from="skziCreateDateFrom" to="skziCreateDateTo">
                <label><?=$filters['skziCreateDate']['label']?></label>
                <input type="hidden" name="skziCreateDateFrom" value="<?=$request->get('skziCreateDateFrom')?>"/>
                <input type="hidden" name="skziCreateDateTo" value="<?=$request->get('skziCreateDateTo')?>"/>
              </fieldset>
            </div>
            <div class="catalog-tah__item t25">
                <?=Html::dropDownList('skziEquipTypeId', $request->get('skziEquipTypeId'), $filters['skziEquipTypeId']['values'], ['style' => 'width: 285px;', 'class' => 'edited']);?>
            </div>
          </div>
          <div class="catalog-tah__inner">
            <div class="catalog-tah__item t25">
              <fieldset>
                <input type="text" name="skziSoftwareVersion" autocomplete="off" value="<?=$request->get('skziSoftwareVersion')?>" required class="form-control edited">
                <label><?=$filters['skziSoftwareVersion']['label']?></label>
              </fieldset>
            </div>
            <div class="catalog-tah__item t25">
              <fieldset>
                <input type="text" id="verifDate" autocomplete="off" class="form-control date-range edited" from="skziVerifDateFrom" to="skziVerifDateTo">
                <label><?=$filters['skziVerifDate']['label']?></label>
                <input type="hidden" name="skziVerifDateFrom" value="<?=$request->get('skziVerifDateFrom')?>"/>
                <input type="hidden" name="skziVerifDateTo" value="<?=$request->get('skziVerifDateTo')?>"/>
              </fieldset>
            </div>
            <div class="catalog-tah__item t25">
              <fieldset>
                <input type="text" id="verifExpires" autocomplete="off" class="form-control date-range edited" from="skziVerifExpiresFrom" to="skziVerifExpiresTo">
                <label><?=$filters['skziVerifExpires']['label']?></label>
                <input type="hidden" name="skziVerifExpiresFrom" value="<?=$request->get('skziVerifExpiresFrom')?>"/>
                <input type="hidden" name="skziVerifExpiresTo" value="<?=$request->get('skziVerifExpiresTo')?>"/>
              </fieldset>
            </div>
          </div>
        </div>
      </form>
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
            <th class="">
              <div style="width:<?=$allFields['equipTypeModel']['table-width']?>px">
                <?php
                if($request->get('sort') != 'equipTypeModel' || ( $request->get('order') != SORT_ASC && $request->get('order') != SORT_DESC))
                {
                  ?>
                  <a href="<?=yii\helpers\Url::current(['sort'=>'equipTypeModel', 'order' => SORT_ASC]);?>"><i class="icon-sort"></i></a>
                  <?php
                }
                ?>
                <?php
                if($request->get('sort') == 'equipTypeModel' && $request->get('order') == SORT_ASC)
                {
                  ?>
                  <a href="<?=yii\helpers\Url::current(['sort'=>'equipTypeModel', 'order' => SORT_DESC]);?>"><i class="icon-sort-up"></i></a>
                  <?php
                }
                ?>
                <?php
                if($request->get('sort') == 'equipTypeModel' && $request->get('order') == SORT_DESC)
                {
                  ?>
                  <a href="<?=yii\helpers\Url::current(['sort'=>'equipTypeModel', 'order' => SORT_ASC]);?>"><i class="icon-sort-down"></i></a>
                  <?php
                }
                ?>
                Модель
              </div>
            </th>
            <?php
            foreach($viewTableFields as $fieldKey=>$field)
            {
              if($fieldKey == 'equipTypeModel')
              {
                continue;
              }
              ?>
              <th class="">
                <div style="width:<?=$allFields[$fieldKey]['table-width']?>px">
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
                    <?=$field['label']?>
                </div>
              </th>
              <?php
            }
            ?>
            <th class=""><div style="width:110px;">Действие</div></th>
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
                            <div class="checkbox">
                              <input type="checkbox" device="tachograph" name="id[<?=$objects[$key]->id?>]" id="tachograph-<?=$objects[$key]->id?>" value="<?=$objects[$key]->id?>" />
                              <label for="tachograph-<?=$objects[$key]->id?>"></label>
                            </div>
                          </div>
                        </td>
                        <td class="acc-title acc-title--js">
                          <div style="width:<?=$allFields['equipTypeModel']['table-width']?>px">
                            <?php
                            if(isset($objects[$key]->skziId) && isset($skziList[$objects[$key]->skziId]))
                            { 
                              ?>
                              <i></i>
                            <?php
                            }
                            ?>
                            <span class="text--primary"><?=$row['equipTypeModel']?></span>
                          </div>
                        </td>
                        <?php
                        foreach($viewTableFields as $fieldKey => $field)
                        {
                            if($fieldKey == 'equipTypeModel')
                            {
                              continue;
                            }
                            ?>
                            <td class="">
                              <div style="width:<?=$allFields[$fieldKey]['table-width']?>px">
                                    <?=$row[$fieldKey]?>
                              </div>
                            </td>
                        <?php
                        }
                        ?>
                        <td class="" style="">
                          <div style="width:110px;">
                            <ul class="list--inline">
                              <li>
                                <a href="#modal-tachograph-view-<?=$objects[$key]->id?>" data-toggle="modal" title="Подробнее">Подробнее</a></li>
                            </ul>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                    <tbody style="display:none">
                      <?php
                      if(isset($objects[$key]->skziId) && isset($skziList[$objects[$key]->skziId]))
                      { 
                        $skzi = $skziList[$objects[$key]->skziId];
                        $skziRow = \app\modules\lk\components\ProducerHelper::processOneObjectBeforeView('tachograph-atp', $skzi);
                        ?>
                      <tr>
                        <td><div style="width:30px;">&nbsp;</div></td>
                        <td class="text--right">
                          <div style="width:<?=$allFields['equipTypeModel']['table-width']?>px" class="text--right">
                          <?=$skzi->equipTypeModel;?></div>
                        </td>
                        <?php
                        foreach($viewTableFields as $fieldKeySkzi => $fieldSkzi)
                        {
                          if($fieldKeySkzi == 'equipTypeModel')
                          {
                            continue;
                          }
                          if(isset($skziRow[$fieldKeySkzi]))
                          {
                          ?>
                            <td>
                              <div style="width:<?=$allFields[$fieldKeySkzi]['table-width']?>px">
                                  <?=$skziRow[$fieldKeySkzi]?>
                              </div>
                            </td>
                          <?php
                          }else{
                            ?>
                            <td>
                              <div style="width:<?=$allFields[$fieldKeySkzi]['table-width']?>px">
                                &nbsp;
                              </div>
                              </td>
                            <?php
                          }
                        }
                        ?>
                        <td><div style="width:110px;">&nbsp;<div></td>
                      </tr>
                      <?php
                      }
                      ?>
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
<script>
var tachographSoftVersionList = <?=json_encode(app\modules\lk\models\TachographModels::getSoftVersionList())?>
</script>
<div id="modal-add-car" class="modal fade">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" data-dismiss="modal" aria-hidden="true" class="close"><img src="/web/lk/producer/images/close.png" alt=""></button>
        <h2>Добавить автомобиль</h2>
      </div>
      <div class="modal-body">
        <?=Html::beginForm('/lk/motor-company/add-car/', 'POST', ['enctype' => 'multipart/form-data', 'class' => "form-block margtop0", 'id' => 'add-car-form'])?>
            <div class="row">
            <div class="cell cell__xs-12">
              <div class="form__group">
                <fieldset>
                  <?=Html::activeInput('text', $model, 'vrn', ['class' => 'form-control edited', 'required' => TRUE]);?>
                  <label>ГРЗ</label><span class="require">*</span>
                </fieldset>
              </div>
              <div class="form__group">
                <fieldset>
                  <?=Html::activeInput('text', $model, 'vin', ['class' => 'form-control edited', 'required' => TRUE]);?>
                  <label>VIN</label><span class="require">*</span>
                </fieldset>
              </div>
              <div class="form__group">
                <fieldset>
                  <?=Html::activeInput('text', $model, 'tachoSerialNumber', ['class' => 'form-control edited', 'required' => TRUE]);?>
                  <label>Серийный номер тахографа</label><span class="require">*</span>
                </fieldset>
              </div>
              <div class="form__group">
                <fieldset>
                  <?=Html::activeInput('text', $model, 'skziSerialNumber', ['class' => 'form-control edited', 'required' => TRUE]);?>
                  <label>Серийный номер СКЗИ</label><span class="require">*</span>
                </fieldset>
              </div>
              <div class="form__group" id="add-car-form-errors"></div>
            </div>
          </div>
          <div class="this-or-this margtop20">
            <div class="this-or-this__this"><span class="require">*</span> Поля, обязательные для заполнения</div>
            <div class="this-or-this__this text--right">
              <ul class="list--inline">
                <li>
                  <button type="submit" class="btn btn--primary btn__lg">сохранить</button>
                </li>
                <li>
                  <button type="reset" class="btn btn--transparent btn__lg">отменить</button>
                </li>
              </ul>
            </div>
          </div>
        <?=Html::endForm();?>
      </div>
    </div>
  </div>
</div>
<?php
foreach($list as $key => $row)
{
  ?>
  <div id="modal-tachograph-view-<?=$objects[$key]->id?>" class="modal fade">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <?php
          foreach ($allFields as $fieldId => $option)
          {
            ?>
          <div class="tachograph-view-item">
            <div class="t50 tachograph-view-item-col"><?=$option['label']?></div>
            <div class="t50 tachograph-view-item-col"><?=$row[$fieldId]?></div>
          </div>
            <?php
          }
          ?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn--primary btn__lg" data-dismiss="modal">закрыть</button>
        </div>
      </div>
    </div>
  </div>
<?php
}
?>
<style>
  .tachograph-view-item-col{
    float: left;
  }
  .tachograph-view-item{
    overflow: auto;
  }
</style>
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
<?php */ ?>