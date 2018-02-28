<?php
/**
 * 自动创建并导入数据库
 *
 * @var \Phalcon\Db\AdapterInterface $connection
 */

use Phalcon\Exception;
use Phalcon\Db\Column;
use Phalcon\Db\Index;

try {
    $di = Phalcon\Di::getDefault();
    $config = $di->get('config');

    $dbClass = sprintf('\Phalcon\Db\Adapter\Pdo\%s', $config->get('adapter', 'MySql'));
    if (!class_exists($dbClass)) {
        throw new Exception(sprintf('PDO adapter "%s" not found.', $dbClass));
    }
    $dbConfig = $config->toArray();
    unset($dbConfig['adapter']);
    $connection = new $dbClass($dbConfig);
    $connection->begin();
    //创建一个用户表范例
    $connection->createTable('users', null, [
        'columns' => [
            new Column('id', [
                'type' => Column::TYPE_INTEGER,
                'size' => 10,
                'unsigned' => true,
                'notNull' => true,
                'autoIncrement' => true
            ]),
            new Column('username', [
                'type' => Column::TYPE_VARCHAR,
                'size' => 32,
                'notNull' => true
            ]),
            new Column('password', [
                'type' => Column::TYPE_CHAR,
                'size' => 40,
                'notNull' => true
            ]),
            new Column('name', [
                'type' => Column::TYPE_VARCHAR,
                'size' => 120,
                'notNull' => true
            ]),
            new Column('email', [
                'type' => Column::TYPE_VARCHAR,
                'size' => 70,
                'notNull' => true
            ]),
            new Column('created_at', [
                'type' => Column::TYPE_TIMESTAMP,
                'notNull' => true,
                'default' => 'CURRENT_TIMESTAMP'
            ]),
            new Column('active', [
                'type' => Column::TYPE_CHAR,
                'size' => 1,
                'notNull' => true
            ]),
        ],
        'indexes' => [
            new Index('PRIMARY', ['id'], 'PRIMARY')
        ]
    ]);
    $connection->execute("INSERT INTO users VALUES (1,'demo', 'c0bd96dc7ea4ec56741a4e07f6ce98012814d853','Phalcon Demo','demo@example.com','2018-2-28 09:41:20','Y')");
    $connection->commit();
} catch (\Exception $e) {
    if ($connection->isUnderTransaction()) {
        $connection->rollback();
    }
    echo $e->getMessage(), PHP_EOL;
    echo $e->getTraceAsString(), PHP_EOL;
}