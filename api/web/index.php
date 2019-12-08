<?php

use Symfony\Component\Dotenv\Dotenv;

require(__DIR__ . '/../vendor/autoload.php');

if (file_exists('../.env')) {
    (new Dotenv())->load('../.env');
}

if (getenv('STAGE') == 'dev') {
    defined('YII_DEBUG') or define('YII_DEBUG', true);
    defined('YII_ENV') or define('YII_ENV', 'dev');
    include '../c3.php';
}

require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

$config = require(__DIR__ . '/../config/api.php');
(new yii\web\Application($config))->run();
