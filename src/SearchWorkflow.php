<?php

namespace App\Workflow;

use App\Workflow\Nodes\GenerateQueries;
use App\Workflow\Nodes\SearchTheWeb;
use NeuronAI\Workflow\Workflow;

class SearchWorkflow extends Workflow
{
    protected function nodes(): array
    {
        return [
            new GenerateQueries(),
            new SearchTheWeb(),
        ];
    }
}