<?php

namespace App\Nodes;

use App\Agents\ResearchAgent;
use App\Agents\SearchQueriesOutput;
use App\Events\PerformSearchEvent;
use App\Events\ProgressEvent;
use App\Prompts;
use NeuronAI\Chat\Messages\UserMessage;
use NeuronAI\Workflow\Node;
use NeuronAI\Workflow\StartEvent;
use NeuronAI\Workflow\WorkflowState;

class GenerateQueries extends Node
{
    /**
     * @throws \Throwable
     */
    public function __invoke(StartEvent $event, WorkflowState $state): \Generator|PerformSearchEvent
    {
        $prompt = \str_replace('{query}', $state->get('query'), Prompts::SEARCH_QUERY_INSTRUCTIONS);

        yield new ProgressEvent("\n\n========== Generating search queries ==========\n\n");

        /** @var SearchQueriesOutput $response */
        $response = ResearchAgent::make()
            ->structured(
                new UserMessage($prompt),
                SearchQueriesOutput::class
            );

        yield new ProgressEvent(\implode("- ", $response->queries)  ."\n");

        return new PerformSearchEvent($response->queries);
    }
}