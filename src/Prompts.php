<?php

namespace App\Workflow;

class Prompts
{
    public const REPORT_PLAN_INSTRUCTIONS = <<<'EOT'
        I want a plan for a report. 
        
        <Task>
        Each section should have the fields:
        
        - name: Name for this section of the report.
        - description: Brief overview of the main topics covered in this section.
        - research: Whether to perform web research for this section of the report.
        - content: The content of the section, which you will leave blank for now.
        
        For example, introduction and conclusion will not require research because they will distill information from other parts of the report.
        </Task>
        
        <Topic>
        The topic of the report is:
        {topic}
        </Topic>
        
        <ReportOrganization>
        The report should follow this organization: 
        Use this structure to create a report on the user-provided topic:
        
        1. Introduction (no research needed)
           - Brief overview of the topic area
        
        2. Main Body Sections:
           - Each section should focus on a sub-topic of the user-provided topic
           
        3. Conclusion
        - Aim for 1 structural element (either a list of table) that distills the main body sections
        - Provide a concise summary of the report
        </ReportOrganization>
        EOT;

    public const SECTION_WRITER_INSTRUCTIONS = <<<'EOT'
        You are an expert writer crafting a section that synthesizes information from the rest of the report.
        
        <SectionTopic> 
        {section_topic}
        </SectionTopic>
        
        <SourceMaterial>
        {context}
        </SourceMaterial>
        
        <LengthAndStyle>
        - Strict 200-300 word limit
        - No marketing language
        - Write in simple, clear language
        - Start with your most important insight in **bold**
        - Use short paragraphs (2-3 sentences max)
        - Use ## for section title (Markdown format)
        - Only use ONE structural element IF it helps clarify your point:
          * Either a focused table comparing 2-3 key items (using Markdown table syntax)
          * Or a short list (3-5 items) using proper Markdown list syntax:
            - Use `*` or `-` for unordered lists
            - Use `1.` for ordered lists
            - Ensure proper indentation and spacing
        - End with ### resources that references the below source material formatted as:
          * List each source with title, date, and URL
          * Format: `- [Title](URL)`
        </LengthAndStyle>
        
        <QualityChecks>
        - Exactly 200-300 words (excluding title and sources)
        - Careful use of only ONE structural element (table or list) and only if it helps clarify your point
        - One specific example / case study
        - Starts with bold insight
        - No preamble prior to creating the section content
        - Sources cited at end
        </QualityChecks>
        EOT;

    public const SEARCH_QUERY_INSTRUCTIONS = <<<'EOT'
        <task_description>
        As a researcher, your job is to get different views of user the query. Generate a series of appropriate search engine queries to break down questions based on user inquiries.
        </task_description>
        
        <Query>
        user query is:
        {query}
        </Query>
        
        <examples>
        <example>
        Input: User asks how to learn programming
        Output: 'programming learning methods, 'programming tutorials for beginners'
        </example>
        
        <example>
        Input: User wants to understand latest technology trends  
        Output: 'tech trends 2021', 'latest technology news'
        </example>
        
        <example>
        Input: User seeks healthy eating advice
        Output: 'healthy eating guide', 'balanced nutrition diet'
        </example>
        </examples>
        
        <instructions>
        1. Take user's question as input.
        2. Identify relevant keywords or phrases based on the topic of user's question.
        3. Use these keywords or phrases to make search engine queries.
        4. Generate a series of appropriate search engine queries to help break down user's question.
        5. Ensure output content does not contain any xml tags.
        6.The output must be pure and conform to the <example> style without other explanations.
        7.Break down into at most 3 subproblems.
        8.Output is separated only by commas.
        </instructions>
        EOT;

    public const FINAL_SECTION_WRITER_INSTRUCTIONS = <<<'EOT'
        You are an expert writer crafting a section that synthesizes information from the rest of the report.
        
        <available_report_content>
        {context}
        </available_report_content>
        
        <Task>
        1. Section-Specific Approach:
        
        For Introduction:
        - Use # for report title (Markdown format)
        - 50-100 word limit
        - Write in simple and clear language
        - Focus on the core motivation for the report in 1-2 paragraphs
        - Use a clear narrative arc to introduce the report
        - Include NO structural elements (no lists or tables)
        - No sources section needed
        
        For Section:
        - leave a placeholder [section] for future use.
        
        For Conclusion/Summary:
        - Use ## for section title (Markdown format)
        - 100-150 word limit
        - For non-comparative reports: 
            * Only use ONE structural element IF it helps distill the points made in the report:
            * Either a focused table comparing items present in the report (using Markdown table syntax)
            * Or a short list using proper Markdown list syntax:
              - Use `*` or `-` for unordered lists
              - Use `1.` for ordered lists
              - Ensure proper indentation and spacing
        - End with specific next steps or implications
        - No sources section needed
        
        3. Writing Approach:
        - Use concrete details over general statements
        - Make every word count
        - Focus on your single most important point
        </Task>
        
        <quality_checks>
        - For introduction: 50-100 word limit, # for report title, no structural elements, no sources section
        - For a section: make sure only leave a placeholder [section].
        - For conclusion: 100-150 word limit, ## for section title, only ONE structural element at most, no sources section
        - Markdown format
        - Do not include word count or any preamble in your response
        </quality_checks>
        EOT;

}