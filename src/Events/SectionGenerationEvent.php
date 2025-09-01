<?php

namespace App\Workflow\Events;

use App\Workflow\Agents\ReportPlanOutput;
use NeuronAI\Workflow\Event;

class SectionGenerationEvent implements Event
{
    public function __construct(public ReportPlanOutput $plan)
    {
    }
}