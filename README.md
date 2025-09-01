# Open Deep Research Agent - NeuronAI
This project is inspired by Open Deep Research, which uses LangGraph for implementation. 
Our version leverages [NeuronAI](https://docs.neuron-ai.dev/v2/) to create a powerful, modular workflow for research and analysis.

NeuronAI Open Deep Research provides a structured approach to generating comprehensive research reports on any topic using large language models, 
with a focus on modularity, extensibility, and real-time results.

![](cover.png)

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

## Workflow architecture and Nodes

### DeepResearchAgent: Orchestrates the overall report generation process

- **Planning**: Creates the structure of the report
- **GenerateSectionContent**: Generates content for each section using search results
- **Format**: Compiles the final report

### SearchWorkflow: Handles search operations as a nested workflow

- **GenerateQueries**: Creates search queries based on section topics
- **SearchTheWeb**: Executes parallel searches and processes results