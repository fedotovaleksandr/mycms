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
        <li><a href="/lk/producer/">Главная страница</a></li>
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
            <li><img src="/web/lk/producer/images/tah-ico-3.png" alt=""><a href="#modal-tachograph" data-toggle="modal"><b class="text--primary">Добавить тахограф</b></a></li>
            <li><img src="/web/lk/producer/images/tah-ico-4.png" alt=""><a href="/lk/producer/add-batch-tachograph/"><b class="text--primary">Добавить новую партию тахографов</b></a></li>
          </ul>
        </div>
      </div>
      <form class="catalog-tah form-block">
        <div class="catalog-tah__inner">
          <div class="catalog-tah__item t20">
            <fieldset>
              <input type="text" name="serialNumber" autocomplete="off" class="form-control <?=$request->get('serialNumber') ? 'edited' : ''?>" value="<?=$request->get('serialNumber')?>">
              <label>Номер тахографа</label>
            </fieldset>
          </div>
          <div class="catalog-tah__item t35">
            <fieldset>
              <input type="text" id="createDateInput" autocomplete="off" class="form-control edited date-range" from="createDateFrom" to="createDateTo">
              <label>Дата изготовления</label>
              <input type="hidden" name="createDateFrom" value="<?=$request->get('createDateFrom')?>"/>
              <input type="hidden" name="createDateTo" value="<?=$request->get('createDateTo')?>"/>
            </fieldset>
          </div>
          <div class="catalog-tah__item t25">
              <?=Html::dropDownList('equipTypeId', $request->get('equipTypeId'), $filters['equipTypeId']['values'], ['style' => 'width: 285px;', 'class' => 'edited']);?>
          </div>
          <div class="catalog-tah__item">
            <button type="submit" class="btn btn--primary btn__lg">найти</button>
          </div>
          <div class="catalog-tah__item"><a href="#" class="search-adv search-adv--js">Расширенный поиск</a></div>
        </div>
        <div class="catalog-tah__hide" style="<?=($request->get('verifDateFrom')||$request->get('verifDateTo')||$request->get('verifExpiresFrom')||$request->get('verifExpiresTo')) ? 'display:block;' : ''?>">
          <div class="catalog-tah__inner"></div>
          <div class="catalog-tah__inner">
            
            <!--div class="catalog-tah__item t25">
              <fieldset>
                <input type="text" name="num5" autocomplete="off" value="Дополнительная плата: V112" required class="form-control edited">
                <label>Номер версии ПО</label>
              </fieldset>
            </div-->
            <div class="catalog-tah__item t25">
              <fieldset>
                <input type="text" id="verifDate" autocomplete="off" class="form-control date-range edited" from="verifDateFrom" to="verifDateTo">
                <label>Дата проверки</label>
                <input type="hidden" name="verifDateFrom" value="<?=$request->get('verifDateFrom')?>"/>
                <input type="hidden" name="verifDateTo" value="<?=$request->get('verifDateTo')?>"/>
              </fieldset>
            </div>
            <div class="catalog-tah__item t25">
              <fieldset>
                <input type="text" id="verifExpires" autocomplete="off" class="form-control date-range edited" from="verifExpiresFrom" to="verifExpiresTo">
                <label>Срок действия проверки</label>
                <input type="hidden" name="verifExpiresFrom" value="<?=$request->get('verifExpiresFrom')?>"/>
                <input type="hidden" name="verifExpiresTo" value="<?=$request->get('verifExpiresTo')?>"/>
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
                <?=Html::beginForm('/lk/producer/table/', 'POST');?>
                  <?=Html::hiddenInput('table', 'tachograph');?>
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
                              <?php
                              if(ProducerHelper::checkTachographAction('edit', $objects[$key]))
                              {
                                ?>
                                <a href="#modal-tachograph-edit-<?=$objects[$key]->id?>" data-toggle="modal" title="редактировать"><img src="/web/lk/producer/images/icons/icoTable-3.png" alt=""></a></li>
                              <?php
                              }
                              ?>
                              <?php
                              if(ProducerHelper::checkTachographAction('archive', $objects[$key]))
                              {
                                ?>
                                <li><a href="/lk/producer/archive/?id=<?=$objects[$key]->id?>" title="архивировать" action="archive" device-type="tachograph" csrfparam ="<?=\Yii::$app->request->csrfParam?>" csrftoken="<?=\Yii::$app->request->getCsrfToken()?>"><img src="/web/lk/producer/images/icons/carh.png" alt=""></a>
                              <?php
                              }
                              ?>
                              <?php
                              if(ProducerHelper::checkTachographAction('unarchive', $objects[$key]))
                              {
                                ?>
                                <li><a href="/lk/producer/unarchive/?id=<?=$objects[$key]->id?>" title="разархивировать" action="unarchive" device-type="tachograph" csrfparam ="<?=\Yii::$app->request->csrfParam?>" csrftoken="<?=\Yii::$app->request->getCsrfToken()?>"><img src="/web/lk/producer/images/icons/icoTable-6.png" alt=""></a>
                              <?php
                              }
                              ?>
                              <?php
                              if(ProducerHelper::checkTachographAction('stop', $objects[$key]))
                              {
                                ?>
                                <li><a href="/lk/producer/stop/?id=<?=$objects[$key]->id?>" title="добавить в стоп-лист" action="stop" device-type="tachograph" csrfparam ="<?=\Yii::$app->request->csrfParam?>" csrftoken="<?=\Yii::$app->request->getCsrfToken()?>"><img src="/web/lk/producer/images/icons/icoTable-5.png" alt=""></a>
                              <?php
                              }
                              ?>
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
                        $skziRow = \app\modules\lk\components\ProducerHelper::processOneObjectBeforeView('tachograph', $skzi);
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
                  <?=Html::hiddenInput('type', 'tachograph');?>
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
                    <?=yii\helpers\Html::hiddenInput('table', 'tachograph');?>
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
<div id="modal-tachograph" class="modal fade">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" data-dismiss="modal" aria-hidden="true" class="close"><img src="/web/lk/producer/images/close.png" alt=""></button>
        <h2>Добавление</h2>
      </div>
      <div class="modal-body">
        <?=Html::beginForm('/lk/producer/add-tachograph/', 'POST', ['enctype' => 'multipart/form-data', 'class' => "form-block margtop0", 'id' => 'tachograph-form'])?>
            <div class="row">
            <div class="cell cell__xs-6">
              <h4>Тахограф</h4>
              <div class="form__group">
                <fieldset>
                  <?=Html::activeInput('text', $model, 'serialNumberTacho', ['class' => 'form-control edited', 'required' => TRUE]);?>
                  <label>Серийный номер тахографа</label><span class="require">*</span>
                </fieldset>
              </div>
              <div class="form__group">
                <fieldset>
                  <?=Html::activeDropDownList($model, 'equipTypeIdTacho', app\modules\lk\models\TachographModels::getDataForDropDownList(TRUE), ['required' => TRUE, 'class' => 'select-hard', 'style' => 'width:100%', 'id' => 'tachograph-add-form-select-id-model']);?>
                  <label>Модель</label><span class="require">*</span>
                </fieldset>
              </div>
              <div class="form__group">
                <fieldset>
                  <input type="text" autocomplete="off"  required class="form-control edited date" to="createDate-hidden" id="createDate">
                  <label>Дата изготовления</label><span class="require">*</span>
                  <?=Html::activeInput('hidden', $model, 'createDateTacho', ['id' => 'createDate-hidden'])?>
                </fieldset>
              </div>
              <div class="form__group">
                <fieldset>
                  <input type="text" autocomplete="off"  required class="form-control edited date" to="verifDate-hidden" id="verifDate">
                  <label>Дата проверки</label><span class="require">*</span>
                  <?=Html::activeInput('hidden', $model, 'verifDateTacho', ['id' => 'verifDate-hidden'])?>
                </fieldset>
              </div>
              <div class="form__group">
                <fieldset>
                  <input type="text" autocomplete="off"  required class="form-control edited date" to="verifExpires-hidden" id="verifExpires">
                  <label>Срок действия проверки</label><span class="require">*</span>
                  <?=Html::activeInput('hidden', $model, 'verifExpiresTacho', ['id' => 'verifExpires-hidden'])?>
                </fieldset>
              </div>
              <div class="form__group" id="tachograph-form-errors"></div>
            </div>
            <div class="cell cell__xs-6">
              <h4>Блок СКЗИ</h4>
              <div class="form__group">
                <fieldset>
                  <?=Html::activeInput('text', $model, 'serialNumberFullSkzi', ['class' => 'form-control edited', 'autocomplete' => '', 'required' => TRUE])?>
                  <label>Серийный номер СКЗИ</label>
                  <!--ul id="search-helpel-list" class="search-helpel-list">
                  </ul-->
                  <div class="serialNumber-error"></div>
                </fieldset>
              </div>
              <div class="form__group">
                <fieldset>
                <?=Html::activeDropDownList($model, 'equipTypeIdSkzi', app\modules\lk\models\SkziModels::getDataForDropDownList(TRUE), ['required' => TRUE, 'class' => 'select-hard', 'style' => 'width:100%', 'id' => 'tachograph-add-form-select-id-model']);?>
                <label>Модель</label><span class="require">*</span>
                </fieldset>
              </div>
              <!--div class="form__group" style="display: none;">
                <p><b>Номер версии ПО</b></p>
                <p field="equipTypeSoftVersion" class="skzi-info-field"></p>
              </div-->
              <div class="form__group">
                <fieldset>
                  <input type="text" autocomplete="off"  required class="form-control edited date" to="createDateSkzi-hidden" id="createDateSkzi">
                  <label>Дата изготовления</label><span class="require">*</span>
                   <?=Html::activeInput('hidden', $model, 'createDateSkzi', ['id' => 'createDateSkzi-hidden'])?>
                </fieldset>
              </div>
              <div class="form__group">
                <fieldset>
                  <input type="text" autocomplete="off"  required class="form-control edited date" to="verifDateSkzi-hidden" id="verifDateSkzi">
                  <label>Дата проверки</label><span class="require">*</span>
                  <?=Html::activeInput('hidden', $model, 'verifDateSkzi', ['id' => 'verifDateSkzi-hidden'])?>
                </fieldset>
              </div>
              <div class="form__group">
                <fieldset>
                  <input type="text" autocomplete="off"  required class="form-control edited date" to="verifExpiresSkzi-hidden" id="verifExpiresSkzi">
                  <label>Срок действия проверки</label><span class="require">*</span>
                  <?=Html::activeInput('hidden', $model, 'verifExpiresSkzi', ['id' => 'verifExpiresSkzi-hidden'])?>
                </fieldset>
              </div>
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
foreach($objects as $object)
{
  if(ProducerHelper::checkTachographAction('edit', $object) === FALSE)
  {
    continue;
  }
  $tachoEditModel = new \app\modules\lk\models\producer\TachographForm();
  $tachoEditModel->loadFromObject($object);
?>
<div id="modal-tachograph-edit-<?=$object->id?>" class="modal fade">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" data-dismiss="modal" aria-hidden="true" class="close"><img src="/web/lk/producer/images/close.png" alt=""></button>
        <h2>Редактирование тахографа</h2>
      </div>
      <div class="modal-body">
        <?=Html::beginForm('/lk/producer/update-tachograph/', 'POST', [
            'enctype' => 'multipart/form-data', 
            'class' => "form-block margtop0 tachograph-form-edit", 
            'id' => 'tachograph-form-edit-'.$object->id,
            ])?>
          <?=Html::hiddenInput('id', $object->id);?>
          <?=Html::activeInput('hidden', $tachoEditModel, 'id', [])?>
          <div class="row">
            <div class="cell cell__xs-6">
              <h4>Тахограф</h4>
              <div class="form__group">
                <fieldset>
                  <?=Html::activeInput('text', $tachoEditModel, 'serialNumber', ['class' => 'form-control edited', 'required' => TRUE]);?>
                  <label>Серийный номер тахографа</label><span class="require">*</span>
                </fieldset>
              </div>
              <div class="form__group">
                <fieldset>
                  <?=Html::activeDropDownList($tachoEditModel, 'equipTypeId', app\modules\lk\models\TachographModels::getDataForDropDownList(TRUE), ['required' => TRUE, 'class' => 'select-hard edited', 'style' => 'width:100%', 'id' => 'tachograph-add-form-select-id-model']);?>
                  <label>Модель</label><span class="require">*</span>
                </fieldset>
              </div>
              <div class="form__group">
                <fieldset>
                  <input type="text" autocomplete="off"  required class="form-control edited date" to="createDate-hidden-<?=$object->id?>" id="createDate-<?=$object->id?>">
                  <label>Дата изготовления</label><span class="require">*</span>
                  <?=Html::activeInput('hidden', $tachoEditModel, 'createDate', ['id' => 'createDate-hidden-'.$object->id])?>
                </fieldset>
              </div>
              <div class="form__group">
                <fieldset>
                  <input type="text" autocomplete="off"  required class="form-control edited date" to="verifDate-hidden-<?=$object->id?>" id="verifDate-<?=$object->id?>">
                  <label>Дата проверки</label><span class="require">*</span>
                  <?=Html::activeInput('hidden', $tachoEditModel, 'verifDate', ['id' => 'verifDate-hidden-'.$object->id])?>
                </fieldset>
              </div>
              <div class="form__group">
                <fieldset>
                  <input type="text" autocomplete="off"  required class="form-control edited date" to="expireDverifExpiresate-hidden-<?=$object->id?>" id="expireDate-<?=$object->id?>">
                  <label>Срок действия проверки</label><span class="require">*</span>
                  <?=Html::activeInput('hidden', $tachoEditModel, 'verifExpires', ['id' => 'expireDverifExpiresate-hidden-'.$object->id])?>
                </fieldset>
              </div>
              <div class="form__group" id="tachograph-form-errors"></div>
            </div>
            <div class="cell cell__xs-6">
              <h4>Блок СКЗИ</h4>
              <?php
              if(isset($object->skziId) && isset($skziList[$object->skziId]))
              {
                $skzi = $skziList[$object->skziId];
              }
              else
              {
                $skzi = NULL;
              }
              ?>
              <div class="form__group">
                <fieldset>
                  <p field="serialNumber" class="skzi-info-field"><?=((isset($skzi)) ? $skzi->serialNumber : '')?></p>
                  <ul id="search-helpel-list" class="search-helpel-list">
                  </ul>
                  <div class="serialNumber-error"></div>
                </fieldset>
              </div>
              <div class="form__group" style="<?php if(!isset($skzi)) { ?>display: none;<?php }?>">
                <p><b>Модель</b></p>
                <p field="equipTypeModel" class="skzi-info-field"><?=((isset($skzi) && isset($skzi->equipTypeModel)) ? $skzi->equipTypeModel : '')?></p>
              </div>
              <!--div class="form__group" style="<?php if(!isset($skzi)) { ?>display: none;<?php }?>">
                <p><b>Номер версии ПО</b></p>
                <p field="equipTypeSoftVersion" class="skzi-info-field"><?=((isset($skzi) && isset($skzi->equipTypeSoftVersion)) ? $skzi->equipTypeSoftVersion : '')?></p>
              </div-->
              <div class="form__group" style="<?php if(!isset($skzi)) { ?>display: none;<?php }?>">
                <p><b>Дата изготовления</b></p>
                <p field="createDate" class="skzi-info-field"><?=((isset($skzi) && isset($skzi->createDate)) ? $skzi->createDate : '')?></p>
              </div>
              <div class="form__group" style="<?php if(!isset($skzi)) { ?>display: none;<?php }?>">
                <p><b>Дата проверки</b></p>
                <p field="verifDate" class="skzi-info-field"><?=((isset($skzi) && isset($skzi->verifDate)) ? $skzi->verifDate : '')?></p>
              </div>
              <div class="form__group" style="<?php if(!isset($skzi)) { ?>display: none;<?php }?>">
                <p><b>Срок действия проверки</b></p>
                <p field="verifExpires" class="skzi-info-field"><?=((isset($skzi) && isset($skzi->verifExpires)) ? $skzi->verifExpires : '')?></p>
              </div>
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
}
?>
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