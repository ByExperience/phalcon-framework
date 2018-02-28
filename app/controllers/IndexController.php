<?php

/**
 * 默认控制器
 *
 * Class IndexController
 */
class IndexController extends ControllerBase {

    public function initialize() {
        $this->tag->setTitle('Welcome');
        parent::initialize();
    }

    public function indexAction() {
        if (!$this->request->isPost()) {
            $this->flash->notice('This is a framework template made of Phalcon.');
        }
    }
}
