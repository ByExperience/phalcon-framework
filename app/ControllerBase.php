<?php

use Phalcon\Mvc\Controller;

use \Phalcon\Http\Request;

class ControllerBase extends Controller {
    protected $_request;

    /**
     * 初始化
     */
    public function initialize() {
        $this->tag->prependTitle('');

    }

    /**
     * 输出json响应
     *
     * @param $data
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     */
    protected function outputJson($data) {
        $this->response->setStatusCode(200, "OK");
        $this->response->setContentType('application/json', 'utf-8');
        $this->response->setContent(json_encode($data));

        return $this->response->send();
    }

    /**
     * 获取request对象
     *
     * @return Request
     */
    public function getRequest() {
        if (is_null($this->_request)) {
            $this->_request = new Request();
        }

        return $this->_request;
    }
}
