<?php
use yii\helpers\Html;
use app\modules\lk\components\ProducerHelper;
$this->title = 'Список СКЗИ';
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
        <li class="active">Список СКЗИ</li>
      </ul>
    </div>
  </div>
  <div class="container">
    <section>
      <div class="relative">
        <h1>Список СКЗИ</h1>
        <div class="absolite-content top">
          <ul class="list--inline">
            <li><img src="/web/lk/producer/images/tah-ico-3.png" alt=""><a href="#modal-skzi" data-toggle="modal"><b class="text--primary">Добавить СКЗИ</b></a></li>
            <li><img src="/web/lk/producer/images/tah-ico-4.png" alt=""><a href="/lk/producer/add-batch-skzi/"><b class="text--primary">Добавить новую партию СКЗИ</b></a></li>
          </ul>
        </div>
      </div>
      <form class="catalog-tah form-block">
        <div class="catalog-tah__inner">
          <div class="catalog-tah__item t20">
            <fieldset>
              <input type="text" name="serialNumberFull" autocomplete="off" class="form-control <?=$request->get('serialNumberFull') ? 'edited' : ''?>" value="<?=$request->get('serialNumberFull')?>">
              <label>Номер СКЗИ</label>
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
          <div class="catalog-tah__item t15">
            <?=Html::dropDownList('activationStatus', $request->get('activationStatus'), $filters['activationStatus']['values'], ['style' => 'width: 205px;', 'class' => 'edited']);?>
          </div>
          <div class="catalog-tah__item">
            <button type="submit" class="btn btn--primary btn__lg">найти</button>
          </div>
          <div class="catalog-tah__item"><a href="#" class="search-adv search-adv--js">Расширенный поиск</a></div>
        </div>
        <div class="catalog-tah__hide" style="<?=($request->get('verifDateFrom')||$request->get('verifDateTo')||$request->get('verifExpiresFrom')||$request->get('verifExpiresTo')) ? 'display:block;' : ''?>">
          <div class="catalog-tah__inner"></div>
          <div class="catalog-tah__inner">
            <div class="catalog-tah__item t33">
              <?=Html::dropDownList('equipTypeId', $request->get('equipTypeId'), $filters['equipTypeId']['values'], ['style' => 'width: 285px;', 'class' => 'edited']);?>
            </div>
            <!--div class="catalog-tah__item t25">
              <fieldset>
                <input type="text" name="num5" autocomplete="off" value="Дополнительная плата: V112" required class="form-control edited">
                <label>Номер версии ПО</label>
              </fieldset>
            </div-->
            <div class="catalog-tah__item t33">
              <fieldset>
                <input type="text" id="verifDate" autocomplete="off" class="form-control date-range edited" from="verifDateFrom" to="verifDateTo">
                <label>Дата проверки</label>
                <input type="hidden" name="verifDateFrom" value="<?=$request->get('verifDateFrom')?>" />
                <input type="hidden" name="verifDateTo" value="<?=$request->get('verifDateTo')?>"/>
              </fieldset>
            </div>
            <div class="catalog-tah__item t33">
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
            <th class="t5 text--center relative">
              <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icon-cog"></i></a>
              <div aria-labelledby="dLabel" class="dropdown-menu">
                <?=Html::beginForm('/lk/producer/table/', 'POST');?>
                  <?=Html::hiddenInput('table', 'skzi');?>
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
            <th class="t10">Действие</th>
          </tr>
        </thead>
        <tbody>
          <?php
            foreach($list as $key => $row)
            {
              ?>
            <tr>
              <td class="text--center">
                <div class="checkbox">
                  <input type="checkbox" device="skzi" name="id[<?=$objects[$key]->id?>]" id="skzi-<?=$objects[$key]->id?>" value="<?=$objects[$key]->id?>" />
                  <label for="skzi-<?=$objects[$key]->id?>"></label>
                </div>
              </td>
              <?php
              foreach($viewTableFields as $fieldKey => $field)
              {
              ?>
              <td><?=$row[$fieldKey]?></td>
              <?php
              }
              ?>
              <td>
                <ul class="list--inline">
                  <li>
                  <?php
                  if(ProducerHelper::checkSkziAction('edit', $objects[$key]))
                  {
                    ?>
                    <a href="#modal-skzi-edit-<?=$objects[$key]->id?>" data-toggle="modal" title="редактировать"><img src="/web/lk/producer/images/icons/icoTable-3.png" alt=""></a></li>
                  <?php
                  }
                  ?>
                  <?php
                  if(ProducerHelper::checkSkziAction('archive', $objects[$key]))
                  {
                    ?>
                    <li><a href="/lk/producer/archive/?id=<?=$objects[$key]->id?>" title="архивировать" action="archive" device-type="skzi" csrfparam ="<?=\Yii::$app->request->csrfParam?>" csrftoken="<?=\Yii::$app->request->getCsrfToken()?>"><img src="/web/lk/producer/images/icons/carh.png" alt=""></a>
                  <?php
                  }
                  ?>
                  <?php
                  if(ProducerHelper::checkSkziAction('unarchive', $objects[$key]))
                  {
                    ?>
                    <li><a href="/lk/producer/unarchive/?id=<?=$objects[$key]->id?>" title="разархивировать" action="unarchive" device-type="skzi" csrfparam ="<?=\Yii::$app->request->csrfParam?>" csrftoken="<?=\Yii::$app->request->getCsrfToken()?>"><img src="/web/lk/producer/images/icons/icoTable-6.png" alt=""></a>
                  <?php
                  }
                  ?>
                  <?php
                  if(ProducerHelper::checkSkziAction('stop', $objects[$key]))
                  {
                    ?>
                    <li><a href="/lk/producer/stop/?id=<?=$objects[$key]->id?>" title="добавить в стоп-лист" action="stop" device-type="skzi" csrfparam ="<?=\Yii::$app->request->csrfParam?>" csrftoken="<?=\Yii::$app->request->getCsrfToken()?>"><img src="/web/lk/producer/images/icons/icoTable-5.png" alt=""></a>
                  <?php
                  }
                  ?>
                </ul>
              </td>
            </tr>
              <?php
            }
            ?>
        </tbody>
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
<div id="modal-skzi" class="modal fade">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" data-dismiss="modal" aria-hidden="true" class="close"><img src="/web/lk/producer/images/close.png" alt=""></button>
        <h2>Добавление</h2>
      </div>
      <div class="modal-body">
        <?=Html::beginForm('/lk/producer/add-skzi/', 'POST', ['enctype' => 'multipart/form-data', 'class' => "form-block margtop0", 'id' => 'skzi-form'])?>
          <h4>Блок СКЗИ</h4>
          <div class="form__group" id="skzi-form-errors"></div>
          <div class="form__group">
            <fieldset>
              <?=Html::activeInput('text', $model, 'serialNumberFull', ['autocomplete' => 'off', 'required' => TRUE, 'class' => 'form-control edited'])?>
              <label>Серийный номер</label><span class="require">*</span>
            </fieldset>
          </div>
          <div class="form__group">
            <fieldset>
              <?=Html::activeDropDownList($model, 'equipTypeId', app\modules\lk\models\SkziModels::getDataForDropDownList(TRUE), ['required' => TRUE, 'class' => 'select-hard edited', 'style' => 'width:100%', 'id' => 'skzi-add-form-select-id-model']);?>
              <label>Модель</label><span class="require">*</span>
            </fieldset>
          </div>
          <!--div class="form__group">
            <fieldset>
              <?=Html::activeDropDownList($model, 'softwareVersion', [], ['required' => TRUE, 'class' => 'select-hard edited', 'style' => 'width:100%', 'default-value' => $model->softwareVersion, 'id' => 'skzi-add-form-select-softwareVersion']);?>
              <label>Номер версии ПО</label><span class="require">*</span>
            </fieldset>
          </div-->
          <div class="form__group">
            <fieldset>
              <input type="text" autocomplete="off"  required class="form-control edited date" to="createDate-hidden" id="createDate">
              <label>Дата изготовления</label><span class="require">*</span>
              <?=Html::activeInput('hidden', $model, 'createDate', ['id' => 'createDate-hidden'])?>
            </fieldset>
          </div>
          <div class="form__group">
            <fieldset>
              <input type="text" autocomplete="off"  required class="form-control edited date" to="verifDate-hidden" id="verifDate">
              <label>Дата проверки</label><span class="require">*</span>
              <?=Html::activeInput('hidden', $model, 'verifDate', ['id' => 'verifDate-hidden'])?>
            </fieldset>
          </div>
          <div class="form__group">
            <fieldset>
              <input type="text" autocomplete="off"  required class="form-control edited date" to="verifExpires-hidden" id="verifExpires">
              <label>Срок действия проверки</label><span class="require">*</span>
              <?=Html::activeInput('hidden', $model, 'verifExpires', ['id' => 'verifExpires-hidden'])?>
            </fieldset>
          </div>
          <div class="margtop20">
            <p><span class="require">*</span> Поля, обязательные для заполнения</p>
            <ul class="list--inline">
              <li>
                <button type="submit" class="btn btn--primary">сохранить</button>
              </li>
              <li>
                <button type="reset" class="btn btn--transparent">отменить</button>
              </li>
            </ul>
          </div>
        <?=Html::endForm();?>
      </div>
    </div>
  </div>
