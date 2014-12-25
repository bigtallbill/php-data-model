<?php

require_once __DIR__ . '/vendor/autoload.php';

$loader = new \Composer\Autoload\ClassLoader();
$loader->add('Bigtallbill', __DIR__ . '/src');
$loader->register();
