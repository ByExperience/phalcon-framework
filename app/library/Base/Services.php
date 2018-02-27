<?php

namespace Base;

use Phalcon\DI\FactoryDefault;

class Services extends FactoryDefault {

    /**
     * Services constructor.
     *
     * @param $config
     */
    public function __construct($config) {
        parent::__construct();

        $this->setShared('config', $config);
        $this->bindServices();
    }

    /**
     * 绑定服务
     */
    protected function bindServices() {
        $reflection = new \ReflectionObject($this);
        $methods = $reflection->getMethods();

        foreach ($methods as $method) {

            if ((strlen($method->name) > 10) && (strpos($method->name, 'initShared') === 0)) {
                $this->setShared(lcfirst(substr($method->name, 10)), $method->getClosure($this));
                continue;
            }

            if ((strlen($method->name) > 4) && (strpos($method->name, 'init') === 0)) {
                $this->set(lcfirst(substr($method->name, 4)), $method->getClosure($this));
            }

        }
    }
}
