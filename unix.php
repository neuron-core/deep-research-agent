<?php

use App\DeepResearchAgent;
use App\Events\ProgressEvent;


include __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Interactive console
echo 'Describe the topic: ';
$input = \rtrim(\fgets(STDIN));

if (empty($input)) {
    exit(0);
}

$workflow = new DeepResearchAgent($input, 3);

$handler = $workflow->start();

foreach ($handler->streamEvents() as $event) {
    if ($event instanceof ProgressEvent) {
        echo $event->message;
    }
}

echo "\n".$handler->getResult()->get('report')."\n";
