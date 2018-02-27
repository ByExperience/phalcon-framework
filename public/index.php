<?php

error_reporting(E_ALL);

date_default_timezone_set('Asia/Shanghai');

define('APP_PATH', realpath('..'));

try {

    $config = require APP_PATH . "/app/config/config.php";

    require APP_PATH . "/app/config/loader.php";

    /**
     * 处理请求
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

    /**
     * 发送响应
     */
    echo $application->handle()->getContent();


} catch (\Exception $e) {

    //返回服务器错误
    header("HTTP/1.0 500 Internal Server Error");

    $msg = 'Exception in file '  . $e->getFile() . ' on line '  . $e->getLine() . ".\n" . get_class($e) . '[' .
        $e->getCode() . ']: ' . $e->getMessage() . "\n" . $e->getTraceAsString();

    // 记录日志
    $logger = new \Phalcon\Logger\Adapter\File(APP_PATH . "/app/logs/errors.log");
    $logger->error($msg);
    $logger->close();

    echo '系统出错，请联系管理员！', '<br />';
}
