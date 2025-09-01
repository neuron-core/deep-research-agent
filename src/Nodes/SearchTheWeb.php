<?php

namespace App\Workflow\Nodes;

use App\Workflow\Events\PerformSearchEvent;
use App\Workflow\Events\ProgressEvent;
use NeuronAI\Tools\Toolkits\Tavily\TavilySearchTool;
use NeuronAI\Workflow\Node;
use NeuronAI\Workflow\StopEvent;
use NeuronAI\Workflow\WorkflowState;

class SearchTheWeb extends Node
{
    public function __invoke(PerformSearchEvent $event, WorkflowState $state): \Generator|StopEvent
    {
        $tavily = TavilySearchTool::make($_ENV['TAVILY_API_KEY']);

        yield new ProgressEvent("\n\n========== Searching the web ==========\n\n");

        $results = [];
        foreach ($event->queries as $query) {
            yield new ProgressEvent("- Searching for: {$query} \n");
            $response = $tavily($query);
            $results= \array_merge($results, $response['results']);
        }

        $state->set('results', \array_map(fn (array $result): string => $result['content'], $results));

        return new StopEvent();
    }
}