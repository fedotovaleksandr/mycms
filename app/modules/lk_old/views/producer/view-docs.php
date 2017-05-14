<?php
use yii\helpers\Html;
$this->title = 'Список документов';
$this->registerJsFile('/web/scripts/lk/fa.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$request = \Yii::$app->request;
?>
<?=$this->render('menu');?>
<main class="page-main">
  <div class="breadcrumbs">
    <div class="container">
      <ul>
        <li><a href="/lk/producer/">Главная страница</a></li>
        <li class="active"><?=$name;?></li>
      </ul>
    </div>
  </div>
  <div class="container">
    <section>
      <div class="relative">
        <h1><?=$name;?></h1>
        <div class="absolite-content"><a href="#add-doc" data-toggle="modal" class="btn btn--primary">добавить документ</a></div>
      </div>
      <div class="catalog-adr">
        <div class="catalog-adr__item">
          <p>Номер версии ПО</p>
          <p class="text__lg"><?=($object ? $object->softVersion : '');?></p>
        </div>
        <div class="catalog-adr__item">
          <p>Организация изготовитель</p>
          <p class="text__lg"><?=($object ? $object->manufacturerName : '');?></p>
        </div>
        <div class="catalog-adr__item">
          <p>Адрес</p>
          <p class="text__lg"><?=($object ? $object->manufacturerAddress : '');?></p>
        </div>
      </div>
      <table class="table table--striped table-catalog">
        <thead>
          <tr>
            <th class="t5 text--center relative"><a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icon-cog"></i></a>
              <!--div aria-labelledby="dLabel" class="dropdown-menu">
                <div class="pull-right"><img src="/web/lk/producer/images/icons/close.png" alt=""></div>
                <h4>Отображаемые столбцы</h4>
                <div class="form__group">
                    <div class="checkbox">
                      <input type="checkbox" id="table11" checked>
                      <label for="table11">Тип</label>
                    </div>
                    <div class="checkbox">
                      <input type="checkbox" id="table12" checked>
                      <label for="table12">Название</label>
                    </div>
                    <div class="checkbox">
                      <input type="checkbox" id="table13" checked>
                      <label for="table13">Дата добавления</label>
                    </div>
                    <div class="checkbox">
                      <input type="checkbox" id="table14" checked>
                      <label for="table14">Файл</label>
                    </div>
                    <div class="checkbox">
                      <input type="checkbox" id="table15" checked>
                      <label for="table15">Доступность</label>
                    </div>
                    <div class="checkbox">
                      <input type="checkbox" id="table16" checked>
                      <label for="table16">Статус</label>
                    </div>
                    <div class="checkbox">
                      <input type="checkbox" id="table17" checked>
                      <label for="table17">Действие</label>
                    </div>
                </div>
                <div class="form__group"><a href="#" class="btn btn--primary">Применить</a></div>
              </div-->
            </th>
            <th>
              <?php
              if($request->get('sort') != 'id_type' || ( $request->get('order') != SORT_ASC && $request->get('order') != SORT_DESC))
              {
                ?>
                <a href="<?=yii\helpers\Url::current(['sort'=>'id_type', 'order' => SORT_ASC]);?>"><i class="icon-sort"></i></a>
                <?php
              }
              ?>
              <?php
              if($request->get('sort') == 'id_type' && $request->get('order') == SORT_ASC)
              {
                ?>
                <a href="<?=yii\helpers\Url::current(['sort'=>'id_type', 'order' => SORT_DESC]);?>"><i class="icon-sort-up"></i></a>
                <?php
              }
              ?>
              <?php
              if($request->get('sort') == 'id_type' && $request->get('order') == SORT_DESC)
              {
                ?>
                <a href="<?=yii\helpers\Url::current(['sort'=>'id_type', 'order' => SORT_ASC]);?>"><i class="icon-sort-down"></i></a>
                <?php
              }
              ?>
              Тип
            </th>
            <th class="t20">
              <?php
              if($request->get('sort') != 'name' || ( $request->get('order') != SORT_ASC && $request->get('order') != SORT_DESC))
              {
                ?>
                <a href="<?=yii\helpers\Url::current(['sort'=>'name', 'order' => SORT_ASC]);?>"><i class="icon-sort"></i></a>
                <?php
              }
              ?>
              <?php
              if($request->get('sort') == 'name' && $request->get('order') == SORT_ASC)
              {
                ?>
                <a href="<?=yii\helpers\Url::current(['sort'=>'name', 'order' => SORT_DESC]);?>"><i class="icon-sort-up"></i></a>
                <?php
              }
              ?>
              <?php
              if($request->get('sort') == 'name' && $request->get('order') == SORT_DESC)
              {
                ?>
                <a href="<?=yii\helpers\Url::current(['sort'=>'name', 'order' => SORT_ASC]);?>"><i class="icon-sort-down"></i></a>
                <?php
              }
              ?>
              Название
            </th>
            <th>
                <?php
                if($request->get('sort') != 'add_date' || ( $request->get('order') != SORT_ASC && $request->get('order') != SORT_DESC))
                {
                  ?>
                  <a href="<?=yii\helpers\Url::current(['sort'=>'add_date', 'order' => SORT_ASC]);?>"><i class="icon-sort"></i></a>
                  <?php
                }
                ?>
                <?php
                if($request->get('sort') == 'add_date' && $request->get('order') == SORT_ASC)
                {
                  ?>
                  <a href="<?=yii\helpers\Url::current(['sort'=>'add_date', 'order' => SORT_DESC]);?>"><i class="icon-sort-up"></i></a>
                  <?php
                }
                ?>
                <?php
                if($request->get('sort') == 'add_date' && $request->get('order') == SORT_DESC)
                {
                  ?>
                  <a href="<?=yii\helpers\Url::current(['sort'=>'add_date', 'order' => SORT_ASC]);?>"><i class="icon-sort-down"></i></a>
                  <?php
                }
                ?>
              <span class="inline">Дата последнего<br>изменения</span>
            </th>
            <th>
              <?php
                if($request->get('sort') != 'filesize' || ( $request->get('order') != SORT_ASC && $request->get('order') != SORT_DESC))
                {
                  ?>
                  <a href="<?=yii\helpers\Url::current(['sort'=>'filesize', 'order' => SORT_ASC]);?>"><i class="icon-sort"></i></a>
                  <?php
                }
                ?>
                <?php
                if($request->get('sort') == 'filesize' && $request->get('order') == SORT_ASC)
                {
                  ?>
                  <a href="<?=yii\helpers\Url::current(['sort'=>'filesize', 'order' => SORT_DESC]);?>"><i class="icon-sort-up"></i></a>
                  <?php
                }
                ?>
                <?php
                if($request->get('sort') == 'filesize' && $request->get('order') == SORT_DESC)
                {
                  ?>
                  <a href="<?=yii\helpers\Url::current(['sort'=>'filesize', 'order' => SORT_ASC]);?>"><i class="icon-sort-down"></i></a>
                  <?php
                }
                ?>
                Файл</th>
            <th class="t15">Доступность</th>
            <th>
              <?php
                if($request->get('sort') != 'status' || ( $request->get('order') != SORT_ASC && $request->get('order') != SORT_DESC))
                {
                  ?>
                  <a href="<?=yii\helpers\Url::current(['sort'=>'status', 'order' => SORT_ASC]);?>"><i class="icon-sort"></i></a>
                  <?php
                }
                ?>
                <?php
                if($request->get('sort') == 'status' && $request->get('order') == SORT_ASC)
                {
                  ?>
                  <a href="<?=yii\helpers\Url::current(['sort'=>'status', 'order' => SORT_DESC]);?>"><i class="icon-sort-up"></i></a>
                  <?php
                }
                ?>
                <?php
                if($request->get('sort') == 'status' && $request->get('order') == SORT_DESC)
                {
                  ?>
                  <a href="<?=yii\helpers\Url::current(['sort'=>'status', 'order' => SORT_ASC]);?>"><i class="icon-sort-down"></i></a>
                  <?php
                }
                ?>
              Статус</th>
            <th>Действие</th>
          </tr>
        </thead>
        <tbody>
          <?php
            foreach($docList as $doc)
            {
              ?>
            <tr>
              <td class="text--center">
                  <div class="checkbox">
                    <input type="checkbox" id="table-<?=$doc->id?>" device="doc" value="<?=$doc->id?>">
                    <label for="table-<?=$doc->id?>"></label>
                  </div>
              </td>
              <td><?=$doc->getTypeName($doc->id_type);?></td>
              <td><?=$doc->name;?></td>
              <td><?=$doc->getFormatedDate('d.m.Y', $doc->add_date);?></td>
              <td><a href="<?=$doc->getFilePath()?>" class="text--primary" title="<?=$doc->file?>" download><i class="icon-download-alt"></i><?=$doc->getFileSize($doc->filesize);?></a></td>
              <td><?php 
              $list = [];
              foreach($doc->getAvailability()->all() as $model)
              {
                $list[] = $model->name;
              }
              echo implode(', ', $list);
              ?>
              </td>
              <td><?=$doc->getStringStatus();?></td>
              <td><a href="#edit-doc-<?=$doc->id;?>" data-toggle="modal"><img src="/web/lk/producer/images/icons/icoTable-2.png" alt=""></a></td>
            </tr>
              <?php
            }
            ?>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="4">
              <ul class="list--table">
                <li>
                    <div class="checkbox">
                      <input type="checkbox" id="all-checbox" onchange="$('input[device=doc]').prop('checked', ($(this).prop('checked') ? true : false));$('input[device=doc]').change();">
                      <label for="all-checbox">Все</label>
                    </div>
                </li>
                <li><b>Выбрано: <span id="checked-count">0</span></b></li>
                <li>
                  <?=Html::beginForm('', 'POST', ['id' => 'doc-batch-actions', 'enctype' => 'multipart/form-data']);?>
                  <?=Html::hiddenInput('type', 'doc');?>
                  <select style="width: 290px;" class="select-actions" id="group-action-dropdown">
                    <option></option>
                    <option value="del">Удалить</option>
                  </select>
                  <button class="btn btn--primary btn-actions" style="margin-left: 20px;">Применить</button>
                  <?=Html::endForm();?>
                </li>
              </ul>
            </td>
            <td colspan="4">
              <!--ul class="list--table">
                <li class="select-transparent">
                  <select style="width: 180px;">
                    <option>Выводить по  5</option>
                    <option>Выводить по  10</option>
                    <option>Выводить по  15</option>
                    <option>Выводить по  20</option>
                  </select>
                </li>
                <li>5 из 256</li>
                <li>
                  <ul class="pagination">
                    <li class="pagination__item active"><a href="#">1</a></li>
                    <li class="pagination__item"><a href="#">2</a></li>
                    <li class="pagination__item"><a href="#">3</a></li>
                    <li class="pagination__item"><a href="#">...</a></li>
                    <li class="pagination__item"><a href="#">52</a></li>
                  </ul>
                </li>
              </ul-->
            </td>
          </tr>
        </tfoot>
      </table>
    </section>
  </div>
</main>
<?php
if($object)
{
  $addModel = new \app\modules\lk\models\producer\Docs;
  $addModel->id_device_type = $deviceType;
  $addModel->id_model = $object->id;
?>
<div id="add-doc" class="modal fade">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" data-dismiss="modal" aria-hidden="true" class="close"><img src="/web/lk/producer/images/close.png" alt=""></button>
        <h2>Добавление документа</h2>
      </div>
      <div class="modal-body">
          <?=Html::beginForm('/lk/producer/add-doc/', 'POST', ['enctype' => 'multipart/form-data', 'class' => 'form-block margtop0', 'id' => 'doc-add-form'])?>
          <?=Html::activeHiddenInput($addModel, 'id_device_type');?>
          <?=Html::activeHiddenInput($addModel, 'id_model');?>
          <div class="form__group" id="doc-add-form-errors"></div>
          <div class="form__group">
            <fieldset>
              <?=Html::activeDropDownList($addModel, 'id_type', $addModel->getTypes(), ['required' => TRUE, 'class' => 'select-hard', 'style' => 'width:100%']);?>
              <label>Тип</label><span class="require">*</span>
            </fieldset>
          </div>
          <div class="form__group">
            <fieldset>
              <?=Html::activeTextInput($addModel, 'name', ['required' => TRUE, 'class' => 'form-control edited']);?>
              <label>Название документа</label><span class="require">*</span>
            </fieldset>
          </div>
          <div class="form__group">
            <fieldset>
              <?=Html::activeFileInput($addModel, 'file', ['required' => TRUE]);?>
              <label>Файл</label><span class="require">*</span>
            </fieldset>
          </div>
          <div class="form__group">
            <fieldset>
              <?=Html::activeDropDownList($addModel, 'id_parent', $addModel->getPreviusVersionDropdown(), ['class' => 'select-hard', 'style' => 'width:100%']);?>
              <label>Предыдущая версия</label>
            </fieldset>
          </div>
          <div class="form__group">
            <fieldset>
              <?=Html::activeCheckboxList($addModel, 'availability', $addModel->getAccessTypes(), ['required' => TRUE]);?>
              <label>Доступность</label>
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
foreach($docList as $doc)
{
  ?>
  <div id="edit-doc-<?=$doc->id;?>" class="modal fade">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" data-dismiss="modal" aria-hidden="true" class="close"><img src="/web/lk/producer/images/close.png" alt=""></button>
          <h2>Редактирование документа</h2>
        </div>
        <div class="modal-body">
            <?=Html::beginForm('/lk/producer/update-doc/', 'POST', ['enctype' => 'multipart/form-data', 'class' => 'form-block margtop0 doc-edit-form', 'id' => 'doc-edit-form-'.$doc->id])?>
            <?=Html::activeHiddenInput($doc, 'id');?>
            <div class="form__group" id="doc-add-form-errors"></div>
            <div class="form__group">
              <fieldset>
                <?=Html::activeDropDownList($doc, 'id_type', $addModel->getTypes(), [
                    'required' => TRUE, 
                    'class' => 'select-hard', 
                    'style' => 'width:100%',
                    'default-value' => $doc->id_type
                    ]);?>
                <label>Тип</label><span class="require">*</span>
              </fieldset>
            </div>
            <div class="form__group">
              <fieldset>
                <?=Html::activeTextInput($doc, 'name', [
                    'required' => TRUE, 'class' => 
                    'form-control edited',
                    'default-value' => $doc->name
                        ]);?>
                <label>Название документа</label><span class="require">*</span>
              </fieldset>
            </div>
            <div class="form__group">
              <fieldset>
                <?=Html::activeFileInput($doc, 'file', []);?>
                <label>Файл</label><span class="require">*</span>
              </fieldset>
            </div>
            <div class="form__group">
              <fieldset>
                <?=Html::activeDropDownList($doc, 'id_parent', $doc->getPreviusVersionDropdown(), [
                    'class' => 'select-hard', 
                    'style' => 'width:100%',
                    'default-value' => $doc->id_parent
                    ]);?>
                <label>Предыдущая версия</label>
              </fieldset>
            </div>
            <div class="form__group">
              <fieldset>
                <?=Html::activeCheckboxList($doc, 'availability', $doc->getAccessTypes(), [
                    'required' => TRUE,
                    'id' => 'availability-checkbox-'.$doc->id,
                    
                    ]);?>
                <label>Доступность</label>
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
  }
}
?>
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