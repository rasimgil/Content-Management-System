<?php
require_once __DIR__ . '/src/db_config.php';
require_once __DIR__ . '/src/Model.php';
require_once __DIR__ . '/src/Controller.php';

$db = new mysqli(
    $db_config['server'],
    $db_config['login'],
    $db_config['password'],
    $db_config['database']
);

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

$model = new Model($db_config);

$controller = new Controller($model);
$urlPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$controller->route($urlPath);

$db->close();
