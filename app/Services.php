<?php

use Phalcon\Mvc\View;
use Phalcon\Mvc\Router;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Url as UrlProvider;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Flash\Direct as FlashDirect;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Cache\Backend\File as BackFile;
use Phalcon\Cache\Frontend\Data as FrontData;
use Phalcon\Logger\Adapter\File as LoggerFile;
use Phalcon\Mvc\Model\Metadata\Files as MetaData;

/**
 * 自动注册的服务
 *
 * Class Services
 */
class Services extends \Base\Services {

    /**
     * 注册分发器
     *
     * @return Dispatcher
     */
    protected function initDispatcher() {
        $eventsManager = new EventsManager;

        //使用NotFoundPlugin插件抛出未找到异常
        $eventsManager->attach('dispatch:beforeException', new NotFoundPlugin);

        $dispatcher = new Dispatcher;
        $dispatcher->setEventsManager($eventsManager);

        return $dispatcher;
    }

    /**
     * 注册Url组件
     *
     * @return UrlProvider
     */
    protected function initUrl() {
        $url = new UrlProvider();
        $url->setBaseUri($this->get('config')->application->baseUri);

        return $url;
    }

    /**
     * 注册视图组件
     *
     * @return View
     */
    protected function initView() {
        $view = new View();

        $appConfig = $this->get('config')->application;
        //设置视图文件夹
        $view->setViewsDir($appConfig->viewsDir);
        //设置布局文件夹
        $view->setLayoutsDir($appConfig->layoutDir);
        //设置模板
        $view->setTemplateAfter('main');
        //设置视图引擎
        $view->registerEngines([
            ".volt" => 'volt'
        ]);

        return $view;
    }


    /**
     * 设置视图模板
     *
     * @param $view
     * @param $di
     * @return VoltEngine
     */
    protected function initSharedVolt($view, $di) {
        $volt = new VoltEngine($view, $di);

        $volt->setOptions([
            "compiledPath" => $this->get('config')->application->cacheVoltDir
        ]);

        $compiler = $volt->getCompiler();
        $compiler->addFunction('is_a', 'is_a');

        return $volt;
    }

    /**
     * 根据配置连接数据库
     *
     * @return object
     */
    protected function initDb() {
        Phalcon\Mvc\Model::setup([
            'notNullValidations' => false
        ]);
        $config = $this->get('config')->get('database')->toArray();

        $dbClass = 'Phalcon\Db\Adapter\Pdo\\' . $config['adapter'];
        unset($config['adapter']);

        return new $dbClass($config);
    }


    /**
     * 缓存表结构
     *
     * @return MetaData
     */
    protected function initModelsMetadata() {
        return new MetaData([
            'metaDataDir' => $this->get('config')->application->cacheMetaDataDir
        ]);
    }


    /**
     * 注册提示信息输出服务
     *
     * @return FlashDirect
     */
    protected function initFlash() {
        return new FlashDirect([
            'error' => 'alert alert-danger',
            'success' => 'alert alert-success',
            'notice' => 'alert alert-info',
            'warning' => 'alert alert-warning'
        ]);
    }

    /**
     * 注册日志记录
     *
     * @return LoggerFile
     */
    public function initLogger() {
        return new LoggerFile(APP_PATH . "/app/logs/errors.log");
    }

    /**
     * 注册缓存服务
     *
     * @return BackFile
     */

    public function initCache() {
        $config = $this->get('config');
        $frontCache = new FrontData([
            "lifetime" => $config->application->cacheLifeTime,
        ]);

        $cache = new BackFile($frontCache, [
            "cacheDir" => $config->application->cacheDir
        ]);

        return $cache;
    }

    /**
     * 注册路由组件
     *
     * @return Router
     */
    public function initRouter() {
        $router = new Router();

        /**
         * 设置默认访问 /index/index
         */
        $router->add('/', [
            'controller' => 'index',
            'action' => 'index',
        ]);

        $router->add('/:controller/:action', [
            'controller' => 1,
            'action' => 2,
        ]);

        return $router;
    }


}
