<?php
require_once dirname(__FILE__) . '/autoload.php';

$queueFactory = new Yuyat_Bulky_QueueFactory(
    new Yuyat_Bulky_DbAdapter_PdoMysqlAdapter(new PDO (
        'mysql:dbname=bulky_test;host=localhost',
        'root'
    )),
    1000
);
$queue = $queueFactory->createQueue('users', array('name', 'birthday'));

$queue->on('error', function ($records) {
    echo "Error!", PHP_EOL;
});

for ($i = 0; $i < 100000; $i++) {
    $queue->insert(array('Scott Wino Weinrich', '1960-09-29'));
}
