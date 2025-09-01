<?php

namespace App\Events;

use App\Agents\ReportPlanOutput;
use NeuronAI\Workflow\Event;

class SectionGenerationEvent implements Event
{
    public function __construct(public ReportPlanOutput $plan)
    {
    }
}