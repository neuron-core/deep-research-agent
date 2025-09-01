<?php

use App\DeepResearchAgent;
use App\Events\ProgressEvent;
use Gbhorwood\Macrame\Macrame;


include __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// instantiate a Macrame object with the script name
$macrame = new Macrame("NeuronAI Workflow Demo");

// only execute if run from the command line
if($macrame->running()) {
    // confirm host is good. die on failure.
    $macrame->preflight();
}

// Run the workflow
$run = function (string $input, Macrame $macrame): void {
    $workflow = new DeepResearchAgent($input, 2); // Limit to 1 for testing

    $handler = $workflow->start();

    foreach ($handler->streamEvents() as $event) {
        if ($event instanceof ProgressEvent) {
            $macrame->text($event->message)->write();
        }
    }

    $macrame->text($handler->getResult()->get('report'))->write(true);
};

// Interactive console
$input = $macrame->input()->readline("Describe the topic: ");

if (empty($input)) {
    $macrame->exit();
}

$macrame->spinner('dots 3')
    ->colour('green')
    ->run($run, [$input, $macrame]);

$macrame->exit();