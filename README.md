# Open Deep Research Agent - NeuronAI V2
This project is inspired by Open Deep Research, which uses LangGraph for implementation. 
Our version leverages [NeuronAI](https://docs.neuron-ai.dev/v2/) to create a powerful, modular workflow for research and analysis.

NeuronAI Open Deep Research provides a structured approach to generating comprehensive research reports on any topic using large language models, 
with a focus on modularity, extensibility, and real-time results.

![](cover.png)

## NeuronAI PHP framework
Neuron is an agentic framework that allows you to create full-featured AI Agents in PHP.
It definitively fills the gap for AI Agents development between PHP and other ecosystems like Python or Javascript.

It provides you with a standard toolkit to implement AI-driven applications drastically reducing vendor lock-in.
You can switch between LLMs, vector stores, embedding providers, etc. with just a few lines of code without the
need to refactor big portions of your application.

If you are new to AI Agents development, or you already have experience, Neuron can be the perfect playground
to move your idea from experiments to reliable production implementations.

Checkout the documentation: https://docs.neuron-ai.dev

## Features

- **Modular Workflow Architecture**: Easily extensible with nested workflows
- **Automated Research**: Generate queries and perform web searches
- **Structured Reports**: Create well-organized reports with customizable sections
- **Performance Monitoring**: Track execution time of workflow steps
- **Streaming Results**: Get real-time updates as the report is generated

## How to use this project
Download the project on your machine and open your terminal into the project directory. First, install the composer dependencies:

```
composer install
```

Create a .env file in your project root (see .env.example for a template), and provides the API keys based on 
the service you want to connect with.

```dotenv
ANTHROPIC_API_KEY=
GEMINI_API_KEY=
OPENAI_API_KEY=

TAVILY_API_KEY=[required]

INSPECTOR_INGESTION_KEY=
```

For Windows machine run

```
php .\windows.php
```

For Unix machine run:

```
php unix.php
```

## Workflow architecture and Nodes

### DeepResearchAgent: Orchestrates the overall report generation process

- **Planning**: Creates the structure of the report
- **GenerateSectionContent**: Generates content for each section using search results
- **Format**: Compiles the final report

### SearchWorkflow: Handles search operations as a nested workflow

- **GenerateQueries**: Creates search queries based on section topics
- **SearchTheWeb**: Executes parallel searches and processes results