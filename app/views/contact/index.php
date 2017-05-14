<?php
use yii\easyii\modules\feedback\api\Feedback;
use yii\easyii\modules\page\api\Page;

$page = Page::get('page-contact');

$this->title = $page->seo('title', $page->model->title);
$this->params['breadcrumbs'][] = $page->model->title;
?>
<h1><?= $page->seo('h1', $page->title) ?></h1>
<br>
<div class="row">
    <div class="col-md-6">
        <div class="row">
        <?= $page->text ?>
        </div>
        <div class="row">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1997.5180966157575!2d30.30627031586817!3d59.956728981882755!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x469631413c02702d%3A0x74a74b66305df56c!2z0KHQsNCx0LvQuNC90YHQutCw0Y8g0YPQuy4sIDE0LCDQodCw0L3QutGCLdCf0LXRgtC10YDQsdGD0YDQsywgMTk3MTk4!5e0!3m2!1sru!2sru!4v1493641869978" width="400" height="300" frameborder="0" style="border:0" allowfullscreen></iframe>
        </div>
    </div>

    <div class="col-md-5  ">
        <?php if(Yii::$app->request->get(Feedback::SENT_VAR)) : ?>
            <h4 class="text-success"><i class="glyphicon glyphicon-ok"></i> Message successfully sent</h4>
        <?php else : ?>
            <div class="well well-sm">
                <?= Feedback::form() ?>
            </div>
        <?php endif; ?>
    </div>
</div>


