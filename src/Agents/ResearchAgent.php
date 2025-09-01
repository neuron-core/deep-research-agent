<?php

namespace App\Workflow\Agents;

use NeuronAI\Agent;
use NeuronAI\Providers\AIProviderInterface;
use NeuronAI\Providers\Anthropic\Anthropic;

class ResearchAgent extends Agent
{
    protected function provider(): AIProviderInterface
    {
        return new Anthropic(
            $_ENV['ANTHROPIC_API_KEY'],
            'claude-3-7-sonnet-latest'
        );
    }
}