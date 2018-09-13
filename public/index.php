<?php
/**
 * This file is part of Tin.
 */
require_once __DIR__ .  '/../vendor/autoload.php';

require_once __DIR__ . '/../app/boot.php';

$db = \atk4\data\Persistence::connect(getenv('db.dsn'), getenv('db.username'), getenv('db.password'));


$query = new \atk4\dsql\Query(['connection' => $db]);


$query
    ->table('admin')
    ->field('count(*)')
;

dump($query
    ->getOne()
);

$components['router'] =  require(__DIR__ . '/../app/router/router.php');

$components['db'] = $db;

$components['server'] = \Tin\HttpServer::build();
(new \Tin\Tin($components))->run();
