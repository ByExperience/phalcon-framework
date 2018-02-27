<?php

$loader = new \Phalcon\Loader();

/**
 * 注册配置中一些文件夹
 */
$loader->registerDirs([
    $config->application->pluginsDir,
    $config->application->libraryDir,
    $config->application->modelsDir,
])->register();

/**
 * 注册类
 */
$loader->registerClasses([
    'Services' => APP_PATH . '/app/Services.php',
    'ControllerBase' =>  APP_PATH . '/app/ControllerBase.php'
]);

/**
 * 注册命名空间
 */
$loader->registerNamespaces(
    [
        'Crm\Controllers' => APP_PATH . '/app/modules/crm/controllers/',
    ]
);

/**
 * 引入composer
 */
require_once __DIR__.'/../../vendor/autoload.php';
