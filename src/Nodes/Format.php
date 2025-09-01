<?php

namespace App\Nodes;

use App\Agents\ReportSection;
use App\Agents\ResearchAgent;
use App\Events\ProgressEvent;
use App\Events\FormattingReportEvent;
use App\Prompts;
use NeuronAI\Chat\Messages\UserMessage;
use NeuronAI\Workflow\Node;
use NeuronAI\Workflow\StopEvent;
use NeuronAI\Workflow\WorkflowState;

class Format extends Node
{
    /**
     * @throws \Throwable
     */
    public function __invoke(FormattingReportEvent $event, WorkflowState $state): \Generator|StopEvent
    {
        yield new ProgressEvent("\n\n================= Generating the final report ===============\n\n");

        $prompt = \str_replace(
            '{context}',
            \implode("\n", \array_map(fn(ReportSection $section): string
                => $section->content, $event->reportPlan->sections)
            ),
            Prompts::FINAL_SECTION_WRITER_INSTRUCTIONS
        );

        $response = ResearchAgent::make()
            ->withInstructions(
                "You are an expert writer crafting a section that synthesizes information from the rest of the report. 
                You contribute with Introduction and Summary/Conclusion, and leave a placeholder [section] to be filled with the rest of the report later in time."
            )
            ->chat(new UserMessage($prompt));

        $index = 0;
        $report = \preg_replace_callback(
            '/\[section\]/',
            function($matches) use (&$event, &$index) {
                var_dump($event->reportPlan->sections[$index]);
                return "\n".$event->reportPlan->sections[$index++]->content."\n" ?? '[section]';
            },
            $response->getContent()
        );

        $state->set('report', $report);

        return new StopEvent();
    }
}