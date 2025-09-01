<?php

namespace App\Events;

use App\Agents\ReportPlanOutput;
use NeuronAI\Workflow\Event;

class FormattingReportEvent implements Event
{
    public function __construct(public ReportPlanOutput $reportPlan)
    {
    }
}