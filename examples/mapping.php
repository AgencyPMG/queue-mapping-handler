<?php

use PMG\Queue;

require __DIR__.'/../vendor/autoload.php';
require __DIR__.'/StreamLogger.php';

$driver = new Queue\Driver\MemoryDriver();

$router = new Queue\Router\SimpleRouter('q');
$producer = new Queue\DefaultProducer($driver, $router);

$handler = Queue\Handler\MappingHandler::fromArray([
    'TestMessage' => function () {
        // noo
    },
    'TestMessage2' => function () {
        throw new \Exception('oops');
    },
    'MustStop' => function () {
        throw new Queue\Exception\SimpleMustStop('stopit');
    },
]);
$consumer = new Queue\DefaultConsumer(
    $driver,
    $handler,
    new Queue\Retry\NeverSpec(),
    new StreamLogger()
);

$producer->send(new Queue\SimpleMessage('TestMessage'));
$producer->send(new Queue\SimpleMessage('TestMessage2'));
$producer->send(new Queue\SimpleMessage('MustStop'));

exit($consumer->run('q'));
