<?php

namespace App\Agents;

use NeuronAI\StructuredOutput\SchemaProperty;

class SearchQueriesOutput
{
    #[SchemaProperty(
        description: 'The list of search queries.',
        required: true
    )]
    public array $queries = [];
}