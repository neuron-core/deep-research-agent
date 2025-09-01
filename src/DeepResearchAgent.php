<?php

namespace App;

use App\Nodes\Format;
use App\Nodes\GenerateSectionContent;
use App\Nodes\Planning;
use NeuronAI\Exceptions\WorkflowException;
use NeuronAI\Workflow\Workflow;
use NeuronAI\Workflow\WorkflowState;

class DeepResearchAgent extends Workflow
{
    /**
     * @throws WorkflowException
     */
    public function __construct(string $query, protected int $maxSections = 3)
    {
        parent::__construct(new WorkflowState(['topic' => $query]));
    }

    protected function nodes(): array
    {
        return [
            new Planning($this->maxSections),
            new GenerateSectionContent(), // Loop until all sections are generated
            new Format(),
        ];
    }
}