<?php

error_reporting(E_ALL);

// 设置时区
date_default_timezone_set('Asia/Shanghai');

define('APP_PATH', realpath('..'));
try {
    /**
     * Read the configuration
     */
    $config = require APP_PATH . "/app/config/config.php";

    /**
     * Read auto-loader
     */
    require APP_PATH . "/app/config/loader.php";

    /**
     * Handle the request
     */
    $application = new \Phalcon\Mvc\Application(new Services($config));
    // 注册模块
    $application->registerModules(
        [
            "crm" => [
                "className" => "Crm\\Module",
                "path" => APP_PATH . "/app/modules/crm/Module.php",
            ]
        ]
    );
    echo $application->handle()->getContent();


} catch (\Exception $e) {
    // 500 服务器错误
    header("HTTP/1.0 500 Internal Server Error");
    $msg = 'Exception in file '  . $e->getFile() . ' on line '  . $e->getLine() . ".\n" . get_class($e) . '[' .
        $e->getCode() . ']: ' . $e->getMessage() . "\n" . $e->getTraceAsString();
    // 记录日志
    $logger = new \Phalcon\Logger\Adapter\File(APP_PATH . "/app/logs/errors.log");
    $logger->error($msg);
    $logger->close();
    echo '系统出错，请联系管理员！', '<br />';
}
