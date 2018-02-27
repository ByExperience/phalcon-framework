<?php

namespace Crm;

use Phalcon\DiInterface;
use Phalcon\Mvc\ModuleDefinitionInterface;


class Module implements ModuleDefinitionInterface {
    /**
     * Registers the modules auto-loader
     *
     * @param DiInterface $di
     */
    public function registerAutoloaders(DiInterface $di = null) {

    }

    /**
     * Registers services related to the modules
     *
     * @param DiInterface $di
     */
    public function registerServices(DiInterface $di) {
        $dispatcher = $di->get('dispatcher');
        $dispatcher->setDefaultNamespace('Crm\Controllers\\');
        $di->set('dispatcher', $dispatcher);

        $view = $di->get('view');
        $view->setViewsDir(APP_PATH . '/app/modules/crm/views');
        $di->set('view', $view);

    }
}
