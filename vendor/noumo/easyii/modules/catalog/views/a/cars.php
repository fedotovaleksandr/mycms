<?php
use yii\easyii\modules\catalog\models\Item;
use yii\helpers\Html;
use yii\helpers\Url;
$this->title = Yii::t('easyii/catalog', 'Марки автомобилей  <a href="/admin/catalog/a/carcreate" style="margin-left: 66%" class="btn btn-success">Добавить</a>');
echo $this->render('@easyii/views/category/_menu.php', ['category' => $model]) ?>
    <table class="table table-hover">
    <thead>
    <tr>
        <th><?= Yii::t('easyii', 'Название') ?></th>
        <th width="150"><?= Yii::t('easyii', 'Действия') ?></th>
    </tr>
    </thead>
    <tbody>

<? foreach ($model as $car){?>
    <tr>
<td><a href="<?= Url::to(['/admin/catalog/a/car-edit/', 'id' => $car->id]) ?>"><?= $car->name ?></a></td>
<td>
    <div class="btn-group btn-group-sm" role="group">
    <a href="<?= Url::to(['/admin/catalog/a/cardelete', 'id' => $car->id]) ?>" class="btn btn-default confirm-delete" title="<?= Yii::t('easyii', 'Delete item') ?>"><span class="glyphicon glyphicon-remove"></span></a>
    </div>
</td>
    </tr>
<?
}
?>