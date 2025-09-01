<?php

namespace App\Nodes;

use App\Agents\ResearchAgent;
use App\Events\ProgressEvent;
use App\Events\FormattingReportEvent;
use App\Events\SectionGenerationEvent;
use App\Prompts;
use App\SearchWorkflow;
use NeuronAI\Chat\Messages\AssistantMessage;
use NeuronAI\Chat\Messages\UserMessage;
use NeuronAI\Exceptions\WorkflowException;
use NeuronAI\Workflow\Node;
use NeuronAI\Workflow\WorkflowInterrupt;
use NeuronAI\Workflow\WorkflowState;

/**
 * For multiple sections this node will be called multiple times.
 */
class GenerateSectionContent extends Node
{
    /**
     * @throws \Throwable
     * @throws WorkflowInterrupt
     * @throws WorkflowException
     */
    public function __invoke(SectionGenerationEvent $event, WorkflowState $state): \Generator|SectionGenerationEvent|FormattingReportEvent
    {
        $index = $state->get('current_section', 0);

        if ($index >= \count($event->plan->sections)) {
            // All sections have been generated, move forward
            return new FormattingReportEvent($event->plan);
        }

        $handler = SearchWorkflow::make(new WorkflowState(['query' => $event->plan->sections[$index]->description]))->start();
        foreach ($handler->streamEvents() as $streamedEvent) {
            yield $streamedEvent;
        }
        $searchState = $handler->getResult();

        $prompt = \str_replace('{section_topic}', $event->plan->sections[$index]->description, Prompts::SECTION_WRITER_INSTRUCTIONS);
        $prompt = \str_replace('{context}', \implode("\n", $searchState->get('results')), $prompt);

        yield new ProgressEvent("\n\n========== Generating content for section: {$event->plan->sections[$index]->name} ==========\n\n");

        $stream = ResearchAgent::make()->stream(new UserMessage($prompt));

        foreach ($stream as $text) {
            yield new ProgressEvent($text);
        }

        /** @var AssistantMessage $message */
        $message = $stream->getReturn();

        $event->plan->sections[$index]->content = $message->getContent();

        // Loop back to this node until all sections are processed
        $state->set('current_section', $index + 1);
        return $event;
    }
}