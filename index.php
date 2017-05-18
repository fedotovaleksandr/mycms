<?php
// comment out the following two lines when deployed to production
if (!defined('YII_DEBUG')) {
    define('YII_DEBUG', true);
}
if (!defined('YII_ENV')) {
    define('YII_ENV', 'dev');
}

require(__DIR__.'/vendor/autoload.php');
require(__DIR__.'/vendor/yiisoft/yii2/Yii.php');

$config = require(__DIR__.'/app/config/web.php');

(new yii\web\Application($config))->run();
