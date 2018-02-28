<?php

use Phalcon\Mvc\Controller;
use Phalcon\Http\Request;

/**
 * 控制器基类
 *
 * Class ControllerBase
 */
class ControllerBase extends Controller {

    /**
     * 请求对象
     *
     * @var Request
     */
    protected $_request;

    /**
     * 初始化
     */
    public function initialize() {
        //设置模板视图的通用标题
        $this->tag->prependTitle('');
    }

    /**
     * 返回JSON响应
     *
     * @param array $data
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     */
    protected function outputJson($data) {
        $this->response->setStatusCode(200, "OK");
        $this->response->setContentType('application/json', 'utf-8');
        $this->response->setContent(json_encode($data));

        return $this->response->send();
    }

    /**
     * 获取请求对象
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
