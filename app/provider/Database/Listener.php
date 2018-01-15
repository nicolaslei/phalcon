<?php

namespace Lianni\Provider\Database;

use Phalcon\Db\Adapter\Pdo;
use Phalcon\Events\Event;
use Phalcon\Logger\Adapter;

/**
 * Class Database
 * @package Lianni\Provider\Database\Listener
 */
class Listener
{
    public function beforeQuery(Event $event, Pdo $connection)
    {
        $logger = container()->get('logger', ['db']);

        if ($logger instanceof Adapter) {
            $string    = $connection->getSQLStatement();
            $variables = $connection->getSqlVariables();
            $context   = $variables ? ' [' . implode(', ', $variables) . ']' : '';

            $logger->debug($string . $context);
        }
    }
}