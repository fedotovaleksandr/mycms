<?php
if (!defined('MYCMS_DB_HOST')) {
    define('MYCMS_DB_HOST', 'localhost');
}

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host='.'db'.';dbname=ifmo',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
    'tablePrefix' => 'ifmo_',
    'enableSchemaCache' => true,
];
