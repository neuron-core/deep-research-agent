<?php

namespace App\Workflow\Nodes;

use App\Workflow\Agents\ReportPlanOutput;
use App\Workflow\Agents\ReportSection;
use App\Workflow\Agents\ResearchAgent;
use App\Workflow\Events\ProgressEvent;
use App\Workflow\Events\SectionGenerationEvent;
use App\Workflow\Prompts;
use NeuronAI\Chat\Messages\UserMessage;
use NeuronAI\Workflow\Node;
use NeuronAI\Workflow\StartEvent;
use NeuronAI\Workflow\WorkflowState;

class Planning extends Node
{
    public function __construct(protected int $maxSections = 3)
    {
    }

    public function __invoke(StartEvent $event, WorkflowState $state): \Generator|SectionGenerationEvent
    {
        yield new ProgressEvent("\n========== Starting to generate report plan ==========\n");

        /** @var ReportPlanOutput $plan */
        $plan = ResearchAgent::make()
            ->withInstructions(
                "You are an expert in research. You are given a user query and you need to generate a report plan for the user."
            )
            ->structured(
                new UserMessage(str_replace('{topic}', $state->get('topic'), Prompts::REPORT_PLAN_INSTRUCTIONS)),
                ReportPlanOutput::class
            );

        $plan->sections = \array_slice($plan->sections, 0, $this->maxSections);

        $sections = \array_reduce($plan->sections, function (string $carry, ReportSection $section): string {
            $carry .= "- {$section->description}\n";
            return $carry;
        }, '');

        yield new ProgressEvent("\n {$sections}");

        return new SectionGenerationEvent($plan);
    }
}