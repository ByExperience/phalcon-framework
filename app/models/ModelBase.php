<?php

use Phalcon\Mvc\Model;

/**
 * 模型基类
 *
 * Class ModelBase
 */
class ModelBase extends Model {

    /**
     * 获取数据连接
     *
     * @return \Phalcon\Db\Adapter\Pdo\Mysql
     */
    public function getDbAdapter() {
        return $this->getDI()->getDb();
    }
}