<?php

namespace App\Agents;

use NeuronAI\StructuredOutput\SchemaProperty;
use NeuronAI\StructuredOutput\Validation\Rules\ArrayOf;

class ReportPlanOutput
{
    /**
     * @var \App\Agents\ReportSection[]
     */
    #[SchemaProperty(
        description: 'The sections of the report plan',
        required: true
    )]
    #[ArrayOf(ReportSection::class)]
    public array $sections;
}