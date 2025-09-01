<?php

namespace App\Events;

use NeuronAI\Workflow\Event;

class PerformSearchEvent implements Event
{
    /**
     * @param string[] $queries
     */
    public function __construct(public array $queries)
    {
    }
}