<?php

require_once 'Configuration.php';

$connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

if ($connection->connect_errno) {
    die('Can not connect to database: ' . $connection->connect_error);
}