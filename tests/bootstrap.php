<?php
require_once dirname(__FILE__) . '/../vendor/SplClassLoader/SplClassLoader.php';

$loader = new SplClassLoader('Yuyat', dirname(__FILE__) . '/../src');
$loader->setNamespaceSeparator('_');
$loader->register();