</div>
<?php
foreach($objects as $object)
{
  if(ProducerHelper::checkSkziAction('edit', $object) === FALSE)
  {
    continue;
  }
  $editModel = new \app\modules\lk\models\producer\SkziForm();
  $editModel->loadFromObject($object);
?>
<div id="modal-skzi-edit-<?=$object->id?>" class="modal fade">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" data-dismiss="modal" aria-hidden="true" class="close"><img src="/web/lk/producer/images/close.png" alt=""></button>
        <h2>Редактирование</h2>
      </div>
      <div class="modal-body">
        <?=Html::beginForm('/lk/producer/update-skzi/', 'POST', [
            'enctype' => 'multipart/form-data', 
            'class' => "form-block margtop0 skzi-form-edit", 
            'id' => 'skzi-form-edit-'.$object->id,
            ])?>
          <?=Html::hiddenInput('id', $object->id);?>
          <?=Html::activeInput('hidden', $editModel, 'id', [])?>
          <h4>Блок СКЗИ</h4>
          <div class="form__group" id="skzi-form-errors"></div>
          <div class="form__group">
            <fieldset>
              <?=Html::activeInput('text', $editModel, 'serialNumberFull', [
                  'autocomplete' => 'off', 
                  'required' => TRUE, 
                  'class' => 'form-control edited',
                  'default-value' => $editModel->serialNumberFull
                  ])?>
              <label>Серийный номер</label><span class="require">*</span>
            </fieldset>
          </div>
          <div class="form__group">
            <fieldset>
              <?=Html::activeDropDownList($editModel, 'equipTypeId', app\modules\lk\models\SkziModels::getDataForDropDownList(TRUE), [
                  'required' => TRUE, 
                  'class' => 'select-hard', 
                  'style' => 'width:100%', 
                  'id' => 'skzi-add-form-select-id-model',
                  'default-value' => $editModel->equipTypeId
                  ]);?>
              <label>Модель</label><span class="require">*</span>
            </fieldset>
          </div>
          <!--div class="form__group">
            <fieldset>
              <?=Html::activeDropDownList($editModel, 'softwareVersion', [], [
                  'required' => TRUE, 
                  'class' => 'select-hard', 
                  'style' => 'width:100%', 
                  'default-value' => $editModel->softwareVersion, 
                  'id' => 'skzi-add-form-select-softwareVersion',
                  'default-value' => $editModel->softwareVersion
                  ]);?>
              <label>Номер версии ПО</label><span class="require">*</span>
            </fieldset>
          </div-->
          <div class="form__group">
            <fieldset>
              <input type="text" autocomplete="off"  required class="form-control edited date" to="createDate-hidden-<?=$object->id?>" id="createDate-<?=$object->id?>">
              <label>Дата изготовления</label><span class="require">*</span>
              <?=Html::activeInput('hidden', $editModel, 'createDate', [
                  'id' => 'createDate-hidden-'.$object->id,
                  'default-value' => $editModel->createDate
                  ])?>
            </fieldset>
          </div>
          <div class="form__group">
            <fieldset>
              <input type="text" autocomplete="off"  required class="form-control edited date" to="verifDate-hidden-<?=$object->id?>" id="verifDate-<?=$object->id?>">
              <label>Дата проверки</label><span class="require">*</span>
              <?=Html::activeInput('hidden', $editModel, 'verifDate', [
                  'id' => 'verifDate-hidden-'.$object->id,
                  'default-value' => $editModel->verifDate
                  ])?>
            </fieldset>
          </div>
          <div class="form__group">
            <fieldset>
              <input type="text" autocomplete="off"  required class="form-control edited date" to="verifExpires-hidden-<?=$object->id?>" id="verifExpires-<?=$object->id?>">
              <label>Срок действия проверки</label><span class="require">*</span>
              <?=Html::activeInput('hidden', $editModel, 'verifExpires', [
                  'id' => 'verifExpires-hidden-'.$object->id,
                  'default-value' => $editModel->verifExpires
                  ])?>
            </fieldset>
          </div>
          <div class="margtop20">
            <p><span class="require">*</span> Поля, обязательные для заполнения</p>
            <ul class="list--inline">
              <li>
                <button type="submit" class="btn btn--primary">сохранить</button>
              </li>
              <li>
                <button type="reset" class="btn btn--transparent">отменить</button>
              </li>
            </ul>
          </div>
        <?=Html::endForm();?>
      </div>
    </div>
  </div>
</div>
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
 * 
 */
?>