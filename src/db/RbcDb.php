<?php

namespace app\db;

use SQLite3;

/**
 * Класс подключения к базе данных "rbcDb".
 * Class RbcDb
 * @package app\db
 */
class RbcDb extends SQLite3
{
    function __construct()
    {
        $this->open(__DIR__ . 'rbcDb.db');
    }
}