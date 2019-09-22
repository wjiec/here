<?php
/**
 * here application
 *
 * @package   here
 * @author    Jayson Wang <jayson@laboys.org>
 * @copyright Copyright (C) 2016-2019 Jayson Wang
 * @license   MIT License
 * @link      https://github.com/nosjay/here
 */
namespace Here\Libraries\Listener;


use Phalcon\Db\Adapter\Pdo;
use Phalcon\Events\Event;

/**
 * Class Database
 * @package Here\Libraries\Listener
 */
final class Database {

    /**
     * Database queries listener
     *
     * @noinspection PhpUnused
     * @param Event $event
     * @param Pdo $connection
     * @return bool
     */
    final public function beforeQuery(Event $event, Pdo $connection): bool {
        $statement = $connection->getSQLStatement();
        $variables = $connection->getSqlVariables();

        $logger = container('logger', 'db');
        $logger->debug(sprintf("BeforeQuery:\nStatement: %s\nVariables:%s",
        $statement, join(', ', $variables)));

        return true;
    }

}
