<?php

namespace app\db;

use SQLite3;

class RbcDb extends SQLite3
{
    function __construct()
    {
        $this->open(__DIR__ . 'rbcDb.db');
    }
}