<?php

use Phalcon\Events\Event;
use Phalcon\Mvc\User\Plugin;
use Phalcon\Dispatcher;
use Phalcon\Mvc\Dispatcher\Exception as DispatchException;
use Phalcon\Mvc\Dispatcher as MvcDispatcher;


/**
 * NotFoundPlugin
 *
 * Handles not-found controller/actions
 */
class NotFoundPlugin extends Plugin {

    /**
     * This action is executed before execute any action in the application
     *
     * @param Event $event
     * @param MvcDispatcher $dispatcher
     * @param Exception $exception
     * @return boolean
     */
    public function beforeException(Event $event, MvcDispatcher $dispatcher, Exception $exception) {

        $msg = 'Exception in file ' . $exception->getFile() . ' on line ' . $exception->getLine() . ".\n" . 'Exception message: "' . $exception->getMessage() . '" and error code: ' . $exception->getCode() . "\n" . $exception->getTraceAsString();
        $this->di->get('logger')->error($msg);


        if ($exception instanceof DispatchException) {
            switch ($exception->getCode()) {
                case Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
                case Dispatcher::EXCEPTION_ACTION_NOT_FOUND:

                    $dispatcher->forward([
                        'controller' => 'errors',
                        'action' => 'show404'
                    ]);

                    return false;
            }
        }
        // 处理自定义输出
        $di = \Phalcon\Di::getDefault();
        $di->getShared('output')->sendExceptionOutput();


        $dispatcher->forward([
            'controller' => 'errors',
            'action' => 'show500'
        ]);

        return false;
    }
}
