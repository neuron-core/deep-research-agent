<?php

namespace App;

use App\Nodes\GenerateQueries;
use App\Nodes\SearchTheWeb;
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