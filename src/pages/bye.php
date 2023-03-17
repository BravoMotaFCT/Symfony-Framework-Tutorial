<?php
// framework/bye.php
$navRoot = '/../..';

require_once __DIR__.$navRoot.'/init.php';

$response->setContent('Goodbye!');
$response->send();