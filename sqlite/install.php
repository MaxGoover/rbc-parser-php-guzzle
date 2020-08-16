<?php

include 'config.php';

if (!file_exists(DB_NAME)) {
    $db = sqlite_open(DB_NAME); //создаем базу данных

    $sql = "CREATE TABLE articles(
        id INTEGER PRIMARY KEY,
        title STRING,
        text TEXT
    )";
    $result = sqlite_query($db, $sql);

    sqlite_close($db);
}






