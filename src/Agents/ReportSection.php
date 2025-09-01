<?php

namespace App\Workflow\Agents;

use NeuronAI\StructuredOutput\SchemaProperty;

class ReportSection
{
    #[SchemaProperty(
        description: 'The name of the section',
        required: true
    )]
    public string $name;

    #[SchemaProperty(
        description: 'Brief overview of the main topics covered in this section',
        required: true
    )]
    public string $description;

    #[SchemaProperty(
        description: 'Whether to perform web research for this section of the report',
        required: false
    )]
    public bool $research = false;

    #[SchemaProperty(
        description: 'The content of the section. Leave blank for now.',
        required: true
    )]
    public string $content = '';
}